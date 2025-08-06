<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login() {
        if(Auth::check()) {
            return redirect()->route('home');
        } else {
            if (Session::has('email')) {
                $email = Session::get('email');
                $timeout = Session::get('login_timeout_' . $email);
                if ($timeout && now()->lt($timeout)) {
                    $secondsLeft = now()->diffInSeconds($timeout);
                    return view('login')->with([
                        'error' => "Silahkan coba lagi dalam {$secondsLeft} detik",
                        'timeout' => $secondsLeft
                    ]);
                }
            }
            return view('login');
        }


    }

    public function actionLogin(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');

        Session::put('email', $email);

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Email Yang Anda Masukan Salah');
        }

        $attempts = Session::get('login_attempts_' . $email, 0);
        $timeout = Session::get('login_timeout_' . $email);
        if ($timeout && now()->lt($timeout)) {
            $secondsLeft = now()->diffInSeconds($timeout);
            return redirect()->route('login')
                ->with('error', "Silahkan coba lagi dalam {$secondsLeft} detik")
                ->with('timeout', $secondsLeft);
        }

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            Session::forget('login_attempts_' . $email);
            Session::forget('login_timeout_' . $email);
            Session::forget('email');
            return redirect()->route('home');
        } else {
            $attempts++;
            Session::put('login_attempts_' . $email, $attempts);
            
            if ($attempts >= 5) {
                Session::put('login_timeout_' . $email, now()->addSeconds(30));
                return redirect()->route('login')
                    ->with('error', 'Terlalu banyak percobaan. Silahkan coba lagi dalam 30 detik')
                    ->with('timeout', 30);
            }

            return redirect()->route('login')
                ->with('error', 'Password Anda Salah');
        }
    }

    public function actionLogout() {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

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
                'phone' => 'required',
                'address' => 'required',
                'password' => 'required|min:8|confirmed',
            ],
            [
                'name.required' => 'Nama harus diisi.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Silahkan Masukkan Email yang valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'phone.required' => 'Nomor HandPhone harus diisi.',
                'address.required' => 'Alamat harus diisi.',
                'password.required' => 'Password harus diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak sama.'
            ]
        );

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ];

        User::create($data);

        $displayData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
        return redirect()->route('register')->with('register_data', $displayData)->with('success', 'Pendaftaran berhasil! Berikut data Anda:');
    }

    

}
