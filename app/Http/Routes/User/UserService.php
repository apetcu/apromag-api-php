<?php

namespace App\Http\Routes\User;

use App\Http\Routes\Vendor\VendorRepository;

class UserService {
    private $userRepository;
    private $vendorRepository;

    public function __construct(UserRepository $userRepository, VendorRepository $vendorRepository) {
        $this->userRepository = $userRepository;
        $this->vendorRepository = $vendorRepository;
    }

    public function findAll() {
        return $this->userRepository->findAll();
    }

    public function findByQuery($query) {
        return $this->userRepository->findByQuery($query);
    }

    public function findById($id) {
        return $this->userRepository->findById($id);
    }

    public function updateAccountDetails($id, $attributes) {
        return $this->userRepository->update($id, $attributes);
    }

    public function updateAccountAndVendor($id, $user, $vendor) {
        $userDetails = $this->userRepository->findById($id);
        $this->updateAccountDetails($id, $user);
        $this->vendorRepository->update($userDetails->vendor_id, $vendor);

        return 200;
    }

}