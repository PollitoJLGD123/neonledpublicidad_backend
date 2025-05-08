<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermisoController extends Controller
{
    public function index()
    {
        try {
            $permisos = Permiso::all();
            return response()->json([
                'status' => 200,
                'data' => $permisos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Error al obtener permisos',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255|unique:permisos',
                'descripcion' => 'nullable|string',
            ]);

            $validatedData['slug'] = Str::slug($validatedData['nombre']);

            $permiso = Permiso::create($validatedData);

            return response()->json([
                'status' => 201,
                'message' => 'Permiso creado correctamente',
                'data' => $permiso,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Error al crear permiso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $permiso = Permiso::findOrFail($id);
            return response()->json([
                'status' => 200,
                'data' => $permiso,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'error' => 'Permiso no encontrado',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $permiso = Permiso::findOrFail($id);
            
            $validatedData = $request->validate([
                'nombre' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('permisos')->ignore($id, 'id_permiso'),
                ],
                'descripcion' => 'nullable|string',
            ]);

            if ($request->nombre !== $permiso->nombre) {
                $validatedData['slug'] = Str::slug($validatedData['nombre']);
            }

            $permiso->update($validatedData);

            return response()->json([
                'status' => 200,
                'message' => 'Permiso actualizado correctamente',
                'data' => $permiso,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e instanceof ModelNotFoundException ? 404 : 500,
                'error' => $e instanceof ModelNotFoundException ? 'Permiso no encontrado' : 'Error al actualizar permiso',
                'message' => $e->getMessage()
            ], $e instanceof ModelNotFoundException ? 404 : 500);
        }
    }

    public function destroy($id)
    {
        try {
            $permiso = Permiso::findOrFail($id);
            $permiso->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Permiso eliminado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e instanceof ModelNotFoundException ? 404 : 500,
                'error' => $e instanceof ModelNotFoundException ? 'Permiso no encontrado' : 'Error al eliminar permiso',
                'message' => $e->getMessage()
            ], $e instanceof ModelNotFoundException ? 404 : 500);
        }
    }

}
