<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Services\ProfilService;
use App\Exceptions\ProfileUpdateException;

class ProfileController extends Controller
{
    public function __construct(protected ProfilService $profilService){}

    public function edit()
    {
        return view('pages.profile', [
            'user' => auth()->user()
        ]);
    }

    public function update(UserRequest $request)
    {
        try {
            $this->profilService->updateProfile(
                auth()->user(),
                $request->validated()
            );

            return redirect()
                ->route('profile.edit')
                ->with('success', 'Profil mis à jour avec succès');

        } catch (ProfileUpdateException $e) {
            // Affiche le message métier au front
            return redirect()
                ->route('profile.edit')
                ->with('info', $e->getMessage());
        }
    }
}
