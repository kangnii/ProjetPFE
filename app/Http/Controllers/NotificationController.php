<?php

namespace App\Http\Controllers;

use App\Models\WhatsappMessage;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use App\Exports\NotificationsExport;
use Maatwebsite\Excel\Facades\Excel;

class NotificationController extends Controller
{
    public function index()
    {

        //Recup normale
        $notifications = WhatsappMessage::where('status','sent')->orderBy('created_at', 'desc')->get();

        // Récupérer le nombre de messages envoyés par heure
        $messagesByHour = WhatsappMessage::selectRaw('HOUR(created_at) as hour, count(*) as count')
            ->where('status', 'sent')
            ->groupByRaw('HOUR(created_at)')
            ->orderBy('hour', 'asc')
            ->get();

        // Récupérer les messages envoyés par jour
        $messagesByDay = WhatsappMessage::selectRaw('DATE(created_at) as day, count(*) as count')
            ->where('status', 'sent')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('day', 'asc')
            ->get();


        return view('Squelette.messages_sent', compact('messagesByDay', 'messagesByHour', 'notifications'));
    }
    public function export()
    {
        return Excel::download(new NotificationsExport(), 'historique_envoi.xlsx');
    }
    public function echec(){
        $notifications = WhatsappMessage::where('status','failed')->orderBy('created_at', 'desc')->get();
        return view('Squelette.failed_sent', compact('notifications'));
    }
    public function renvoi($id)
    {
        $message= WhatsappMessage::find($id);

        // Appelle la logique d’envoi
        $success = app(WhatsappService::class)->sendMessage($message->phone ,$message->body);
        if($success){
        $message->delete();
        }
        return back()->with('success', $success ? 'Message renvoyé !' : 'Échec de l’envoi.');
    }
}
