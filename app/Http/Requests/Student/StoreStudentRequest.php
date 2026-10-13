<?php

namespace App\Http\Requests\Student;


use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sid' => 'required|string|max:255',
            'campus' => 'required|string|max:100',
            'class' => 'required|string|max:100',
            'father_name' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'student_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'dob' => 'nullable|string',
            'address' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validation for image
            'is_registered' => 'required',
        ];
    }
}