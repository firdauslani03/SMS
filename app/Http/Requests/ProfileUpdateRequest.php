<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fName' => ['required', 'string', 'max:255'],
            'lName' => ['required', 'string', 'max:255'],
            'ic' => [
                'required', 
                'string', 
                'max:12', 
                Rule::unique(Student::class)->ignore($this->user()->matricNum, 'matricNum')
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(Student::class)->ignore($this->user()->matricNum, 'matricNum'),
            ],
            'countryCode' => ['required', 'string', 'max:5'],
            'phoneOp' => ['required', 'string', 'max:5'],
            'subNum' => ['required', 'string', 'max:15'],
        ];
    }
}