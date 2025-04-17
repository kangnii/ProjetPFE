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
            90 => 'arrive dans 3 mois le',
            30 => 'arrive dans 1 mois le',
            14 => 'arrive dans 2 semaines le',
            7 => 'arrive dans 1 semaine le',
            3 => 'arrive dans 3 jours le',
            1 => 'arrive demain le',
            0 => ' est arrivé à son terme ce'
        ];

        foreach ($delais as $joursAvant => $texte) {
            $dateCible = Carbon::now()->addDays($joursAvant)->toDateString();

            $echeances = Echeance::whereDate('date_echeance', $dateCible)->get();

            foreach ($echeances as $echeance) {
                $dateEcheance = Carbon::parse($echeance->date_echeance);
                $message = "Bonjour M/Mme {$echeance->nom} {$echeance->prenoms}, votre échéance concernant votre Contrat {$echeance->type_contrat} numéro {$echeance->numero_police} {$texte} {$dateEcheance->format('d/m/Y')}.";
                $whatsapp->sendMessage($echeance->numero_whatsapp, $message);
                $this->info("Message envoyé à {$echeance->nom} {$echeance->prenoms} pour échéance du {$dateEcheance->format('d/m/Y')}");
            }
        }
    }
}
