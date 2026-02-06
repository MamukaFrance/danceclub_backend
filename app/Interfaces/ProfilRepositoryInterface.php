<?php

namespace App\Interfaces;

use App\Models\User;

interface ProfilRepositoryInterface
{
    public function updateUser(User $user): ?User;
    
    public function getUser(int $userId): ?User;

}