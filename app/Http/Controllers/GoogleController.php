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
                if ($findUser->level_id == 'PT') {
                    $url = 'satker/lke';
                } elseif ($findUser->level_id == 'EP') {
                    $url = 'prov/evaluasi';
                } elseif ($findUser->level_id == 'AT' || $findUser->level_id == 'KT' || $findUser->level_id == 'DL') {
                    $url = '/tpi/evaluasi';
                } else {
                    $url = 'dashboard';
                }
                return redirect()->intended($url);
            } else {
                return redirect('login')->with('loginError', 'Akun Tidak Terdaftar!');
            }
        } catch (\Throwable $th) {
            // test
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
        if ($findUser && $request->password == 'zi2023') {

            Auth::login($findUser);
            if ($findUser->level_id == 'PT') {
                $url = 'satker/lke';
            } elseif ($findUser->level_id == 'EP') {
                $url = 'prov/evaluasi';
            } elseif ($findUser->level_id == 'AT' || $findUser->level_id == 'KT' || $findUser->level_id == 'DL') {
                $url = '/tpi/evaluasi';
            } else {
                $url = 'dashboard';
            }

            return redirect()->intended($url);
        }
        // Jika gagal
        return back()->with('loginError', 'Login Failed!');
    }
}
