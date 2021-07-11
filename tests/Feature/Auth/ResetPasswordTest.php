<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Displays the reset password request form.
     *
     * @return void
     */
    public function test_user_can_view_password_reset_page()
    {
        $this->assertGuest();

        $response = $this->get(route('password.request'));

        $response->assertStatus(200);

        $response->assertViewIs('auth.passwords.email');
    }

    /**
     * Sends the password reset email when the user exists.
     *
     * @return void
     */
    public function test_sends_password_reset_email()
    {
        $user = User::factory()->create();

        $this->expectsNotification($user, ResetPassword::class);

        $response = $this->post(route('password.email'), ['email' => $user->email]);

        $response->assertRedirect(route('main'));
    }

    /**
     * Does not send a password reset email when the user does not exist.
     *
     * @return void
     */
    public function test_does_not_send_password_reset_email()
    {
        $this->doesntExpectJobs(ResetPassword::class);

        $this->post(route('password.email'), ['email' => 'invalid@email.com']);
    }

    /**
     * Displays the form to reset a password.
     *
     * @return void
     */
    public function test_displays_password_reset_page()
    {
        $response = $this->get(route('password.reset', ['token' => 'test_token']));

        $response->assertStatus(200);
    }

    /**
     * Allows a user to reset their password.
     *
     * @return void
     */
    public function test_user_can_change_password()
    {
        $user = User::factory()->create();

        $token = Password::createToken($user);

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}
