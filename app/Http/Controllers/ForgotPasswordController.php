<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    //


    public function __invoke(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        Password::broker()->sendResetLink(
            $request->only('email')
        );

        return response()->json([
            "msg" => "Password reset successful, new password has been sent to your email",
        ], 200);
    }
}
