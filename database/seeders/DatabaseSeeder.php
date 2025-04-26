<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RolSeeder::class,
            PermisosSeeder::class,
            ServicioSeeder::class,
            ModalservicioSeeder::class,
            WatModalSeeder::class,
            MailModalSeeder::class,
            ProductoSeeder::class,
            ReclamacionesSeeder::class,
            ContactanosSeeder::class,
            EmpleadoSeeder::class,
        ]);
    }
}
