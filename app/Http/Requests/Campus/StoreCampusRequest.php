<?php

namespace App\Http\Requests\Campus;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:campuses,name',
            'email' => 'required|email|max:255|unique:campuses,email',
            'contact_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ];
    }
}
