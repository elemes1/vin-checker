<?php namespace App\Contracts;

interface OTPRequestInterface
{
    public function generateOTP($owner, $length=6, $validFor=5);

    /**
     * @param $data
     * Store User OTP Data
     * @return mixed
     */
    public function storeOTP($data);

    /**
     * @param $user
     * Resend For Currently Logged in User
     * @return mixed
     */
    public function resendOtp($user);

    public function verifyOTP($user, $code);
}










