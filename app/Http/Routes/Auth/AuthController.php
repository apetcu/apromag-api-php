<?php

namespace App\Http\Routes\Auth;

use App\Http\Controllers\Controller;
use App\Http\Routes\Auth\Models\LoginAuthRequest;
use App\Http\Routes\Auth\Models\PasswordResetRequest;
use App\Http\Routes\Auth\Models\PasswordResetWithTokenRequest;
use App\Http\Routes\Auth\Models\RegisterAuthRequest;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller {
    private $authService;
    private $jwtService;

    public function __construct(AuthService $authService, JWTAuth $jwtService) {
        $this->authService = $authService;
        $this->jwtService = $jwtService;
    }

    public function register(RegisterAuthRequest $request) {
        $user = $this->authService->register($request);
        return response()->json($user, JsonResponse::HTTP_OK);
    }

    public function passwordReset(PasswordResetRequest $request) {
        $this->authService->passwordReset($request);
        return response()->json(['success'=>true], JsonResponse::HTTP_OK);
    }

    public function passwordResetWithToken($token, PasswordResetWithTokenRequest $request) {
        $this->authService->passwordResetWithToken($request->only('password'), $token);
        return response()->json(['success'=>true], JsonResponse::HTTP_OK);
    }

    public function login(LoginAuthRequest $request) {
        return $this->authService->login($request->only('email', 'password'));
    }

}
