<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /** This trait provides all default registration functionality:
     *  - displaying the registration form
     *  - validating form data
     *  - creating a new user
     *  - logging them in
     *  - redirecting them
     */
    use RegistersUsers;

    /**
     * The route to redirect users to after successful registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Constructor method.
     * Applies the `guest` middleware to prevent logged-in users from accessing the registration page.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validates incoming registration data.
     *
     * @param  array  $data  The form data submitted by the user.
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Creates a new user in the database after validation passes.
     *
     * @param  array  $data  The validated user input.
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ])->assignRole('User');
    }
}
