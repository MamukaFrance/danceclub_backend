<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Supprimer les rôles et permissions existants pour éviter les doublons
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::truncate();
        Role::truncate();

        // 2️⃣ Créer les permissions pour les posts
        $permissions = [
            'create posts',
            'edit posts',
            'delete posts',
            'view posts',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 3️⃣ Créer les rôles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $userRole = Role::create(['name' => 'user']);

        // 4️⃣ Assigner les permissions aux rôles
        $adminRole->givePermissionTo(Permission::all()); // Admin peut tout
        $editorRole->givePermissionTo(['create posts', 'edit posts', 'view posts']); // pas supprimer
        $userRole->givePermissionTo(['view posts']); // lecture seule
    }
}
