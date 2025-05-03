<?php

namespace App\Services\Auth;

use Arr;
use Exception;
use Illuminate\Support\Facades\Auth;

class SanctumLoginService extends BaseLoginHandlerService {
    public function validate(): self {
        if (empty($this->credentials['email'])) {
            throw new Exception(__('validation.required', ['attribute' => 'email']));
        }

        if (empty($this->credentials['password'])) {
            throw new Exception(__('validation.required', ['attribute' => 'password']));
        }

        return $this;
    }

    public function login(): array {
        if (!Auth::attempt(
            Arr::only($this->credentials, ['email', 'password'])
        )) {
            throw new Exception('Unauthorized', 401);
        }

        return $this->setUser(Auth::user())->authenticate();
    }
}