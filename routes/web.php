<?php

use App\Http\Controllers\EcheanceContoller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\ClientController;

Route::get('/accueil', [AccueilController::class, 'index'])->name('accueil');

Route::middleware(['auth', 'permission:Ajouter echeance'])->group(function(){
    Route::get('/echeance/create', [EcheanceContoller::class, 'create'])->name('echeance.create');
    Route::post('/echeances', [EcheanceContoller::class, 'store'])->name('echeance.store');
});

Route::middleware(['auth', 'permission:Ajouter client'])->group(function(){
    Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('client.store');
});

Route::middleware(['auth', 'permission:Ajouter role'])->group(function(){
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
});

Route::middleware(['auth', 'permission:Voir roles'])->group(function(){
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
});

Route::middleware(['auth', 'permission:Modifier role'])->group(function(){
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
});

Route::middleware(['auth', 'permission:Supprimer role'])->group(function(){
    Route::delete('/roles/{role}/delete', [RoleController::class, 'destroy'])->name('roles.destroy');

});

Route::middleware(['auth', 'permission:Charger un fichier excel echeance'])->group(function(){
    Route::post('/import', [EcheanceContoller::class, 'import'])->name('echeances.import');
});

Route::middleware(['auth', 'permission:Modifier client'])->group(function(){
    Route::get('/client/{id}/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('/client/{id}', [ClientController::class, 'update'])->name('client.update');
});

Route::middleware(['auth', 'permission:Supprimer client'])->group(function(){
    Route::delete('/client/{id}', [ClientController::class, 'destroy'])->name('client.destroy');
});

Route::middleware(['auth', 'permission:Modifier echeance'])->group(function(){
    Route::get('/echeance/{id}/edit', [EcheanceContoller::class, 'edit'])->name('echeance.edit');
    Route::put('/echeance/{id}', [EcheanceContoller::class, 'update'])->name('echeance.update');
});

Route::middleware(['auth', 'permission:Supprimer echeance'])->group(function(){
    Route::delete('echeance/{id}', [EcheanceContoller::class, 'destroy'])->name('echeance.destroy');
});

Route::middleware(['auth', 'permission:Supprimer echeance'])->group(function(){
    Route::delete('echeance/{id}', [EcheanceContoller::class, 'destroy'])->name('echeance.destroy');
});

Route::middleware(['auth', 'permission:Telecharger historique envoi'])->group(function(){
    Route::get('echeances/export/', [NotificationController::class, 'export'])->name('echeances.export');
});

Route::middleware(['auth', 'permission:Voir clients'])->group(function(){
    Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
});

Route::middleware(['auth', 'permission:Voir echeances'])->group(function(){
    Route::get('/echeances', [EcheanceContoller::class, 'index'])->name('echeance.index');
});

Route::middleware(['auth', 'permission:Voir messages envoyes'])->group(function(){
    Route::get('/messages-sent', [NotificationController::class, 'index'])->name('messages_sent.index');
});

Route::middleware(['auth', 'permission:Voir envois echoues'])->group(function(){
    Route::get('/failed-sent', [NotificationController::class, 'echec'])->name('failed_sent.index');
});

Route::middleware(['auth', 'permission:Renvoyer echeance'])->group(function(){
    Route::post('/failed-sent/{id}/renvoi', [NotificationController::class, 'renvoi'])->name('message.renvoi');
});














