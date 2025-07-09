<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    // Includes default password confirmation logic provided by Laravel
    use ConfirmsPasswords;

    /**
     * Where to redirect the user if there's no intended URL after confirmation.
     * For example, after confirming the password manually.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Constructor method.
     * Applies the `auth` middleware to ensure only authenticated users
     * can access this controller’s actions.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
