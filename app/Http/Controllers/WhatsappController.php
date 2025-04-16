<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\WhatsappMessage;

class WhatsappController extends Controller
{
    public function handle(Request $request)
    {
        if ($request->isMethod('get')) {
            return $this->verify($request);
        }

        $data = $request->all();

        foreach ($data['entry'] ?? [] as $entry) {
            foreach ($entry['changes'] ?? [] as $change) {
                $value = $change['value'] ?? [];

                if (isset($value['statuses'])) {
                    foreach ($value['statuses'] as $status) {
                        WhatsappMessage::where('message_id', $status['id'])->update([
                            'status' => $status['status'],
                        ]);
                        Log::info("✅ Statut WhatsApp mis à jour : " . $status['status']);
                    }
                }
            }
        }

        return response('OK', 200);
    }

    private function verify(Request $request)
    {
        $verify_token = env('WHATSAPP_WEBHOOK_VERIFY_TOKEN');
        $mode = $request->input('hub_mode');
        $token = $request->input('hub_verify_token');
        $challenge = $request->input('hub_challenge');

        if ($mode === 'subscribe' && $token === $verify_token) {
            return response($challenge, 200);
        }

        return response('Forbidden', 403);
    }
}
