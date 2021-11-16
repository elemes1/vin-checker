<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_profile_information_is_available()
    {
        $this->actingAs($user = User::factory()->create());

    }

    public function test_profile_information_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());


        $this->assertEquals('Test Name', $user->fresh()->name);
        $this->assertEquals('test@example.com', $user->fresh()->email);
    }
}
