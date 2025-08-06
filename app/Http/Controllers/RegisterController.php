<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function create(Request $request)
    {
        Session::flash('name', $request->name);
        Session::flash('email', $request->email);

        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ],
            [
                'name.required' => 'Nama harus diisi.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Silahkan Masukkan Email yang valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Password harus diisi.',
                'password.min' => 'Password minimal 6 karakter.'
            ]
        );

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ];

        User::create($data);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silahkan login');
    }
}
