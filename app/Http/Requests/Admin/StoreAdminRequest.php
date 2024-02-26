<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user.building_id' => ['nullable', 'integer',  'exists:buildings,id'],
            'user.role_id' => ['required', 'integer', 'exists:roles,id'],
            'user.email' => ['required', 'string',  'email:rfc,dns', 'max:255', 'unique:admins,email'],
            'user.password' => ['required', 'string', 'min:8'],
            'user.phone' => ['required', 'string', 'min:10', 'max:15', 'regex:/^(\+?\d{1,4}[-\s]?)?(\(?\d{1,5}\)?[-\s]?)?\d{1,15}([- \s]?\d{1,15})*$/', 'unique:admins,phone'],
            'user.full_name' => ['required', 'string', 'max:255'],
        ];
    }
}
