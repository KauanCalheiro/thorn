<?php

namespace App\Services\Auth;

use App\Models\User;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Log;

class GoogleLoginServe extends BaseLoginHandlerService {
    public function validate(): self {
        if (empty($this->credentials['token'])) {
            throw new Exception(__('validation.required', ['attribute' => 'token']));
        }

        return $this;
    }

    public function login(): array {
        $token = $this->credentials['token'];

        $googleUser = Socialite::driver('google')->stateless()->userFromToken($token);

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'google_picture' => $googleUser->getAvatar(),
                "email_verified_at" => ($googleUser->getRaw()['email_verified'] ?? false) ? now() : null
            ]
        );

        return $this->setUser($user)->authenticate();
    }
}
