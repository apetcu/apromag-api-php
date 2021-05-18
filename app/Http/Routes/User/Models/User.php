<?php

namespace App\Http\Routes\User\Models;

use App\Http\Routes\Vendor\Models\Vendor;
use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseModel implements JWTSubject {
    use Notifiable;

    protected $fillable = [
        'firstName', 'lastName', 'email', 'password', 'role', 'profilePicture'
    ];

    protected $hidden = [
        'password', 'remember_token', 'vendor_id'
    ];

    public function vendor() {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public static function fromEntity($entity) {
        return array(
            'id' => $entity->id,
            'firstName' => $entity->firstName,
            'lastName' => $entity->lastName,
            'role' => $entity->role,
            'address' => $entity->address,
            'profilePicture' => $entity->profilePicture,
            'createdAt' => $entity->createdAt,
            'updatedAt' => $entity->updatedAt,
            'notifications' => $entity->vendor ? $entity->vendor->notificationCount : 0,
            'phone' => $entity->phone,
            'email' => $entity->email,
            'status' => $entity->status,
            'vendor' => $entity->role === 'VENDOR' ? Vendor::fromEntity($entity->vendor) : null
        );
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return ['role'=> $this->role];
        // TODO: Implement getJWTCustomClaims() method.
    }
}
