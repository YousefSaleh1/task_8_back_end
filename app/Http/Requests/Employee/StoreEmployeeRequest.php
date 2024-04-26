<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'department_id' => 'required|integer|exists:departments,id',
            'first_name'    => 'required|string|max:25',
            'last_name'     => 'required|string|max:25',
            'email'         => 'required|email|unique:employees,email,except,id',
            'position'      => 'required|string',
        ];
    }
}
