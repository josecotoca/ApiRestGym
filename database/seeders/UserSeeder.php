<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                'name' => 'Administrador',
                'email' => 'admin@fitwork.com',
                'password' => Hash::make('password'),
                'aboutYou' => 'Usuario de prueba para el endpoint de login'
            ]);
    }
}
