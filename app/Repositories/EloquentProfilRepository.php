<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\ProfilRepositoryInterface;

class EloquentProfilRepository implements ProfilRepositoryInterface
{
    public function updateUser(User $user): User
    {
        $user->save();
        return $user;
    }
}
