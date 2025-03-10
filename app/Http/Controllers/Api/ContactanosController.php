<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contactanos;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ContactanosController extends Controller
{
    // Obtener la lista de contactos con paginación
    public function get()
    {
        $contactos = Contactanos::paginate(20); // Devuelve contactos paginados de 20 en 20
        return response()->json($contactos, 200);
    }

    // Crear un nuevo contacto
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:250',
            'apellido' => 'required|string|max:250',
            'telefono' => 'required|string|max:20',
            'distrito' => 'required|string|max:250',
            'email' => 'required|email|max:250',
            'tipo_reclamo' => 'required|string|max:50',
            'mensaje' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $contacto = Contactanos::create(array_merge($request->all(), [
            'fecha_hora' => Carbon::now(),
            'fecha_hora_actualizacion' => Carbon::now(),
            'estado' => '0'
        ]));

        return response()->json(['message' => 'Contacto creado con éxito', 'contacto' => $contacto], 201);
    }

    public function updateEstado($id)
    {
        $contacto = Contactanos::findOrFail($id);

        if (!$contacto) {
            return response()->json(['message' => 'Contacto no encontrado'], 404);
        }

        $contacto->estado = '1';
        $contacto->save();

        return response()->json(['message' => 'Estado actualizado con éxito', 'contacto' => $contacto], 200);
    }

    // Eliminar un contacto
    public function delete($id)
    {
        $contacto = Contactanos::find($id);

        if (!$contacto) {
            return response()->json(['message' => 'Contacto no encontrado'], 404);
        }

        $contacto->delete();
        return response()->json(['message' => 'Contacto eliminado con éxito'], 200);
    }
}
