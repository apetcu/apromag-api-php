<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AccountController extends Controller
{

    public function details(Request $request)
    {
        $payload = JWTAuth::getPayload($request->bearerToken());
        Log::debug($payload);


        $user = Auth::user();
        $authenticatedUser = User::with('vendor')->where('id', $user['id'])->first();
        return response()->json(User::fromEntity($authenticatedUser));
    }
}
