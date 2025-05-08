<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Cloudinary\Cloudinary;
use App\Mail\CredencialesEmpleadoMail;
use Illuminate\Support\Facades\Auth;


class EmpleadoController extends Controller
{

    private const RESTRICTED_EMAILS = [
        "joseluisjlgd123@gmail.com",
        "keving.kpg@gmail.com",
        "tmlighting@hotmail.com"
    ];

    private const PRIVILEGED_EMAIL = "tmlighting@hotmail.com";

    private function hasPermissionToModify($employeeEmail, $employeeId)
    {
        $user = Auth::user();
        $authenticatedUserEmail = $user->email;
        $empleadoUsuario = Empleado::where('id_user', $user->id)->first();
        $editarMiPerfil = $empleadoUsuario && $empleadoUsuario->id_empleado == $employeeId;

        if ($authenticatedUserEmail === self::PRIVILEGED_EMAIL) {
            return true;
        }
        if ($editarMiPerfil) {
            return true;
        }
        return !in_array($employeeEmail, self::RESTRICTED_EMAILS);
    }

    private function checkPermissionMiddleware($id)
    {
        $empleado = Empleado::where('id_empleado', $id)->first();

        if (!$empleado) {
            return response()->json([
                "status" => 404,
                "message" => "Empleado no encontrado"
            ], 404);
        }

        if (!$this->hasPermissionToModify($empleado->email, $id)) {
            Log::warning("Intento no autorizado de modificar empleado restringido", [
                'target_id' => $id,
                'target_email' => $empleado->email,
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email
            ]);

            return response()->json([
                "status" => 403,
                "message" => "No tienes permiso para modificar este empleado"
            ], 403);
        }

        return null;
    }

    public function getById($id)
    {
        $validate = Validator::make(["id" => $id], [
            "id" => "required|numeric",
        ]);

        if ($validate->fails()) {
            return response()->json(["status" => 422, "message" => "Error de validación", "Errors" => $validate->errors()]);
        }

        $empleado = Empleado::with('rol')->where('id_empleado', $id)->first();

        if (!$empleado) {
            return response()->json(["status" => 404, "message" => "Empleado no encontrado"]);
        }

        return response()->json([
            "status" => 200,
            "data" => $empleado
        ]);
    }

