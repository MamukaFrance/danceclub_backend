<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\ProfilRepositoryInterface;

class EloquentProfilRepository implements ProfilRepositoryInterface
{
    public function updateUser(User $user): User
    {
        $user->save();
        return $user;
    }
    
    public function getUser(int $userId): User
    {
        return User::findOrFail($userId);
    }
}
