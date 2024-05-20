<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function formRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z]+[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:users,email'
            ],
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Alamat Email wajib diisi.',
            'email.email' => 'Alamat Email harus berupa email yang valid.',
            'email.regex' => 'Alamat Email harus dimulai dengan huruf dan hanya mengandung karakter yang valid.',
            'email.unique' => 'Alamat Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus memiliki setidaknya 8 karakter.',
            'password.confirmed' => 'Konfirmasi Password tidak cocok.',
        ]);

        // Buat pengguna baru
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // Set session flash untuk notifikasi
        Session::flash('success', 'Registrasi berhasil! Anda dapat login sekarang.');

        // Redirect pengguna setelah pendaftaran berhasil
        return redirect()->route('login');
    }
}
