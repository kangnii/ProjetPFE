<?php

namespace App\Providers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class WhatsappService
{
    protected $client;
    protected $token;
    protected $phoneNumberId;

    public function __construct()
    {
        $this->client = new Client();
        $this->token = env('WHATSAPP_TOKEN');
        $this->phoneNumberId = env('WHATSAPP_NUMBER_ID');
    }

    /**
     * @throws GuzzleException
     */
    public function sendMessage($to, $templateName, $templateLanguage)
    {
        $url = "https://graph.facebook.com/v22.0/{$this->phoneNumberId}/messages";

        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => "Bearer {$this->token}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'template',
                'template' => ['name' => $templateName, 'language' => ['code' => $templateLanguage ] ]
            ],
        ]);


        return json_decode($response->getBody(), true);

    }

}






