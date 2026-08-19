<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicalNoteRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'patient_username'  => 'required|string|max:50',
            'patient_name'      => 'required|string|max:255',
            'patient_birthdate' => 'required|date',
            'diagnosis'         => 'required|string',
            'treatment'         => 'required|string',
            'counselor_name'    => 'required|string|max:255',
            'counselor_license' => 'required|string|max:100',
            'date'              => 'required|date',
        ];
    }
}
