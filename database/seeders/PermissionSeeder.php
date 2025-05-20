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
            ["name" => "Ajouter echeance", "description" => " Ajouter échéance"],
            ["name" => "Charger un fichier excel echeance", "description" => "Charger un fichier d'échéance excel"],
            ["name" => "Ajouter client", "description" => "Ajouter client"],
            ["name" => "Modifier client", "description" => "Modifier client"],
            ["name" => "Supprimer client", "description" => "Supprimer client"],
            ["name" => "Modifier echeance", "description" => "Modifier échéance"],
            ["name" => "Supprimer echeance", "description" => "Supprimer échéance"],
            ["name" => "Renvoyer echeance", "description" => "Renvoyer échéance"],
            ["name" => "Telecharger historique envoi", "description" => "Télécharger historique envoi"],
            ["name" => "Ajouter role", "description" => "Ajouter rôle"],
            ["name" => "Supprimer role", "description" => "Supprimer rôle"],
            ["name" => "Modifier role", "description" => "Modifier rôle"],
            ["name" => "Voir roles", "description" => "Voir rôles"],
            ["name" => "Voir clients", "description" => "Voir clients"],
            ["name" => "Voir echeances", "description" => "Voir échéances"],
            ["name" => "Voir messages envoyes", "description" => "Voir messages envoyés"],
            ["name" => "Voir envois echoues", "description" => "Voir envois échoués"],
            ["name" =>"activer utilisateur", "description" => "activer utilisateur"],
            ["name" =>"desactiver utilisateur", "description" => "désactiver utilisateur"],
            ["name" =>"Supprimer echec", "description" => "Supprimer échec"],
            ["name" =>"Creer utilisateur", "description" => "Créer utilisateur"],
            ["name" =>"Supprimer utilisateur", "description" => "Supprimer utilisateur"],
            ["name" =>"Voir utilisateurs", "description" => "Voir utilisateurs"],
        ];


        // Insertion des permissions dans la base de données
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], ['description' => $permission['description']]);
        }

        // Création des rôles
        $adminRole = Role::updateOrCreate(['name' => 'admin']);

        // Attribution des permissions au rôle admin
        $adminRole->givePermissionTo(Permission::all());


    }
}
