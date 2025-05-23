<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1) Mettre à jour les anciens utilisateurs sans mot de passe
        DB::table('users')
            ->whereNull('password')
            ->orWhere('password', '')
            ->update(['password' => 'CLEAN']);

        // 2) Modifier la colonne pour ajouter la valeur par défaut
        // Note : pour utiliser ->change(), assure-toi d'avoir installé doctrine/dbal
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')
                ->default('CLEAN')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')
                ->default(null)
                ->nullable(false)
                ->change();
        });
    }
};
