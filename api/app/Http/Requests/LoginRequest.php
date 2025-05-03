<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function prepareForValidation(): void {
        $this->merge([
            'driver' => $this->input('driver', 'sanctum'),
        ]);
    }

    public function rules(): array {
        $driver = $this->input('driver', 'sanctum');

        return $driver == 'google'
            ? $this->googleRules()
            : $this->sanctumRules();
    }

    private function googleRules() {
        return [
            'token' => ['required', 'string'],
            'driver' => ['in:sanctum,google'],
        ];
    }

    private function sanctumRules() {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember_me' => ['boolean'],
            'driver' => ['in:sanctum,google'],
        ];
    }
}
