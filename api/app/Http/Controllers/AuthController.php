<?php

namespace App\Http\Controllers;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController {
    private const TOKEN_NAME = 'Personal Access Token';
    private const REGISTER_ERROR_BAG = 'register';
    private const REGISTER_VALIDATION = [
        'name' => ['required', 'string'],
        'email' => ['required', 'string', 'unique:users'],
        'password' => ['required', 'string'],
        'c_password' => ['required', 'same:password'],
    ];

    private const LOGIN_ERROR_BAG = 'login';
    private const LOGIN_VALIDATION = [
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
        'remember_me' => ['boolean'],
    ];

    private const TOKEN_TYPE = 'Bearer';

    public function register(Request $request) {
        try {
            $request->validateWithBag(
                self::REGISTER_ERROR_BAG,
                self::REGISTER_VALIDATION
            );

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $expires = now()->addDay();

            return ResponseService::success(
                data: $this->generateUserTokenResponse($user, $expires),
                message: 'Successfully created user!',
                code: 201
            );
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function login(Request $request) {
        try {

            $request->validateWithBag(
                self::LOGIN_ERROR_BAG,
                self::LOGIN_VALIDATION
            );

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                throw new Exception('Unauthorized', 401);
            }

            $user = Auth::user();
            $user->tokens()->delete();

            $expires = $request->remember_me ? now()->addMonth() : now()->addDay();

            return [
                'token' => $user->createToken(self::TOKEN_NAME, ['*'], $expires)->plainTextToken,
            ];
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
