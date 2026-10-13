<?php

namespace App\Http\Requests\Campus;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCampusRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('campuses', 'name')->ignore($id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('campuses', 'email')->ignore($id)],
            'contact_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ];
    }
}
