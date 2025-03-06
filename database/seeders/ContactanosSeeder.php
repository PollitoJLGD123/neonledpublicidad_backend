<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContactanosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactanos = [
            [
                'nombre' => 'Carlos',
                'apellido' => 'Ramirez',
                'telefono' => '987654321',
                'distrito' => 'San Isidro',
                'email' => 'carlos.ramirez@example.com',
                'tipo_reclamo' => 'Reclamo',
                'mensaje' => 'Tuve un problema con la atención en la sucursal.',
                'estado' => 1,
                'fecha_hora' => Carbon::now(),
                'fecha_hora_actualizacion' => null,
            ],
            [
                'nombre' => 'Lucia',
                'apellido' => 'Fernandez',
                'telefono' => '987123456',
                'distrito' => 'Surco',
                'email' => 'lucia.fernandez@example.com',
                'tipo_reclamo' => 'Consulta',
                'mensaje' => '¿Cual es el precio de las letras acrílicas?',
                'estado' => 1,
                'fecha_hora' => Carbon::now()->subDays(2),
                'fecha_hora_actualizacion' => Carbon::now()
            ],
        ];

        DB::table('contactanos')->insert($contactanos);
    }
}
