<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard')->with('success', 'You are already logged in.');
        }

        return view('auth.login', [
            'title' => "Login"
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', "Login successfully");
        }

        return back()->with('error', 'Login failed');
    }

    public function register()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard')->with('success', 'You are already logged in.');
        }

        return view('auth.register', [
            'title' => "Register"
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'regex:/^\S*$/u'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return redirect('/login')->with('success', 'Your account has been successfully created.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
