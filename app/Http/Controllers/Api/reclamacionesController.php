<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reclamacion;

class ReclamacionController extends Controller
{
    /**
     * Obtener todas las reclamaciones con paginación.
     */
    public function get()
    {
        try {
            $reclamaciones = Reclamacion::orderBy('id_reclamacion', 'desc')->paginate(20);
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
                'fecha_incidente' => 'required|date',
                'monto_reclamado' => 'required|numeric',
                'descripcion_servicio' => 'required|string',
                'declaracion_veraz' => 'required|boolean',
                'acepta_politica' => 'required|accepted',
                'estado' => 'nullable|string',
            ]);

            $reclamacion = Reclamacion::create($validated);

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
            $reclamacion = Reclamacion::findOrFail($id);
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
