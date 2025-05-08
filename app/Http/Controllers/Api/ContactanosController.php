<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contactanos;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContactanosController extends Controller
{
    public function get(Request $request)
    {
        $contactos = Contactanos::paginate(4);
        return response()->json($contactos, 200);
    }

    public function getById($id)
    {
        $contacto = Contactanos::find($id);

        if (!$contacto) {
            return response()->json(['error' => 'Contacto no encontrado'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $contacto
        ], 200);
    }

    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'distrito' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'detalle_reclamacion' => 'required|string|max:1050',
            'mensaje' => 'required|string|max:1050',
        ]);

        if($validated->fails()){
            return response()->json(['errors' => $validated->errors()], 400);
        }

        $data = $request->all();
        $data['estado'] = 0; // Estado inicial (pendiente)
        $data['fecha_hora'] = Carbon::now();
        
        Contactanos::create($data);

        return response()->json([
            'status' => 201,
            'message' => 'Contacto guardado exitosamente'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $contacto = Contactanos::find($id);

        if (!$contacto) {
            return response()->json(['error' => 'Contacto no encontrado'], 404);
        }

        $validated = $request->validate([
            'estado' => 'required|boolean',
        ]);

        $contacto->update([
            'estado' => $request->estado,
            'fecha_hora_actualizacion' => Carbon::now()
        ]);

        return response()->json([
            'message' => 'Estado actualizado exitosamente',
            'data' => $contacto,
        ], 200);
    }

    public function delete($id)
    {
        $contacto = Contactanos::find($id);

        if (!$contacto) {
            return response()->json(['error' => 'Contacto no encontrado'], 404);
        }

        $contacto->delete();

        return response()->json([
            'message' => 'Contacto eliminado exitosamente'
        ], 200);
    }
}