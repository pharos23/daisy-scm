<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Always returns true here, meaning all authenticated users (as defined by route middleware)
     * can proceed. You can override this for more complex permission checks if needed.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define the validation rules for updating a user.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'username' => 'required|string|max:250|unique:users,username,' . $this->user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required',
            'force_password_change' => 'nullable|boolean',
        ];
    }
}
