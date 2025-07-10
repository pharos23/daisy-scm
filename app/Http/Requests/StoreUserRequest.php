<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Form Request class used to validate input when creating a new user.
 * It ensures that the submitted data meets the specified validation rules
 * before it reaches the controller.
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Always returns true here, meaning any authenticated user (by route middleware)
     * is allowed to use this request. You can customize this if you need permission-based checks.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define the validation rules for the incoming request data.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'username' => 'required|string|max:250|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required',
            'force_password_change' => 'nullable|boolean',
        ];
    }
}
