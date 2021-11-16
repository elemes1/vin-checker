<?php

namespace Tests\Feature;

use App\Events\UserValidatedViaPhone;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
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

//        $verificationUrl = URL::temporarySignedRoute(
//            'verification.verify',
//            now()->addMinutes(60),
//            ['id' => $user->id, 'hash' => sha1($user->email)]
//        );

//        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(UserValidatedViaPhone::class);

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(RouteServiceProvider::HOME . '?verified=1');
    }

    public function test_phone_can_not_verified_with_invalid_token()
    {


        $user = User::factory()->create([
            'email_verified_at' => null,
            'phone_validated_at' => null,
        ]);

//        $verificationUrl = URL::temporarySignedRoute(
//            'verification.verify',
//            now()->addMinutes(60),
//            ['id' => $user->id, 'hash' => sha1('wrong-email')]
//        );

//        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
