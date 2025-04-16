<?php

namespace App\Http\Controllers;

use App\Models\Echeance;
use App\Models\Notification;
use App\Models\WhatsappMessage;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index(){
        // Récupère toutes les échéances (ou seulement celles pertinentes)
        $echeances = Echeance::where('date_echeance', '>=', today())->orderBy('date_echeance', 'asc')->get();


        // Récupère les dernières notifications (enregistrements de messages envoyés)
        $messages = WhatsappMessage::orderBy('created_at', 'desc')->get();

        $success = WhatsappMessage::where('status', 'sent')->orderBy('created_at', 'desc')->get();
        $fail = WhatsappMessage::where('status', 'failed')->orderBy('created_at', 'desc')->get();
        $total = WhatsappMessage::all();

        return view('Squelette.accueil', compact('echeances', 'messages', 'success', 'fail', 'total'));
    }
}
