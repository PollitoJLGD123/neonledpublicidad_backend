<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Jose Luis',
                'email' => 'joseluis@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'remember_token' => null,
            ],
            
            [
                'name' => 'Gonzalo',
                'email' => 'gonzalo@example.com',
                'email_verified_at' => null,
                'password' => Hash::make('12345678'),
                'remember_token' => null,
            ],

            [
                'name' => 'Kevin',
                'email' => 'kevin@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('1234'),
                'remember_token' => null,
            ],

        ];

        DB::table('users')->insert($users);
    }
}
