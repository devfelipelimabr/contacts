<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Certifique-se de que existem usuários no BD
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Run UserSeeder first.');
            return;
        }

        // Cria contatos para cada usuário existente
        foreach ($users as $user) {
            Contact::factory()->count(100)->create([
                'user_id' => $user->id, // Associa o contato ao usuário
            ]);
        }

        $this->command->info('Contacts seeded successfully.');
    }
}
