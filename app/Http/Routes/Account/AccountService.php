<?php

namespace App\Http\Routes\Account;

use App\Http\Routes\Account\Mail\EmailChangeMail;
use App\Http\Routes\Auth\Models\PasswordResetConfirmationMail;
use App\Http\Routes\Auth\Models\PasswordResetMail;
use App\Http\Routes\User\Models\User;
use App\Http\Routes\User\UserRepository;
use App\Http\Routes\User\UserService;
use App\Http\Routes\Vendor\VendorRepository;
use App\Http\Routes\Vendor\VendorService;
use App\Utils\AuthUtils;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\JWTAuth;

class AccountService {
    private $userRepository;
    private $vendorRepository;
    private $vendorService;
    private $jwtAuth;

    public function __construct(UserRepository $userRepository, VendorRepository $vendorRepository, VendorService $vendorService, UserService $userService, JWTAuth $JWTAuth) {
        $this->userRepository = $userRepository;
        $this->vendorRepository = $vendorRepository;
        $this->vendorService = $vendorService;
        $this->userService = $userService;
        $this->jwtAuth = $JWTAuth;
    }

    public function getLoggedInUser() {
        $userId = AuthUtils::getUserId();
        return User::fromEntity($this->userRepository->findById($userId));
    }

    public function updateProfilePicture($image) {
        $path = Storage::disk('s3')->put('images/accounts', $image['profilePicture']
            ->manipulate(function (Image $image) {
                $image->fit(400, 400);
            }));
        $this->vendorRepository->updateProfilePicture(AuthUtils::getVendorId(), $path);
        return User::fromEntity($this->userRepository->findById(AuthUtils::getUserId()));
    }

    public function updateUserDetails($userDetails) {
        return $this->userService->updateAccountDetails(AuthUtils::getUserId(), $userDetails);
    }

    public function updateVendorDetails($vendorDetails) {
        return $this->vendorService->updateVendorDetails(AuthUtils::getVendorId(), $vendorDetails->toArray());
    }

    public function uploadVendorImages($images) {
        $this->vendorService->addVendorImages(AuthUtils::getVendorId(), $images);
        return User::fromEntity($this->userRepository->findById(AuthUtils::getUserId()));
    }

    public function deleteImage($id) {
        return $this->vendorService->deleteVendorImage(AuthUtils::getVendorId(), $id);
    }
    
    public function changePassword($newPassword) {
        $user = $this->userRepository->findById(AuthUtils::getUserId());
        $passwordMatch = Hash::check($newPassword['currentPassword'], $user->password);

        if (!$passwordMatch) {
            return response()->json([], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json($this->changeDetailsAndRetrieveJwt(['password' => bcrypt($newPassword['password'])]), Response::HTTP_ACCEPTED);
    }

    public function changeEmail($newEmail) {
        $user = $this->userRepository->findById(AuthUtils::getUserId());
        $passwordMatch = Hash::check($newEmail['currentPassword'], $user->password);

        if (!$passwordMatch) {
            return response()->json([], Response::HTTP_UNAUTHORIZED);
        }
        
        Mail::to($user->email)
            ->send(new EmailChangeMail($user, $newEmail['email']));
        
        return $this->changeDetailsAndRetrieveJwt(['email' => $newEmail['email']]);
    }

    private function changeDetailsAndRetrieveJwt($details) {
        $this->userService->updateAccountDetails(AuthUtils::getUserId(), $details);
        $user = $this->userRepository->findById(AuthUtils::getUserId());
        $jwt_token = $this->jwtAuth->fromUser($user);

        Mail::to($user->email)
            ->send(new PasswordResetConfirmationMail($user));

        return response()
            ->json($user, 200, ['Authorization' => 'Bearer ' . $jwt_token]);
    }
}