<?php namespace App\Repositories;

use App\Contracts\OTPRequestInterface;
use App\Models\UserOTP;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Database Implementation Of generating and Storing OTP
 */
class DbOTPRequestRepository implements OTPRequestInterface
{
    public function generateOTP($owner, $length = 6, $validFor = 3600)
    {
        $validDateTime = $this->setValidity($validFor);
        $code = $this->randomNumber($length);
        $data = ['user_id' => $owner->id, 'token' => $code, 'expires' => $validDateTime];
        $this->storeOTP($data);
        return $this->sendOTP($owner, $code);
    }

    public function storeOTP($data)
    {
        UserOTP::create($data);
    }

    public function resendOtp($user)
    {
        $latestOTP = $user->otps()->latest()->first();
        if ($latestOTP->isValid) {
            return $this->sendOTP($user->id, $latestOTP->token);
        }
    }

    public function verifyOTP($user, $code)
    {
        if($user->otps()->latest()->first()){
            $valid = $code === $user->otps()->latest()->first()->token;
            if ($valid) {
                return ['success' => true, 'message' => 'valid'];
            } else {
                return ['success' => false, 'message' => 'invalid OTP'];
            }
        }
        return ['success' => false, 'message' => 'invalid OTP'];

    }

    private function randomNumber($length)
    {
        $min = 1 . str_repeat(0, $length - 1);
        $max = str_repeat(9, $length);

        return mt_rand($min, $max);
    }

    private function setValidity($validFor)
    {
        return Carbon::now()->addSecond($validFor);
    }

    private function sendOTP($owner, $code)
    {
        DB::beginTransaction();
        try {
            $param = http_build_query([
                'phoneNumber' => $owner->phone_number,
                'verifyCode' => $code,
            ]);
            $url = env('OTP_URL') . '?' . $param;
            $response = Http::withHeaders([
                'x-rapidapi-host' => env('OTP_HEADER_HOST_VALUE'),
                'x-rapidapi-key' => env('OTP_HEADER_HOST_KEY'),
            ])->post(
                $url,
            );
            if ($response->successful()) {
                DB::commit();

                return ['success' => true, 'message' => json_decode($response->body())->message];
            } else {
                return ['success' => false, 'message' => json_decode($response->body())->message];
            }
        } catch (\Exception $exception) {
            DB::rollBack();

            return ['success' => false, 'message' => $exception->getMessage()];
        }
    }
}











