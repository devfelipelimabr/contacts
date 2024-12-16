<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin); // Autentica como administrador

        $response = $this->post('/users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    public function test_non_admin_cannot_create_user()
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user);

        $response = $this->post('/users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_update_other_users()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1);

        $response = $this->put('/users/' . $user2->id, [
            'name' => 'Invalid Update',
        ]);

        $response->assertStatus(403);
    }
}
