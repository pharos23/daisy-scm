<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller for authenticating the login
class LoginController extends Controller
{
    // Function to send to the login page in case the user is not logged in
    public function index()
    {
        return view('auth.login');
    }

    // Function to authenticate the user login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required|email',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('/contacts'); // If the Login was successful redirects to the contacts page
        }

        return back()->withErrors(['email' => 'Invalid credentials']); // If the Login failed, show the error message
    }
}
