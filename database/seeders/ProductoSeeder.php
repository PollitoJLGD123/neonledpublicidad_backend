<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            [
                "nombre" => "Panel LED 60x60",
                "descripcion" => "Panel LED de alta eficiencia para iluminación comercial",
            ],
            [
                "nombre" => "Letras Iluminadas",
                "descripcion" => "Letras corpóreas iluminadas con tecnología LED",
            ],
            [
                "nombre" => "Letras Alto Relieve",
                "descripcion" => "Letras corpóreas en alto relieve para fachadas",
            ],
            [
                "nombre" => "Letras en Acrílico",
                "descripcion" => "Letras corpóreas en acrílico para fachadas",
            ]
        ];

        DB::table('productos')->insert($productos);
    }
}
