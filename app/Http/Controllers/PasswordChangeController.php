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
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        // Check if new password is the same as the current one
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
