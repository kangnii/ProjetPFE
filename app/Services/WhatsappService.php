<?php

namespace App\Services;
use App\Models\WhatsappMessage;
use Illuminate\Support\Facades\Http;

class WhatsappService
{
    protected $token;
    protected $phoneId;

    public function __construct()
    {
        $this->token = env('WHATSAPP_TOKEN');
        $this->phoneId = env('WHATSAPP_NUMBER_ID');
    }

    public function sendMessage($to, $message)
    {
        $url = "https://graph.facebook.com/v22.0/{$this->phoneId}/messages";

        $response = Http::withToken($this->token)->post($url, [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => ['body' => $message]
        ]);

        $msg = WhatsappMessage::create([
            'phone' => $to,
            'body' => $message,
            'message_id' => optional($response->json()['messages'][0] ?? [])->id ?? null,
            'status' => $response->successful() ? 'sent' : 'failed',
            'sent_at' => now()->addHour() //stocker l'heure de l'envoi avec GMT + 1
        ]);

        return $msg;
    }

}
