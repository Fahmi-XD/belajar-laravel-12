<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        if (Auth::check()) {
            return redirect()->intended('/dashboard');
        }
        return view("pages.login");
    }

    public function register(Request $request) {
        if (Auth::check()) {
            return redirect()->intended("/dashboard");
        }
        
        return view("pages.register");
    }

    public function loginPost(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['error'=> 'Error email dan password salah']);
    }

    public function registerPost(Request $request) {
        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=>Hash::make($request->password),
        ]);

        return redirect()->intended('/login');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect()->intended('/login');
    }
}
