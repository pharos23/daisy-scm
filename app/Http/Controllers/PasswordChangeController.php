<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $user->password = Hash::make($request->password);
        $user->force_password_change = false;
        $user->save();

        return redirect()->route('home')->with('status', 'Password changed successfully.');
    }
}
