<?php

namespace App\Http\Routes\User;


use App\Http\Base\BaseRepository;
use App\Http\Routes\Order\Models\Order;
use App\Http\Routes\User\Models\User;
use App\Http\Routes\Vendor\Models\Vendor;

class UserRepository extends BaseRepository {
    public function __construct(User $user) {
        parent::__construct($user);
    }

    public function findAll() {
        return $this->repository->with('vendor')
            ->jsonPaginate([User::class, 'fromEntity']);
    }

    public function findByQuery($query) {
        return $this->repository->with('vendor')
            ->where('email', 'like', '%'.$query.'%')
            ->orWhere('firstName', 'like', '%'.$query.'%')
            ->orWhere('lastName', 'like', '%'.$query.'%')
            ->jsonPaginate([User::class, 'fromEntity']);
    }

    public function findById($id) {
        return $this->repository->where('id', $id)
            ->with('vendor')
            ->get()->first();
    }

    public function findByVendorId($id) {
        return $this->repository->where('vendor_id', $id)
            ->first();
    }

    public function findByEmail($email) {
        return $this->repository->where('email', $email)->get()->first();
    }

    public function findByIdAndPassword($id, $password) {
        return $this->repository->where('id', $id)->where('password', $password)->first();
    }

    public function save(User $user) {
        $user->save();
        return $user->id;
    }

    public function saveVendor(Vendor $vendor) {
        $vendor->save();
        return $vendor->id;
    }

}