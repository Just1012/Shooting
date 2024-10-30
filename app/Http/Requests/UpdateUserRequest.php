<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'id'        => 'required|exists:users,id',
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|max:255|unique:users,email,' . $this->id,
            'password'  => 'nullable|string|min:8',
            'role_id'   => 'required|exists:roles,id',

        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'User ID is required',
            'id.exists'   => 'User not found',
            'name.required' => 'Name is required',
            'email.email' => 'Email is not valid',
            'email.unique' => 'Email has already been taken',
            'password.min' => 'Password must be at least 8 characters',
            'role_id.required' => 'Role ID is required',
            'role_id.exists' => 'Role not found',
           
        ];
    }
}
