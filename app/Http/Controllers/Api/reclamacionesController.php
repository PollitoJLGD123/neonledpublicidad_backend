<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reclamaciones;

class ReclamacionesController extends Controller
{
    /**
     * Obtener todas las reclamaciones con paginación.
     */
    public function get()
    {
        try {
            $reclamaciones = Reclamaciones::orderBy('id', 'desc')->paginate(20);
            return response()->json($reclamaciones);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las reclamaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva reclamación.
     */
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'telefono' => 'required|string|max:20',
                'departamento' => 'required|string|max:100',
                'direccion' => 'required|string|max:250',
                'distrito' => 'required|string|max:250',
                'tipo_servicio' => 'required|string|max:50',
                'fecha_incidente' => 'required|date', // Validar como fecha
                'monto_reclamado' => 'required|numeric', // Validar como número decimal
                'descripcion_servicio' => 'required|string',
                'declaracion_veraz' => 'required|boolean', // Validar como booleano
                'acepta_politica' => 'required|accepted', // Validar como aceptado
                'estado' => 'nullable|string|max:50', // Estado es opcional (tiene valor predeterminado)
            ]);

            // Asignar valores predeterminados si no se proporcionan
            $validated['estado'] = $validated['estado'] ?? 'pendiente';
            $validated['declaracion_veraz'] = $validated['declaracion_veraz'] ?? false;

            $reclamacion = Reclamaciones::create($validated);

            return response()->json([
                'message' => 'Reclamación creada exitosamente',
                'data' => $reclamacion
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la reclamación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una reclamación por ID.
     */
    public function delete($id)
    {
        try {
            $reclamacion = Reclamaciones::findOrFail($id);
            $reclamacion->delete();

            return response()->json([
                'message' => 'Reclamación eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la reclamación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}