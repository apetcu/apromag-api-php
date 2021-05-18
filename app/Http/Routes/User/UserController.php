<?php

namespace App\Http\Routes\User;

use App\Http\Controllers\Controller;
use App\Http\Routes\User\Requests\UpdateStatusRequest;
use App\Http\Routes\User\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Input;

class UserController extends Controller {
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function getById($id) {
        return response()->json($this->userService->findById($id));
    }

    public function updateUser($id, UpdateUserRequest $updateUserRequest) {
        return response()->json($this->userService->updateAccountAndVendor($id, $updateUserRequest->except('vendor'), $updateUserRequest->only('vendor')['vendor']));
    }

    public function setStatus($id, UpdateStatusRequest $request) {
        return response()->json($this->userService->updateAccountDetails($id, $request->only('status')));
    }

    public function getAll() {
        $query = Input::get('searchQuery');
        $response = $query ? $this->userService->findByQuery($query) : $this->userService->findAll();
        return response()->json($response);
    }
}
