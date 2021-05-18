<?php

namespace App\Http\Routes\Social;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\JWTAuth;

class SocialController extends Controller {
    private $jwtAuth;
    private $socialService;

    public function __construct(JWTAuth $JWTAuth, SocialService $socialService) {
        $this->jwtAuth = $JWTAuth;
        $this->socialService = $socialService;
    }

    public function redirect() {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function callback(Request $request) {
        if (!$request->has('code') || $request->has('denied')) {
            return redirect()->to(env('UI_URL').'auth/login?failure=fb');
        }

        $user = $this->socialService->createOrGetUser(Socialite::driver('facebook')->stateless()->user());
        $token = $this->jwtAuth->fromUser($user);

        return redirect()->to(env('UI_URL').'home?token='.$token);
    }
}
