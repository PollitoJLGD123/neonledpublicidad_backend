<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Permiso;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roles = Rol::select('id_rol', 'nombre')->get();
            return response()->json([
                'status' => 200,
                'data' => $roles,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Error al obtener roles',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255|unique:roles',
                'permisos' => 'nullable|array',
                'permisos.*' => 'exists:permisos,id_permiso',
            ]);

            $rol = Rol::create([
                'nombre' => $validatedData['nombre'],
            ]);

            if (!empty($validatedData['permisos'])) {
                $rol->permisos()->attach($validatedData['permisos']);
            }

            return response()->json([
                'status' => 201,
                'message' => 'Rol creado correctamente',
                'data' => $rol,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Error al crear rol',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $rol = Rol::with('permisos')->findOrFail($id);
            return response()->json([
                'status' => 200,
                'data' => $rol,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'error' => 'Rol no encontrado',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $rol = Rol::findOrFail($id);
            
            $validatedData = $request->validate([
                'nombre' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('roles')->ignore($id, 'id_rol'),
                ],
                'permisos' => 'nullable|array',
                'permisos.*' => 'exists:permisos,id_permiso',
            ]);

            $rol->update([
                'nombre' => $validatedData['nombre'],
            ]);

            if (isset($validatedData['permisos'])) {
                $rol->permisos()->sync($validatedData['permisos']);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Rol actualizado correctamente',
                'data' => $rol,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e instanceof ModelNotFoundException ? 404 : 500,
                'error' => $e instanceof ModelNotFoundException ? 'Rol no encontrado' : 'Error al actualizar rol',
                'message' => $e->getMessage()
            ], $e instanceof ModelNotFoundException ? 404 : 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $rol = Rol::findOrFail($id);
            
            // verificar si hay empleados con este rol
            if ($rol->empleados()->count() > 0) {
                return response()->json([
                    'status' => 400,
                    'error' => 'No se puede eliminar el rol porque tiene empleados asociados',
                ], 400);
            }
            
            // eliminar la relación con permisos
            $rol->permisos()->detach();
            $rol->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Rol eliminado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500,
                'error' => $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 'Rol no encontrado' : 'Error al eliminar rol',
                'message' => $e->getMessage()
            ], $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500);
        }
    }

    public function getPermisos($id)
    {
        try {
            $rol = Rol::findOrFail($id);
            $permisos = $rol->permisos;
            
            return response()->json([
                'status' => 200,
                'data' => $permisos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'error' => 'Rol no encontrado',
            ], 404);
        }
    }

    public function syncPermisos(Request $request, $id)
    {
        try {
            $rol = Rol::findOrFail($id);
            
            $validatedData = $request->validate([
                'permisos' => 'required|array',
                'permisos.*' => 'exists:permisos,id_permiso',
            ]);

            $rol->permisos()->sync($validatedData['permisos']);

            return response()->json([
                'status' => 200,
                'message' => 'Permisos actualizados correctamente',
                'data' => $rol->permisos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e instanceof ModelNotFoundException ? 404 : 500,
                'error' => $e instanceof ModelNotFoundException ? 'Rol no encontrado' : 'Error al actualizar permisos',
                'message' => $e->getMessage()
            ], $e instanceof ModelNotFoundException ? 404 : 500);
        }
    }
}
