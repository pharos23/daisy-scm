<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordChangeController extends Controller
{
    public function showChangeForm()
    {
        return view('auth.force_change_password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).+$/'],
        ], [
            'password.required' => __('password_required'),
            'password.min' => __('password_min'),
            'password.confirmed' => __('password_confirmed'),
            'password.regex' => __('password_strength'),
        ]);

        $user = $request->user();

        // Check if the new password is the same as the current one
        if (Hash::check($request->password, $user->password)) {
            // Throw validation error
            throw ValidationException::withMessages([
                'password' => ['The new password must be different from the current password.'],
            ]);
        }

        // Update password and reset force_password_change
        $user->password = Hash::make($request->password);
        $user->force_password_change = false;
        $user->save();

        return redirect()->route('home')->with('status', 'Password changed successfully.');
    }
}
