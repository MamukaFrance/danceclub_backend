<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('test123'),
            ]);
        $admin->assignRole('admin');

        $editor1 = User::create([
            'name' => 'editor1',
            'email' => 'editor1@test.com',
            'password' => Hash::make('test123'),
        ]);
        $editor1->assignRole('editor');

        $editor2 = User::create([
            'name' => 'editor2',
            'email' => 'editor2@test.com',
            'password' => Hash::make('test123'),
        ]);
        $editor2->assignRole('editor');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => Hash::make('test123'),        
        ]);
        $user->assignRole('user');
    }
}
