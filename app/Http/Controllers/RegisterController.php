<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = Validator::make(
            $request->all(),
            [

                'first_name' => 'required|min:3|max:255',
                'last_name' => 'required|min:3|max:255',
                'phone_number' => 'phone:AUTO,US,NG|unique:users,phone_number',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:255|confirmed',
            ],
            [
                'phone' => 'The :attribute field contains an invalid number',
            ]
        )->validate();

        $user = User::create([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
        ]);

        if ($user) {
            event(new Registered($user));

            return $user;
        }
    }
}
