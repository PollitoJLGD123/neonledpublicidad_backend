<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuariosController extends Controller
{
    public function getAllByPage(Request $request)
    {

        $page = 1;
        $perPage = 2;

        $validate = Validator::make($request->all(), [
            "page" => "required|numeric"
        ]);

        if (!$validate->fails()) {
            $page = intval($request->query("page"));
        }

        $users = User::orderBy('created_at', 'desc')->forPage($page, $perPage)->get();

        return response()->json(["status" => 200, "data" => $users]);
    }

    public function login(Request $request)
    {

        $validate = Validator::make($request->all(), [
            "email" => "required|email|exists:users,email",
            "password" => "required|string|min:4",
        ]);

        if ($validate->fails()) return response()->json(["status" => 422, "message" => "fallo de validacion", "errores" => $validate->errors()]);


        $credentials = ['email' => $request->email, 'password' => $request->password];


        

        return response()->json(["status" => 200, "token" => compact('token')["token"], "data" => User::where("email", $request->email)->first()]);
    }

    public function create(Request $request)
    {

        $validate = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:4",
        ]);

        if ($validate->fails()) return response()->json(["status" => 422, "message" => "Error de validación", "Errors" => $validate->errors()]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->remember_token = Hash::make(Str::random(25));

        $response = $user->save();

        if ($response) return response()->json(["status" => 200, "message" => "Registro creado correctamente"]);
    }

    public function update(Request $request, $id)
    {

        $validate = Validator::make(["id" => $request->id], [
            "id" => "required|numeric",
        ]);
        if ($validate->fails()) return response()->json(["status" => 422, "message" => "Error de validación", "Errors" => $validate->errors()]);

        $validate = Validator::make($request->all(), [
            "name" => "required|string|max:255",
        ]);
        if ($validate->fails()) return response()->json(["status" => 422, "message" => "Error de validación", "Errors" => $validate->errors()]);


        $response = User::where(["id" => intval($id)])->update(["name" => $request->name]);

        if ($response) return response()->json(["status" => 200, "message" => "Registro actualizado correctamente"]);
    }

    public function updatePass(Request $request, $id)
    {

        $validate = Validator::make(["id" => $request->id], [
            "id" => "required|numeric",
        ]);
        if ($validate->fails()) return response()->json(["status" => 422, "message" => "Error de validación", "Errors" => $validate->errors()]);

        $validate = Validator::make($request->all(), [
            "password" => "required|string|min:4",
        ]);
        if ($validate->fails()) return response()->json(["status" => 422, "message" => "Error de validación", "Errors" => $validate->errors()]);

        $response = User::where(["id" => intval($id)])->update(["password" => Hash::make($request->password)]);

        if ($response) return response()->json(["status" => 200, "message" => "Registro actualizado correctamente"]);
    }

    public function delete(Request $request, $id)
    {
 
        $validate = Validator::make(["id" => $id], [
            "id" => "required|numeric",
        ]);
        if ($validate->fails()) return response()->json(["status" => 422, "message" => "Error de validación", "Errors" => $validate->errors()]);

        $response = User::where(["id" => intval($id)])->delete();

        if ($response) return response()->json(["status" => 200, "message" => "Registro eliminado correctamente"]);
    }
}
