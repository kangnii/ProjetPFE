<?php

namespace App\Services;
use App\Models\WhatsappMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
//use Twilio\Exceptions\TwilioException;
//use Twilio\Rest\Client;

class WhatsappService
{
//    protected $twilio;
//    protected $from;
    protected $token;
    protected $phoneId;

    public function __construct()
    {
//        $sid = env('TWILIO_ACCOUNT_SID');
//        $token = env('TWILIO_AUTH_TOKEN');
//        $this->twilio = new Client($sid, $token);
//        $this->from = env('TWILIO_WHATSAPP_FROM');

            $this->token = env('WHATSAPP_TOKEN');
            $this->phoneId = env('WHATSAPP_NUMBER_ID');

    }


//    public function sendMessage($to, $message, $notificationId = null)
//    {
//        $data = [
//            "from" => $this->from,
//            "body" => $message,
//        ];
//
//        // Ajoute le callback pour le suivi du statut si un id est fourni
//        if ($notificationId) {
//            $data['statusCallback'] = route('twilio.callback', ['notification_id' => $notificationId]);
//        }
//
//        $response = $this->twilio->messages->create("whatsapp:+$to", $data);
//
//
//        return $response;
//
//    }



        public function sendMessage($to, $message){
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
                'sent_at' => now()
            ]);

            return $msg;
        }







}
