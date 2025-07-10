<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request used to validate input when updating an existing role.
 * Ensures the provided data follows the defined validation rules before it reaches the controller.
 */
class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Always returns true here, meaning any authenticated user (as defined by route middleware)
     * is allowed to make this request. You can add custom permission logic if needed.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250|unique:roles,name,'.$this->role->id,
            'permissions' => 'required',
        ];
    }
}
