<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Echeance;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class SendWhatsappMessage extends Command
{
    protected $signature = 'app:send-whatsapp-message';
    protected $description = 'Envoi de rappels WhatsApp pour les échéances proches';

    public function handle(WhatsAppService $whatsapp)
    {
        $delais = [
            90 => 'dans 3 mois',
            30 => 'dans 1 mois',
            14 => 'dans 2 semaines',
            7 => 'dans 1 semaine',
            3 => 'dans 3 jours',
            1 => 'demain',
            0 => 'à son terme'
        ];

        foreach ($delais as $joursAvant => $texte) {
            $dateCible = Carbon::now()->addDays($joursAvant)->toDateString();

            $echeances = Echeance::whereDate('date_echeance', $dateCible)->get();

            foreach ($echeances as $echeance) {
                $dateEcheance = Carbon::parse($echeance->date_echeance);
                $message = "Bonjour M/Mme {$echeance->nom} {$echeance->prenoms}, votre échéance arrive {$texte} (le {$dateEcheance->format('d/m/Y')}).";
                $whatsapp->sendMessage($echeance->numero_whatsapp, $message);

//                //créer notif avec statut initial queued
//                $notification = Notification::create([
//                    'message' => $message,
//                    'status' => 'queued'
//                ]);
//
//                // Envoie le message en passant l'id de la notification pour le callback
//                $result = $whatsapp->sendMessage($echeance->numero_whatsapp, $message, $notification->id);
//
//                // Mise à jour éventuelle initiale du statut (optionnelle, car le callback se chargera de la mise à jour)
//                $status = $result->status;
//                $notification->update(['status' => $status]);

                $this->info("Message envoyé à {$echeance->nom} {$echeance->prenoms} pour échéance du {$dateEcheance->format('d/m/Y')}");

            }
        }
    }
}
