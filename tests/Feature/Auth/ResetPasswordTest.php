<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_receives_an_email_with_a_password_reset_link()
    {
        $notification = Notification::fake();

        dd($notification);

        $user = User::factory()->create();

        $this->post(route('password.reset', $notification->token), [
            'email' => $user->email,
        ]);

//        Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) use ($token) {
//            return Hash::check($notification->token, $token->token) === true;
//        });
    }
}
