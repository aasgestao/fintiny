<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email', 'aasgestao@gmail.com')->first()){
                User::create([
                'name' => 'André Alexandre',
                'email' => 'aasgestao@gmail.com',
                'perfil'=> 'Admin',
                'password' => Hash::make('123456'),
            ]);
        }

        if (!User::where('email', 'aasgconsultoria@gmail.com')->first()) {
            User::create([
                'name' => 'Usuario 2',
                'email' => 'aasgconsultoria@gmail.com',
                'perfil' => 'Admin',
                'password' => Hash::make('123456'),
            ]);
        }
        
    }
}
