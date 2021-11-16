<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated()
    {

        $user = User::factory()->create();
        $this->actingAs($user)->patch('/api/password',[
            'password' => 'new-password',
            'password_confirmation' => 'new-password'
        ])->assertStatus(200);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));


    }

    public function test_current_password_must_be_correct()
    {

        $user = User::factory()->create();
        $this->actingAs($user)->patch('/api/password',[
            'password' => 'new-password',
            'password_confirmation' => 'new-password'
        ]);
        $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'new-password',
        ])->assertStatus(302);
        $this->assertFalse(Hash::check('password', $user->fresh()->password));

    }
}
