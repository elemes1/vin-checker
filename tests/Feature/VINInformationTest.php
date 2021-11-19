<?php

namespace Tests\Feature;

use App\Events\OTPSent;
use App\Events\UserValidatedViaPhone;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class VINInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_vin_result_is_returned()
    {
        Event::fake();
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
            'phone_validated_at' => Carbon::now(),
        ]);
        Http::fake([
            env('VIN_DECODE_URL' . '?*') => Http::response([
                'success' => true,
                'specification' => [
                    'vin' => '4F2YU09161KM33122',
                    'year' => '2001',
                    'make' => 'MAZDA',
                    'model' => 'TRIBUTE',
                    'trim_level' => 'LX',
                    'engine' => '3.0L V6 DOHC 24V',
                    'style' => 'SPORT UTILITY 4-DR',
                    'made_in' => 'UNITED STATES',
                    'steering_type' => 'R&P',
                    'anti_brake_system' => 'Non-ABS | 4-Wheel ABS',
                    'tank_size' => '16.40 gallon',
                    'overall_height' => '69.90 in.',
                    'overall_length' => '173.00 in.',
                    'overall_width' => '71.90 in.',
                    'standard_seating' => '5',
                    'optional_seating' => null,
                    'highway_mileage' => '24 miles/gallon',
                    'city_mileage' => '18 miles/gallon',
                ],
                'vin' => '4F2YU09161KM33122',
            ], 200),
        ]);
        Http::fake([
            env('VIN_SALVAGE_URL' . '?*') => Http::response(
                [
                    "success" => true,
                    "is_salvage" => true,
                    "info" => [
                        "images" => [],
                        "vehicle_title => 'NY - MV-907A SALVAGE CERTIFICATE',
                        'mileage'=>'628 (ACTUAL)',
                        'primary_damage'=>'REAR END",
                        'secondary_damage' => 'FR',
                        'loss_type' => 'COLLISION',
                    ],
                ],
                200
            ),
        ]);
        $response = $this->actingAs($user)->post('api/search-vin',[
            'vin'=> '4F2YU09161KM33122'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' =>[
                'specification',
                'salvage'
            ]
        ]);
    }

    public function test_invalid_vin_error()
    {
        Event::fake();
        $user = User::factory()->create([
            'email_verified_at' => Carbon::now(),
            'phone_validated_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($user)->post('api/search-vin',[
            'vin'=> '4F2YU09161KM331'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();

    }
}
