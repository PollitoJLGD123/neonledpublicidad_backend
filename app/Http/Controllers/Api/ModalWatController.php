<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\modalservicios;
use App\Models\WatModal;
use App\Mail\MailService;
use Exception;
use Illuminate\Support\Facades\Mail;

class ModalWatController extends Controller
{
    public function sendWat(int $id)
    {
        $data = [
            [
                '👋 ¡Hola! Nos comunicamos contigo para informarte que hemos recibido tu mensaje sobre nuestro Servicio de Diseño y Desarrollo Web. ✅ En breve uno de nuestros especialistas se pondrá en contacto contigo. - Atentamente, el equipo de DigiMedia.',
                '🚀 Gracias por confiar en DigiMedia. Tu solicitud sobre Diseño y Desarrollo Web fue recibida con éxito. 💡 ¡Nos encantará ayudarte a impulsar tus ideas!'
            ],

            [
                '👋 ¡Hola! Hemos recibido tu consulta sobre nuestro Servicio de Gestión de Redes Sociales. ✅ Nuestro equipo la está revisando y se pondrá en contacto contigo pronto. - El equipo de DigiMedia.',
                '💡 Recibimos tu mensaje sobre Gestión de Redes Sociales. Estamos ansiosos por ayudarte a mejorar tu presencia digital. 📢 ¡Nos comunicaremos contigo enseguida!'
            ],

            [
                '👋 ¡Hola! Confirmamos que recibimos tu mensaje sobre nuestro Servicio de Marketing y Gestión Digital. ✅ En breve un asesor te contactará. - Atentamente, DigiMedia.',
                '🎯 Tu solicitud sobre Marketing y Gestión Digital ya está en nuestro sistema. Gracias por preferirnos, pronto te brindaremos más información. 🚀'
            ],

            [
                '👋 ¡Hola! Tu mensaje sobre nuestro Servicio de Branding y Diseño Gráfico fue recibido correctamente. ✅ Pronto uno de nuestros diseñadores te contactará. - DigiMedia.',
                '🎨 Gracias por escribirnos acerca de Branding y Diseño Gráfico. 💡 Estamos listos para ayudarte a construir una marca memorable. ¡Hablamos pronto! 🚀'
            ]
        ];

        $modal_wat = WatModal::find($id);

        if (!$modal_wat) {
            return response()->json(['message' => 'Mensaje no encontrado'], 404);
        }

        $modal = modalservicios::find($modal_wat->id_modalservicio);

        $telefono = $modal->telefono;

        $mensaje = urlencode($data[$modal->id_servicio - 1][$modal_wat->number_message - 1]);

        $url = "https://wa.me/51$telefono?text=$mensaje";

        return redirect()->away($url);
    }

    public function cambiarEstado(Request $request, $id)
    {
        $modal_wat = WatModal::find($id);

        if (!$modal_wat) {
            return response()->json(['message' => 'Mensaje no encontrado'], 404);
        }

        if($request->estado == 1){
            $modal_wat->update([
                'estado' => 1,
                'fecha' => now(),
            ]);
        }
        else{
            $modal_wat->update([
                'estado' => 0,
                'error' => $request->error,
                'fecha' => now(),
            ]);
        }

        return response()->json($modal_wat, 200);

    }
}
