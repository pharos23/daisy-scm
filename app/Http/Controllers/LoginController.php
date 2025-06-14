<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required|email',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('/contacts'); // Login success
        }

        return back()->withErrors(['email' => 'Invalid credentials']); // Login failed
    }
}
