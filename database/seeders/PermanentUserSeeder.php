<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermanentUserSeeder extends Seeder
{
    /**
     * Seed 2 akun tetap:
     * - admin (karyawan)
     * - administrator (manager)
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'full_name' => 'Admin (Karyawan)',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['username' => 'administrator'],
            [
                'full_name' => 'Administrator (Manager)',
                'password' => Hash::make('superadmin123'),
                'role' => 'super_admin',
            ]
        );
    }
}
