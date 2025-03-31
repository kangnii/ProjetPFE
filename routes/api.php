<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\WhatsappWebhookController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/send-whatsapp', [WhatsAppController::class, 'send']);

Route::get('/webhook/whatsapp', [WhatsappWebhookController::class, 'verifyWebhook']); // Vérification du webhook
Route::post('/webhook/whatsapp', [WhatsappWebhookController::class, 'handleWebhook']); // Réception des statuts
