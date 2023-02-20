<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('email', $user->getEmail())->first();
            if ($findUser) {
                Auth::login($findUser);
                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $th) {
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Login Manual
    public function login(Request $request)
    {
        $findUser = User::where('email', $request->email)->first();
        if ($findUser) {
            Auth::login($findUser);
            return redirect()->intended('dashboard');
        }
        // Jika gagal
        return back()->with('loginError', 'Login Failed!');
    }
}
