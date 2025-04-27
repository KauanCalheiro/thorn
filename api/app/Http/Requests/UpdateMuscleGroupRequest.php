<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMuscleGroupRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255', 'unique:muscle_groups,name,' . $this->route('muscleGroup')->id],
        ];
    }
}
