<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Verifica se já existe um administrador. Se não houver, cria um
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'administrador',
                'email' => env('ADMIN_EMAIL', 'admin@rhmangnt.com'),
                'email_verified_at' => now(),
                'password' => bcrypt(env('ADMIN_PASSWORD', 'Aa123456')),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info('Admin user created with email: ' . env('ADMIN_EMAIL', 'admin@rhmangnt.com'));
        } else {
            $this->command->info('Admin user already exists. Skipping admin creation.');
        }

        // Criar usuários comuns usando Faker
        User::factory()->count(10)->create();

        $this->command->info('50 regular users created successfully.');
    }
}
