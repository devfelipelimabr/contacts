<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_view_and_datatables_data()
    {
        $user = User::factory()->create();
        $contacts = Contact::factory()->count(5)->create(['user_id' => $user->id]);

        // Test the view
        $this->actingAs($user)
            ->get(route('contacts.index'))
            ->assertOk()
            ->assertViewIs('contacts.index');

        $response = $this->getJson(route('contacts.index'));
        $response->assertStatus(200);
    }

    public function test_show_returns_correct_contact()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('contacts.show', $contact->id))
            ->assertOk()
            ->assertViewHas('contact', $contact);
    }

    public function test_show_denies_unauthorized_access()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2)
            ->get(route('contacts.show', $contact->id))
            ->assertForbidden();
    }

    public function test_create_returns_view()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('contacts.create'))
            ->assertOk()
            ->assertViewIs('contacts.create');
    }

    public function test_store_creates_new_contact()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Test Contact',
            'phone' => '123456789',
            'email' => 'test@example.com',
        ];

        $this->actingAs($user)
            ->post(route('contacts.store'), $data)
            ->assertRedirect(route('contacts.index'));

        $this->assertDatabaseHas('contacts', [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'user_id' => $user->id,
        ]);
    }

    public function test_store_validates_input()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Test',
            'phone' => '12345678',
            'email' => 'invalid-email',
        ];

        $this->actingAs($user)
            ->post(route('contacts.store'), $data)
            ->assertSessionHasErrors(['name', 'phone', 'email']);
    }

    public function test_store_prevents_duplicate_phone_and_email()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id, 'phone' => '123456789', 'email' => 'test@example.com']);

        $data = [
            'name' => 'Duplicate Contact',
            'phone' => '123456789',
            'email' => 'test@example.com',
        ];

        $this->actingAs($user)
            ->post(route('contacts.store'), $data)
            ->assertSessionHasErrors(['phone', 'email']);
    }

    public function test_edit_returns_view_with_contact_data()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('contacts.edit', $contact->id))
            ->assertOk()
            ->assertViewHas('contact', $contact);
    }

    public function test_edit_denies_unauthorized_access()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2)
            ->get(route('contacts.edit', $contact->id))
            ->assertForbidden();
    }

    public function test_update_updates_contact()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);
        $newData = [
            'name' => 'Updated Contact',
            'phone' => '987654321',
            'email' => 'updated@example.com',
        ];

        $this->actingAs($user)
            ->put(route('contacts.update', $contact->id), $newData)
            ->assertRedirect(route('contacts.index'));

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => $newData['name'],
            'phone' => $newData['phone'],
            'email' => $newData['email'],
            'user_id' => $user->id,
        ]);
    }

    public function test_update_validates_input()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);
        $invalidData = [
            'name' => 'Short',
            'phone' => '12345678',
            'email' => 'invalid-email',
        ];

        $this->actingAs($user)
            ->put(route('contacts.update', $contact->id), $invalidData)
            ->assertSessionHasErrors(['name', 'phone', 'email']);
    }

    public function test_destroy_soft_deletes_contact()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete(route('contacts.destroy', $contact->id))
            ->assertJson(['message' => 'Contact deleted successfully.']);

        $this->assertSoftDeleted('contacts', ['id' => $contact->id]);
    }

    public function test_destroy_denies_unauthorized_access()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2)
            ->delete(route('contacts.destroy', $contact->id))
            ->assertForbidden();
    }
}
