<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'gif' => ['required', 'file', 'mimes:gif'],
            'muscle_group_id' => ['required', 'exists:muscle_groups,id'],
        ];
    }
}
