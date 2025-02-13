<?php

namespace App\Jobs;

use App\Mail\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendEmailJob implements ShouldQueue
{
    use Queueable;

    public $indice;
    public $servicio_id;
    public $mailto;

    public function __construct($indice, $servicio_id, $mailto)
    {

        $this->indice = $indice;
        $this->servicio_id = $servicio_id;
        $this->mailto = $mailto;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {


        $imagenes_main = [
            // Desarrollo y Diseño
            [
                "",
                "",
                ""
            ],
            // Gestión de Redes Sociales
            [
                "",
                "",
                ""
            ],
            // Marketing y Gestión Digital
            [
                "",
                "",
                ""
            ],
            // Branding y Diseño
            [
                "",
                "",
                ""
            ],
        ];

        $title = [
            // Desarrollo y Diseño
            [
                "",
                "",
                ""
            ],
            // Gestión de Redes Sociales
            [
                "",
                "",
                ""
            ],
            // Marketing y Gestión Digital
            [
                "",
                "",
                ""
            ],
            // Branding y Diseño
            [
                "",
                "",
                ""
            ],
        ];

        $subject = [
            // Desarrollo y Diseño

            [
                "",
                "",
                ""
            ],
            // Gestión de Redes Sociales
            [
                "",
                "",
                ""
            ],
            // Marketing y Gestión Digital
            [
                "",
                "",
                ""
            ],
            // Branding y Diseño
            [
                "",
                "",
                ""
            ],
        ];

        $menssage = [
            // Desarrollo y Diseño
            [
                "",
                "",
                ""
            ],
            // Gestión de Redes Sociales
            [
                "",
                "",
                ""
            ],
            // Marketing y Gestión Digital
            [
                "",
                "",
                ""
            ],
            // Branding y Diseño
            [
                "",
                "",
                ""
            ],
        ];

        try {
            // Validar índices
            if (!isset($this->servicio_id) || $this->servicio_id < 1 || $this->servicio_id > 4) {
                throw new \Exception("servicio_id inválido");
            }

            $serviceIndex = $this->servicio_id - 1;
            $messageIndex = $this->indice;

            // Validar existencia de datos
            if (
                !isset($menssage[$serviceIndex][$messageIndex]) ||
                !isset($title[$serviceIndex][$messageIndex]) ||
                !isset($imagenes_main[$serviceIndex][$messageIndex]) ||
                !isset($subject[$serviceIndex][$messageIndex])
            ) {
                throw new \Exception("Índices no válidos para los arrays de contenido");
            }

            // Un solo envío de email con datos validados
            Mail::to($this->mailto)->send(new MailService(
                strval($menssage[$serviceIndex][$messageIndex]),
                strval($title[$serviceIndex][$messageIndex]),
                strval($imagenes_main[$serviceIndex][$messageIndex]),
                strval($subject[$serviceIndex][$messageIndex])
            ));
        } catch (\Exception $e) {
            Log::error("Error en SendEmailJob: {$this->servicio_id} - " . $e->getMessage());
        }
    }

    public function failed(Throwable $exception)
    {
        Log::error("Error en SendEmailJob: " . $this->servicio_id);
    }
}
