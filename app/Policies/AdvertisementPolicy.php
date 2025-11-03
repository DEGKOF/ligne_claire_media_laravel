<?php

namespace App\Policies;

use App\Models\Advertisement;
use App\Models\User;

class AdvertisementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdvertiser();
    }

    public function view(User $user, Advertisement $advertisement): bool
    {
        return $user->id === $advertisement->advertiser_id || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdvertiser() && $user->advertiserProfile?->isActive();
    }

    public function update(User $user, Advertisement $advertisement): bool
    {
        return $user->id === $advertisement->advertiser_id;
    }

    public function delete(User $user, Advertisement $advertisement): bool
    {
        return $user->id === $advertisement->advertiser_id || $user->isAdmin();
    }
}
