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
        return view('web.pages.profile', [
            'user' => auth()->user()
        ]);
    }

    public function update(UserRequest $request)
    {
        try {
            $user = $this->profilService->updateProfile(
                auth()->user(),
                $request->validated()
            );
            if (! $user->wasChanged()) {
                return redirect()
                    ->route('profile.edit')
                    ->with('info', 'Aucune modification détectée');
            }

            return redirect()
                ->route('profile.edit')
                ->with('success', 'Profil mis à jour avec succès');

        } catch (ProfileUpdateException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
