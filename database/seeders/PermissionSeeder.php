<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Liste des permissions avec description
        $permissions = [
            ["name" => "view document", "description" => "Voir un document"],

        ];


        // Insertion des permissions dans la base de données
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], ['description' => $permission['description']]);
        }

        // Création des rôles
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $editorRole = Role::updateOrCreate(['name' => 'editeur']);

        // Attribution des permissions au rôle admin
        $adminRole->givePermissionTo(Permission::all());

        // Attribution de quelques permissions au rôle editor
        $editorPermissions = [
            'view document version history',
            'create service/position',
            'view court/prosecution details',
        ];

        $editorRole->givePermissionTo($editorPermissions);

    }
}
