<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {        
        return view('auth.login',[
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            if(auth()->user()->hak_akses=='production'){
                return redirect()->intended('production/dashboard');
            }
            if(auth()->user()->hak_akses=='qc'){
                return redirect()->intended('qc/dashboard');
            }
            return redirect()->intended('admin/dashboard');
        }

        return back()->with('loginError', 'Login Gagal! Username atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
