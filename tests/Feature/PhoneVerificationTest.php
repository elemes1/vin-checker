<?php

namespace Tests\Feature;

use App\Events\OTPSent;
use App\Events\UserValidatedViaPhone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Laravel\Fortify\Features;
use Tests\TestCase;

class PhoneVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_phone_can_be_verified()
    {
        Event::fake();
        $user = User::factory()->create([
            'email_verified_at' => null,
            'phone_validated_at' => null,
        ]);
        Http::fake([
            env('OTP_URL' . '?*') => Http::response([
                'success' => 'true',
                'message' => [
                ],
            ], 200),
        ]);
        $response = $this->actingAs($user)->get('api/verify');
        Event::assertDispatched(OTPSent::class);
        $response = $this->actingAs($user)->get('api/verify');
        $response = $this->post('/api/verify', [
            'otp_code' => $user->otps()->latest()->first()->token,
        ]);
        Event::assertDispatched(UserValidatedViaPhone::class);
    }

    public function test_phone_can_not_verified_with_invalid_token()
    {
        Event::fake();
        $user = User::factory()->create([
            'email_verified_at' => null,
            'phone_validated_at' => null,
        ]);
        Http::fake([
            env('OTP_URL' . '?*') => Http::response([
                'success' => 'true',
                'message' => [
                ],
            ], 200),
        ]);
         $this->actingAs($user)->get('api/verify');
        Event::assertDispatched(OTPSent::class);
         $this->actingAs($user)->get('api/verify');
        $response = $this->post('/api/verify', [
            'otp_code' => '12321',
        ]);
        $response->assertStatus(200)->assertJson([
                "success" => false,
                "message" => "Invalid OTP",
                "description" => "invalid OTP",

            ]

        );
        Event::assertNotDispatched(UserValidatedViaPhone::class);
        $response->assertSessionHasNoErrors();
    }
}
