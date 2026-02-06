<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ProfilService;
use App\Interfaces\ProfilRepositoryInterface;
use App\Models\User;
use App\Exceptions\ProfileUpdateException;

class ProfilServiceTest extends TestCase
{
    public function test_updateProfile_success()
    {
        // 1️⃣ Créer un utilisateur factice
        $user = new User();
        $user->id = 1;
        $user->name = 'Test';

        // 2️⃣ Créer un mock de l'interface
        $repoMock = $this->createMock(ProfilRepositoryInterface::class);

        // 3️⃣ Définir le comportement attendu
        $repoMock->method('updateUser')
                 ->willReturn($user); // simulons que la mise à jour réussit

        // 4️⃣ Instancier le service avec le mock
        $service = new ProfilService($repoMock);

        // 5️⃣ Appeler la méthode correcte
        $result = $service->updateProfile($user, ['name' => 'NouveauNom']);

        // 6️⃣ Vérifier le résultat
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('NouveauNom', $result->name);
    }

    public function test_updateProfile_failure_throws_exception()
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'Test';

        $repoMock = $this->createMock(ProfilRepositoryInterface::class);

        // Simuler un échec
        $repoMock->method('updateUser')
                 ->willReturn(null);

        $service = new ProfilService($repoMock);

        $this->expectException(ProfileUpdateException::class);
        $this->expectExceptionMessage('Impossible de mettre à jour le profil');

        $service->updateProfile($user, ['name' => 'NouveauNom']);
    }
}
