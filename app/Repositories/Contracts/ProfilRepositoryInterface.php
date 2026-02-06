<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface ProfilRepositoryInterface
{
    public function updateUser(User $user): ?User;
}