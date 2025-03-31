<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/accueil', [PageController::class,'accueil'])->name('accueil');
Route::get('/messages-sent', [PageController::class,'messages_sent'])->name('messages_sent');
Route::get('/messages-delivered', [PageController::class,'messages_delivered'])->name('messages_delivered');
Route::get('/failed-sent', [PageController::class,'failed_sent'])->name('failed_sent');
Route::get('/clients', [PageController::class,'clients'])->name('clients');
Route::get('/suivi-messages', [PageController::class,'suivi_messages'])->name('suivi_messages');
Route::get('/configuration-messages', [PageController::class,'configuration_messages'])->name('configuration_messages');



Route::get('/whatsapp', [WhatsappController::class,'index'])->name('index');
Route::post('/whatsapp/send', [WhatsappController::class,'send'])->name('send');
