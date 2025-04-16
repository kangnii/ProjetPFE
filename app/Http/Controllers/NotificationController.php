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
        $notifications = WhatsappMessage::where('status','sent')->orderBy('created_at', 'desc')->get();
        return view('Squelette.messages_sent', compact('notifications'));
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

        return back()->with('success', $success ? 'Message renvoyé !' : 'Échec de l’envoi.');
    }
}
