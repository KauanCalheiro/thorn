<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'gif' => ['sometimes', 'required', 'file', 'mimes:gif'],
            'muscle_group_id' => ['sometimes', 'required', 'exists:muscle_groups,id'],
        ];
    }
}
