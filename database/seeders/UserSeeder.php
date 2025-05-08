<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Kevin',
                'email' => 'keving.kpg@gmail.com',
                'password' => Hash::make('F@Q#n64QuJm%'),
            ],
            [
                'name' => 'Jose Luis',
                'email' => 'joseluisjlgd123@gmail.com',
                'password' => Hash::make('j8#m2%Q2g2SW'),
            ],
            [
                'name' => 'Juan Carlos',
                'email' => 'tmlighting@hotmail.com',
                'password' => Hash::make('Vqw&Kk4o$Q7c'),
            ],
            [
                'name' => 'Krizzia Martina',
                'email' => 'krizzia_saavedra201@hotmail.com',
                'password' => Hash::make('2XQsrPELv$&Y'),
            ],
            [
                'name' => 'Gonzalo Fernando',
                'email' => 'gogozgallardo22@gmail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Piero Alexander',
                'email' => 'pierocatacorayt13@gmail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Pedro David',
                'email' => 'delacruz0e72ef@outlook.com',
                'password' => Hash::make('12345678'),
            ]
        ];

        DB::table('users')->insert($users);
    }
}
