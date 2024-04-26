<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'department_id' => 'nullable|integer|exists:departments,id',
            'first_name'    => 'nullable|string|max:25',
            'last_name'     => 'nullable|string|max:25',
            'email'         => 'nullable|email|unique:employees,email,except,id',
            'position'      => 'nullable|string',
        ];
    }
}
