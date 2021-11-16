<?php

namespace App\Http\Controllers;

use App\Contracts\OTPRequestInterface;
use App\Events\UserValidatedViaPhone;
use App\Models\User;
use Illuminate\Http\Request;

//use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /**
     * @var OTPRequestInterface
     */
    private $otpGenerator;

    public function __construct(OTPRequestInterface $otpRequest)
    {
        $this->otpGenerator = $otpRequest;
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     *
     */

    public function sendCode(Request $request)
    {

        $user = $request->user();
        $otpGenerated = $this->otpGenerator->generateOTP($user, 6, 3600);
        if ($otpGenerated['success']) {
            return response()->json(['success' => true, 'message' => 'OTP sent'], 200);
        } else {
            return response()->json(
                ['success' => false, 'message' => 'OTP notification failed , Try Again Later', 'description' => $otpGenerated['message'] ]
            );
        }
    }

    public function verify(Request $request)
    {
        $code = $request->otp_code;
        $user = $request->user();
        $otpVerified = $this->otpGenerator->verifyOTP($user, $code);
        if ($otpVerified['success']) {
            event(new UserValidatedViaPhone($user));
            return response()->json(['success' => true, 'message' => 'OTP Valid']);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid OTP', 'description' => $otpVerified['message']]);
        }
    }

    public function resend(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'OTP sent']);

        $user = $request->user();
        $otpGenerated = $this->otpGenerator->resendOtp($user);
        if ($otpGenerated['success']) {
            return response()->json(['success' => true, 'message' => 'OTP sent'], 200);
        } else {
            return response()->json(
                ['success' => false, 'message' => 'OTP notification failed , Try Again Later' ,  'description' => $otpGenerated['message']]
            );
        }
    }
}
