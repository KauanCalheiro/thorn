<?php

namespace App\Services;

use App\Contracts\LoginHandlerContract;
use App\Services\Auth\GoogleLoginServe;
use App\Services\Auth\SanctumLoginService;


class AuthService {
    private const LOGIN_HANDLER = [
        'sanctum' => SanctumLoginService::class,
        'google' => GoogleLoginServe::class
    ];

    private LoginHandlerContract $loginHandler;

    public function __construct($credentials) {
        $handlerClass = self::LOGIN_HANDLER[$credentials['driver']];
        $this->loginHandler = new $handlerClass($credentials);
    }

    public static function make($credentials): self {
        return new self($credentials);
    }

    public function handleLogin() {
        return $this->loginHandler->handleLogin();
    }
}