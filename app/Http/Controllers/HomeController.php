<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function buy($productName)
    {
        $user = Auth::user();
        if ($user->points >= 100 && $user->points < 150) {
            $user->points -= 100;
        } else if ($user->points >= 150) {
            $user->points -= 150;
        }
        $user->save();


        if ($user->points >= 100 && $user->points < 150) {
            $user->discount = 0.15;
        } elseif ($user->points >= 150) {
            $user->discount = 0.2;
        } else {
            $user->discount = 0;
        }
        $user->save();

        return redirect()->route('home');
    }
}