    public function getAllByPage(Request $request)
    {
        try {
            $empleados = Empleado::with('rol')->orderBy('id_empleado', 'asc')->paginate(5);
            $empleados->getCollection()->transform(function ($empleado) {
                return [
                    'id_empleado' => $empleado->id_empleado,
                    'nombre' => $empleado->nombre,
                    'apellido' => $empleado->apellido,
                    'email' => $empleado->email,
                    'dni' => $empleado->dni,
                    'telefono' => $empleado->telefono,
                    'rol' => $empleado->rol->nombre,
                ];
            });

            return response()->json([
                "status" => 200,
                'data' => $empleados->items(),
                'total' => $empleados->total(),
                'page' => $empleados->currentPage()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => "Error interno del servidor",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:empleados|unique:users',
            'dni' => 'required|string|max:20|unique:empleados',
            'telefono' => 'nullable|string|max:20',
            'id_rol' => 'required|exists:roles,id_rol',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {

            $password = $this->createPassword($request->dni, $request->nombre, $request->apellido);

            $user = User::create([
                'name' => $request->nombre . ' ' . $request->apellido,
                'email' => $request->email,
                'password' => Hash::make($password),
            ]);

            $empleado = Empleado::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'dni' => $request->dni,
                'telefono' => $request->telefono,
                'id_user' => $user->id,
                'id_rol' => $request->id_rol,
            ]);

            DB::commit();

            Mail::to($user->email)->send(new CredencialesEmpleadoMail($user, $password));

            return response()->json([
                "status" => 200,
                "message" => "Empleado creado correctamente",
                "user" => $user,
                "empleado" => $empleado,
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "status" => 500,
                "message" => "Error al crear empleado",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    private function createPassword(string $dni, string $nombre, string $apellidos)
    {

        $apellidoIniciales = strtoupper(substr($nombre, 0, 2));
        $nombreIniciales = strtolower(substr($apellidos, 0, 2));
        $dniParte = substr($dni, -3);

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        $password= "{$apellidoIniciales}{$dniParte}";

        for ($i = 0; $i < 5; $i++) {
            $password .= $characters[rand(0, $charactersLength - 1)];
        }

        $password .= $nombreIniciales;

        return $password;
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make(["id" => $id], [
            "id" => "required|numeric",
        ]);

        if ($validate->fails()) {
            return response()->json([
                "status" => 422,
                "message" => "Error de validación",
                "Errors" => $validate->errors()
            ]);
        }

        $permissionCheck = $this->checkPermissionMiddleware($id);
        if ($permissionCheck) {
            return $permissionCheck;
        }

        $empleado = Empleado::where('id_empleado', $id)->first();

        if (!$empleado) {
            return response()->json([
                "status" => 404,
                "message" => "Empleado no encontrado"
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nombre'    => 'sometimes|string|max:255',
            'apellido'  => 'sometimes|string|max:255',
            'email'     => 'sometimes|string|email|max:255|unique:empleados,email,' . $id . ',id_empleado|unique:users,email,' . $empleado->id_user,
            'dni'       => 'sometimes|string|max:20|unique:empleados,dni,' . $id . ',id_empleado',
            'telefono'  => 'nullable|string|max:20',
            'id_rol'    => 'sometimes|exists:roles,id_rol',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($empleado->id_user);

        if ($user) {
            if ($request->has('email') && $request->email != $empleado->email) {
                $user->email = $request->email;
            }

            if (
                ($request->has('nombre') && $request->nombre != $empleado->nombre) ||
                ($request->has('apellido') && $request->apellido != $empleado->apellido)
            ) {
                $nombre   = $request->has('nombre') ? $request->nombre : $empleado->nombre;
                $apellido = $request->has('apellido') ? $request->apellido : $empleado->apellido;
                $user->name = $nombre . ' ' . $apellido;
            }

            $user->save();
        }

        $empleado->update($request->all());

        return response()->json([
            "status"  => 200,
            "message" => "Empleado actualizado correctamente",
            "data"    => $empleado
        ]);
    }


    public function updateProfileImage(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'public_id' => 'required|string',
            'secure_url' => 'required|url'
        ]);

        if ($validate->fails()) {
            return response()->json([
                "status" => 422,
                "message" => "Error de validación",
                "errors" => $validate->errors()
            ], 422);
        }

        try {
            $empleado = Empleado::where('id_empleado', $id)->first();
            if (!$empleado) {
                return response()->json([
                    "status" => 404,
                    "message" => "Empleado no encontrado"
                ], 404);
            }

            DB::beginTransaction();

            if ($empleado->imagen_perfil) {
                try {

                    $cloudinary = new Cloudinary();

                    $result = $cloudinary->uploadApi()->destroy($empleado->imagen_perfil);

                } catch (\Exception $e) {
                    Log::warning("Error al eliminar imagen anterior, continuando con actualización: " . $e->getMessage());
                }
            }

            $empleado->imagen_perfil_url = null;
            $empleado->imagen_perfil = $request->public_id;
            $empleado->imagen_perfil_url = $request->secure_url;
            $empleado->save();

            DB::commit();

            return response()->json([
                "status" => 200,
                "message" => "Imagen actualizada correctamente",
                "data" => [
                    'public_id' => $empleado->imagen_perfil,
                    'url' => $empleado->imagen_perfil_url,
                    'version' => time()
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Error actualizando imagen: " . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                "status" => 500,
                "message" => "Error al actualizar la imagen",
                "error" => env('APP_DEBUG') ? $e->getMessage() : 'Error interno del servidor'
            ], 500);
        }
    }


    public function updatePass(Request $request, $id)
    {
        $validate = Validator::make(["id" => $id], [
            "id" => "required|numeric",
        ]);

        if ($validate->fails()) {
            return response()->json(["status" => 422, "message" => "Error de validación", "Errors" => $validate->errors()]);
        }

        $empleado = Empleado::where('id_empleado', $id)->first();

        if (!$empleado) {
            return response()->json(["status" => 404, "message" => "Empleado no encontrado"]);
        }

        $userId = $empleado->id_user;

        return $this->updatePass1($request, $userId);
    }

    private function updatePass1(Request $request, $id)
    {
        $validate = Validator::make(["id" => $request->id], [
            "id" => "required|numeric",
        ]);

        if ($validate->fails()) {
            return response()->json(["status" => 422, "message" => "Error de validación", "Errors" => $validate->errors()]);
        }

        $validate = Validator::make($request->all(), [
            "password" => "required|string|min:4",
        ]);

        if ($validate->fails()) {
            return response()->json(["status" => 422, "message" => "Error de validación", "Errors" => $validate->errors(), "data" => $request->all()]);
        }

        $response = User::where(["id" => intval($id)])->update(["password" => Hash::make($request->password)]);

        if ($response) {
            return response()->json(["status" => 200, "message" => "Registro actualizado correctamente"]);
        }
    }

    public function verifyPassword(Request $request)
    {
        try {
            $request->validate([
                'currentPassword' => 'required',
                'id_empleado' => 'required|exists:empleados,id_empleado'
            ]);

            $empleado = Empleado::with('user')->findOrFail($request->id_empleado);

            if (!$empleado->user) {
                return response()->json([
                    'valid' => false,
                    'message' => 'No se encontró el usuario asociado al empleado'
                ], 404);
            }

            if (!Hash::check($request->currentPassword, $empleado->user->password)) {
                return response()->json([
                    'valid' => false,
                    'message' => 'La contraseña actual es incorrecta'
                ], 400);
            }

            return response()->json([
                'valid' => true,
                'message' => 'Contraseña verificada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al procesar la solicitud',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        $validate = Validator::make(["id" => $id], [
            "id" => "required|numeric",
        ]);

        if ($validate->fails()) {
            Log::error("Validación fallida: ", $validate->errors()->toArray());
            return response()->json([
                "status" => 422,
                "message" => "Error de validación",
                "errors" => $validate->errors()
            ], 422);
        }

        $permissionCheck = $this->checkPermissionMiddleware($id);
        if ($permissionCheck) {
            return $permissionCheck;
        }

        $empleado = Empleado::where('id_empleado', $id)->first();

        if (!$empleado) {
            return response()->json([
                "status" => 404,
                "message" => "Empleado no encontrado"
            ], 404);
        }


        $user = User::find($empleado->id_user);
        if ($user) {
            Log::info("Eliminando usuario vinculado con ID: " . $user->id);
            $user->delete();
        }

        Log::info("Eliminando empleado con ID: $id");
        $empleado->delete();

        Log::info("Empleado eliminado correctamente");
        return response()->json([
            "status" => 200,
            "message" => "Empleado eliminado correctamente"
        ], 200);
    }

    public function deleteProfileImage($id)
    {
        try {
            $empleado = Empleado::where('id_empleado', $id)->first();

            if (!$empleado) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Empleado no encontrado'
                ], 404);
            }

            if ($empleado->imagen_perfil) {
                Log::info('Intentando eliminar imagen de perfil:', ['public_id' => $empleado->imagen_perfil]);

                try {
                    $cloudinary = new Cloudinary();

                    $result = $cloudinary->uploadApi()->destroy($empleado->imagen_perfil);
                    Log::info('Resultado de eliminación:', ['result' => $result]);
                } catch (\Exception $e) {
                    Log::warning("Error al eliminar imagen de Cloudinary: " . $e->getMessage());
                    // Continuamos con la actualización en la base de datos
                }

                $empleado->imagen_perfil = null;
                $empleado->imagen_perfil_url = null;
                $empleado->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Imagen eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error("Error eliminando imagen de perfil: " . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 500,
                'message' => 'Error al eliminar la imagen',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Error interno del servidor'
            ], 500);
        }
    }
}
