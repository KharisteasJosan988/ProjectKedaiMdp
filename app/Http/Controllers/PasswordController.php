<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    // Menampilkan form forgot password
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Mengirim email tautan reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
        ], [
            'email.required' => 'Email diperlukan.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.regex' => 'Email harus dimulai dengan sebuah huruf dan terdiri dari format email yang benar.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Menampilkan form reset password
    public function showResetForm($token)
    {
        $email = DB::table('password_reset_tokens')->where('token', $token)->value('email');
        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    // Mereset password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Email diperlukan.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.regex' => 'Email harus dimulai dengan sebuah huruf dan terdiri dari format email yang benar.',
            'password.required' => 'Password diperlukan.',
            'password.min' => 'Password harus terdiri dari setidaknya 8 character.',
            'password.confirmed' => 'Password tidak sesuai.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
