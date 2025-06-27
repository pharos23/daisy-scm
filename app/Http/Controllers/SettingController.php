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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'current_password' => ['nullable', 'required_with:new_password', 'string', 'min:8'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).+$/'],
        ], [
            'new_password.regex' => __('Password req'),
        ]);

        // Update name if changed
        if ($user->name !== $validated['name']) {
            $user->name = $validated['name'];
        }

        // Handle password change if provided
        if (!empty($validated['new_password'])) {
            // Check current password is correct
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => __('Current password is incorrect')])->withInput();
            }

            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('userSettings.edit')->with('success', __('Settings') .' '. __('updated successfully')); // Returns to the user settings with a success message, acts like a refresh
    }
}
