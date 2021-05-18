<?php

namespace App\Http\Routes\Social;

use App\Http\Routes\Social\Models\SocialFacebookAccount;
use App\Http\Routes\User\Models\User;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialService {

    public function createOrGetUser(ProviderUser $providerUser) {
        $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);
            $user = User::whereEmail($providerUser->getEmail())->first();
            if (!$user) {
                $userFirstLastName = $this->getFirstLastNames($providerUser->getName());
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'firstName' => $userFirstLastName['first_name'],
                    'lastName' => $userFirstLastName['last_name'],
                    'profilePicture' => $providerUser->getAvatar(),
                    'password' => bcrypt(rand(1, 10000)),
                    'role' => 'CUSTOMER'
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }

    protected function getFirstLastNames($fullName) {
        $parts = array_values(array_filter(explode(" ", $fullName)));

        $size = count($parts);

        if (empty($parts)) {
            $result['first_name'] = NULL;
            $result['last_name'] = NULL;
        }

        if (!empty($parts) && $size == 1) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = NULL;
        }

        if (!empty($parts) && $size >= 2) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = $parts[1];
        }

        return $result;
    }
}