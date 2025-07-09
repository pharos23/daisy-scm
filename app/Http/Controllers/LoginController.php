<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsible for user authentication (custom login logic).
 * Displays the login form and handles login attempts manually.
 */
class LoginController extends Controller
{
    /**
     * Displays the login view if the user is not authenticated.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handles login form submission and user authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate login form input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Attempt to authenticate with the provided credentials
        if (Auth::attempt($credentials)) {
            // If authentication is successful, redirect to the home page
            return redirect('/home');
        }

        // If authentication fails, return with an error message
        return back()
            ->withErrors(['username' => __("Invalid credentials")]);
    }
}
