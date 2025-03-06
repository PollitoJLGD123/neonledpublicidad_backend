<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReclamacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reclamaciones = [
            [
                'nombre' => 'Juan',
                'apellido' => 'Perez',
                'email' => 'juan.perez@example.com',
                'telefono' => '987654321',
                'departamento' => 'Lima',
                'direccion' => 'Av. Siempre Viva 123',
                'distrito' => 'Miraflores',
                'tipo_servicio' => 'Digital',
                'fecha_incidente' => Carbon::now()->subDays(10),
                'monto_reclamado' => 150.75,
                'descripcion_servicio' => 'Falla de letras iluminadas',
                'declaracion_veraz' => true,
                'acepta_politica' => true,
                'estado' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Maria',
                'apellido' => 'Gonzalez',
                'email' => 'maria.gonzalez@example.com',
                'telefono' => '987123456',
                'departamento' => 'Arequipa',
                'direccion' => 'Jr. Las Palmeras 456',
                'distrito' => 'Cayma',
                'tipo_servicio' => 'Acompañamiento redes',
                'fecha_incidente' => Carbon::now()->subDays(5),
                'monto_reclamado' => 200.50,
                'descripcion_servicio' => 'Cobro indebido en la factura mensual.',
                'declaracion_veraz' => true,
                'acepta_politica' => true,
                'estado' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('reclamacion')->insert($reclamaciones);
    }
}
