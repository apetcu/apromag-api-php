<?php

namespace App\Http\Routes\Auth;

use App\Http\Routes\Account\AccountService;
use App\Http\Routes\Auth\Models\PasswordResetConfirmationMail;
use App\Http\Routes\Auth\Models\PasswordResetMail;
use App\Http\Routes\Auth\Models\PasswordResetRequest;
use App\Http\Routes\Auth\Models\RegisterAuthRequest;
use App\Http\Routes\Auth\Models\UserCreatedMail;
use App\Http\Routes\User\Models\User;
use App\Http\Routes\User\UserRepository;
use App\Http\Routes\User\UserService;
use App\Http\Routes\Vendor\Models\Vendor;
use App\Utils\AuthUtils;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\JWTAuth;


class AuthService {
    private $userRepository;
    private $userService;
    private $jwtService;

    public function __construct(UserRepository $userRepository, UserService $userService, JWTAuth $JWTAuth) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->jwtService = $JWTAuth;
    }

    public function login($credentials) {
        $jwt_token = null;
        if (!$jwt_token = $this->jwtService->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password!',
            ], \Illuminate\Http\Response::HTTP_UNAUTHORIZED);
        }
        
        $user = User::fromEntity($this->userRepository->findById(AuthUtils::getUserId()));
        
        if($user['status']==='DISABLED'){
            return response()->json([
                'success' => false,
                'message' => 'Account disabled',
            ], \Illuminate\Http\Response::HTTP_FORBIDDEN);
        }

        return response()
            ->json($user, 200, ['Authorization' => 'Bearer ' . $jwt_token]);
    }

    public function passwordReset(PasswordResetRequest $request) {
        $user = $this->userRepository->findByEmail($request->email);

        if ($user) {
            $uuid = Str::uuid();
            DB::table('password_resets')->insert(array('email'=> $user->email, 'token'=> $uuid, 'created_at'=> Carbon::now()));
            Mail::to($user->email)
                ->send(new PasswordResetMail($user, $uuid));
        }
        return true;
    }

    public function passwordResetWithToken($request, $token) {
        $entry = DB::table('password_resets')->where('token', $token)->where('created_at', '>=', \Carbon\Carbon::now()->subHour())->first();

        if ($entry) {
            $user = $this->userRepository->findByEmail($entry->email);
            $this->userService->updateAccountDetails($user->id, array('password' => bcrypt($request['password'])));
                   Mail::to($user->email)
                       ->send(new PasswordResetConfirmationMail($user));
        } else {
            return false;
        }
        return true;
    }

    public function register(RegisterAuthRequest $request) {
        $vendor_id = null;

        if ($request->role === 'VENDOR') {
            $vendor = new Vendor;
            $vendor->businessName = $request->input('vendor')['businessName'];
            $vendor->address = $request->input('vendor')['address'];
            $vendor_id = $this->userRepository->saveVendor($vendor);
        }

        $user = new User;
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($vendor_id) {
            $user->vendor_id = $vendor_id;
        }
        $user->password = bcrypt($request->password);

        $this->userRepository->save($user);

        Mail::to($user->email)
            ->send(new UserCreatedMail($user));

        return true;
    }
}