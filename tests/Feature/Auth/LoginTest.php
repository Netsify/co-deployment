<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_login_page()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);

        $response->assertViewIs('auth.login');
    }

    public function test_auth_user_cannot_view_login_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(route('main'));
    }
}
