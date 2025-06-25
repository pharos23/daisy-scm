<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

// Controller for managing the User Settings
class SettingController extends Controller
{
    // Function to edit the user settings
    public function edit()
    {
        return view('users.settings'); // Returns to the users settings blade
    }

    // Function to update the user settings
    public function update(Request $request)
    {
        $user = $request->user();

        // Validate input
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'current_password' => ['nullable', 'required_with:new_password', 'string', 'min:8'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).+$/'],
        ], [
            'new_password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, and one number.',
        ]);

        // Update email if changed
        if ($user->email !== $validated['email']) {
            $user->email = $validated['email'];
        }

        // Handle password change if provided
        if (!empty($validated['new_password'])) {
            // Check current password is correct
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }

            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('userSettings.edit')->with('success', 'Settings updated successfully.'); // Returns to the user settings with a success message, acts like a refresh
    }
}
