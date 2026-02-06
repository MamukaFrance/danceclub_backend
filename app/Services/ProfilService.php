<?php

namespace App\Services;

use App\Exceptions\ProfileUpdateException;
use App\Models\User;
// use App\Interfaces\ProfilRepositoryInterface;
use App\Repositories\Contracts\ProfilRepositoryInterface;

class ProfilService
{
    public function __construct(
        protected ProfilRepositoryInterface $profilRepositoryInterface
    ){}

    public function updateProfile(User $user, array $data): User
    {
        try {
             // 1. Appliquer les nouvelles données au modèle
            $user->fill($data);

            // 2. Vérifier s'il y a un vrai changement
            if (! $user->isDirty()) {
            return $user; 
            }

            // 3. Persister
            $user = $this->profilRepositoryInterface->updateUser($user);
            return $user;
        } catch (Thtrowable $e) {
            Log::error('Profile update failed', [
                'exception' => $e,
                'user' => $user,
            ]);
            throw new ProfileUpdateException('Impossible de mettre à jour le profil');
        }
       
    }
}
