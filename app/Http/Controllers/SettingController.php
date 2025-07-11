<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Controller responsible for managing user account settings,
 * including updating the display name and changing passwords.
 */
class SettingController extends Controller
{
    /**
     * Show the user settings page.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('users.settings'); // Returns to the users settings blade
    }

    /**
     * Handle the update of user settings.
     * Supports updating the user's name and password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = $request->user(); // Get the currently authenticated user

        // Validate input
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:30',
                Rule::unique('users')->ignore($user->id), // Ensure the name is unique, but ignore current user's record
            ],
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).+$/'],
        ], [
            // Custom validation messages
            'new_password.required' => __('validation.password_required'),
            'new_password.min' => __('validation.password_min'),
            'new_password.confirmed' => __('validation.password_confirmed'),
            'new_password.regex' => __('validation.password_strength'),
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

        return redirect()->route('userSettings.edit')->with('success', __('Settings') .' '. __('Updateda successfully')); // Returns to the user settings with a success message, acts like a refresh
    }
}
