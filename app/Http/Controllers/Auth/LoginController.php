<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /** This trait includes all default login functionality such as
     *  - showing the login form
     *  - validating credentials
     *  - logging in the user
     *  - redirecting after login
     */
    use AuthenticatesUsers;

    /**
     * The path users will be redirected to after logging in successfully.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Constructor method.
     *
     * - Applies the `guest` middleware to all routes except `logout`,
     *   which means logged-in users cannot access the login page.
     * - Applies `auth` middleware to `logout` to ensure only authenticated
     *   users can log out.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override the default identifier used for login.
     * By default, Laravel uses 'email' — this changes it to 'username'.
     *
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * Override the default logout method.
     * - Logs out the user
     * - Flushes and regenerates the session
     * - Redirects to the login page
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('login');
    }
}
