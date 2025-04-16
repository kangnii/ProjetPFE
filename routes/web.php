<?php

use App\Http\Controllers\EcheanceContoller;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\ClientController;

Route::get('/accueil', [AccueilController::class, 'index'])->name('accueil');
Route::get('echeances/export/', [NotificationController::class, 'export'])->name('echeances.export');



Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
Route::post('/clients', [ClientController::class, 'store'])->name('client.store');
Route::get('/client/{id}/edit', [ClientController::class, 'edit'])->name('client.edit');
Route::put('/client/{id}', [ClientController::class, 'update'])->name('client.update');
Route::delete('/client/{id}', [ClientController::class, 'destroy'])->name('client.destroy');


Route::post('/import', [EcheanceContoller::class, 'import'])->name('echeances.import');
Route::get('/echeances', [EcheanceContoller::class, 'index'])->name('echeance.index');
Route::get('/echeance/create', [EcheanceContoller::class, 'create'])->name('echeance.create');
Route::post('/echeances', [EcheanceContoller::class, 'store'])->name('echeance.store');
Route::get('/echeance/{id}/edit', [EcheanceContoller::class, 'edit'])->name('echeance.edit');
Route::put('/echeance/{id}', [EcheanceContoller::class, 'update'])->name('echeance.update');
Route::delete('echeance/{id}', [EcheanceContoller::class, 'destroy'])->name('echeance.destroy');

Route::get('/messages-sent', [NotificationController::class, 'index'])->name('messages_sent.index');
Route::get('/failed-sent', [NotificationController::class, 'echec'])->name('failed_sent.index');
Route::post('/failed-sent/{id}/renvoi', [NotificationController::class, 'renvoi'])->name('message.renvoi');





