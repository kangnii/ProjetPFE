<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EcheanceContoller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\ClientController;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/check-user', [AuthController::class, 'checkUser']);
Route::post('/login/store', [AuthController::class, 'LoginFormStore'])->name('login.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
//    Route::post('/profile/', [AuthController::class, 'profile'])->name('update.profile');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/accueil', [AccueilController::class, 'index'])->name('accueil');


    Route::group(['middleware' => ['permission:Ajouter echeance']],function(){
        Route::get('/echeance/create', [EcheanceContoller::class, 'create'])->name('echeance.create');
        Route::post('/echeances', [EcheanceContoller::class, 'store'])->name('echeance.store');
    });

    Route::group(['middleware' => ['permission:Ajouter client']],function(){
        Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
        Route::post('/clients', [ClientController::class, 'store'])->name('client.store');
    });

    Route::group(['middleware' => ['permission:Ajouter role']],function(){
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    });

    Route::group(['middleware' => ['permission:Voir roles']],function(){
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    });

    Route::group(['middleware' => ['permission:Modifier role']],function(){
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    });

    Route::group(['middleware' => ['permission:Supprimer role']],function(){
        Route::delete('/roles/{role}/delete', [RoleController::class, 'destroy'])->name('roles.destroy');

    });

    Route::group(['middleware' => ['permission:Charger un fichier excel echeance']],function(){
        Route::post('/import', [EcheanceContoller::class, 'import'])->name('echeances.import');
    });

    Route::group(['middleware' => ['permission:Modifier client']],function(){
        Route::get('/client/{id}/edit', [ClientController::class, 'edit'])->name('client.edit');
        Route::put('/client/{id}', [ClientController::class, 'update'])->name('client.update');
    });

    Route::group(['middleware' => ['permission:Supprimer client']],function(){
        Route::delete('/client/{id}', [ClientController::class, 'destroy'])->name('client.destroy');
    });

    Route::group(['middleware' => ['permission:Modifier echeance']],function(){
        Route::get('/echeance/{id}/edit', [EcheanceContoller::class, 'edit'])->name('echeance.edit');
        Route::put('/echeance/{id}', [EcheanceContoller::class, 'update'])->name('echeance.update');
    });

    Route::group(['middleware' => ['permission:Supprimer echeance']],function(){
        Route::delete('echeance/{id}', [EcheanceContoller::class, 'destroy'])->name('echeance.destroy');
    });


    Route::group(['middleware' => ['permission:Telecharger historique envoi']],function(){
        Route::get('echeances/export/', [NotificationController::class, 'export'])->name('echeances.export');
    });

    Route::group(['middleware' => ['permission:Voir clients']],function(){
        Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
    });

    Route::group(['middleware' => ['permission:Voir echeances']],function(){
        Route::get('/echeances', [EcheanceContoller::class, 'index'])->name('echeance.index');
    });

    Route::group(['middleware' => ['permission:Voir messages envoyes']],function(){
        Route::get('/messages-sent', [NotificationController::class, 'index'])->name('messages_sent.index');
    });

    Route::group(['middleware' => ['permission:Voir envois echoues']],function(){
        Route::get('/failed-sent', [NotificationController::class, 'echec'])->name('failed_sent.index');
    });

    Route::group(['middleware' => ['permission:Renvoyer echeance']],function(){
        Route::post('/failed-sent/{id}/renvoi', [NotificationController::class, 'renvoi'])->name('message.renvoi');
    });

});












