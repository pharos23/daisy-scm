<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request class to validate incoming requests for storing a new Role.
 * This handles validation logic before it reaches the controller.
 */
class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method is used to check whether the user is allowed to submit this request.
     * For now, it returns true for all users. You can modify this to add authorization logic.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This method returns an array of validation rules for the form fields.
     * - 'name': required, must be a string, max 250 characters, and unique in the roles table.
     * - 'permissions': required (should contain at least one permission to assign to the role).
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250|unique:roles,name',
            'permissions' => 'required',
        ];
    }
}
