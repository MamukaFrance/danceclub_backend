<?php

namespace App\Services;

use App\Exceptions\ProfileUpdateException;
use App\Models\User;
use App\Interfaces\ProfilRepositoryInterface;

class ProfilService
{
    public function __construct(
        protected ProfilRepositoryInterface $profilRepositoryInterface
    ){}

    public function updateProfile(User $user, array $data): User
    {
        // 1. Appliquer les nouvelles données au modèle
        $user->fill($data);

        // 2. Vérifier s'il y a un vrai changement
        if (! $user->isDirty()) {
            // lancer une exception métier
            throw new ProfileUpdateException('Aucune modification détectée');
        }

        // 3. Persister
        if (! $this->profilRepositoryInterface->updateUser($user)) {
            throw new ProfileUpdateException('Impossible de mettre à jour le profil');
        }

        return $user;
    }

    public function getUser(int $userId): User
    {
        return $this->profilRepositoryInterface->getUser($userId);
    }
}
