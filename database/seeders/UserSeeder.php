<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],  // Condition de recherche
            [
                'name' => 'admin',
                'password' => Hash::make('admin'),

            ]);

        $admin->assignRole('admin');


        $wisdom = User::updateOrCreate(
            ['email' => 'wisdomfollygan@gmail.com'],  // Condition de recherche
            [
                'name' => 'Wisdom Follygan',
                'password' => Hash::make('wisdom'),

            ]);

        $wisdom->assignRole('admin');

    }
}
