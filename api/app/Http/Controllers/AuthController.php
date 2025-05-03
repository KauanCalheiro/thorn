<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthController {
    private const TOKEN_NAME = 'Personal Access Token';

    public function login(LoginRequest $request) {
        try {
            $credentials = $request->validated();

            return AuthService::make($credentials)->handleLogin();
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function user(Request $request) {
        try {
            return ResponseService::success(
                data: $this->generateUserTokenResponse($request->user())
            );
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function logout(Request $request) {
        try {
            $request->user()->tokens()->delete();
            return ResponseService::success(data: [], message: 'Successfully logged out');
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    private function generateUserTokenResponse(User $user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->rolesList,
            'permissions' => $user->permissionsList,
        ];
    }
}
