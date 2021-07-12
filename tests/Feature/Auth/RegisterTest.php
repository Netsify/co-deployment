<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_register_page()
    {
        $this->assertGuest();

        $response = $this->get(route('register'));

        $response->assertStatus(200);

        $response->assertViewIs('auth.register');
    }

    public function test_user_cannot_view_register_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('register'));

        $response->assertRedirect(route('main'));
    }

    public function test_validated_user_can_register()
    {

        $user = User::factory()->create();

        $response = $this->post(route('register'), [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'role' => $user->role_id,
            'email' => 'testemail@email.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertRedirect(route('main'));

        $this->assertAuthenticated();
    }

    public function test_invalidated_user_cannot_register()
    {
        $user = User::factory()->create();

        $response = $this->post(route('register'), [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'role' => $user->role_id,
            'email' => 'testemail@email.com',
            'password' => 'password',
            'password_confirmation' => 'invalid'
        ]);

        $response->assertSessionHasErrors();

        $this->assertGuest();
    }
}
