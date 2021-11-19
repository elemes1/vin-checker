<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_can_be_requested()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/forgot-password', [
            'email' => $user->email,
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'msg',
        ]);
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();
        $user = User::factory()->create();
        $response = $this->post('/api/forgot-password', [
            'email' => $user->email,
        ]);
        $response->assertStatus(200);
        Notification::assertSentTo($user, ResetPasswordNotification::class, function ($notification) use ($user) {
            $response = $this->post('/api/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);
            $response->assertSessionHasNoErrors();
            return true;
        });
    }
}
