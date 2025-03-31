<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function accueil() {
        return view('template');
    }
    public function messages_sent() {
        return view('Squelette.messages_sent');
    }
    public function messages_delivered() {
        return view('Squelette.messages_delivered');
    }
    public function failed_sent() {
        return view('Squelette.failed_sent');
    }
    public function clients() {
        return view('Squelette.clients');
    }
    public function suivi_messages() {
        return view('Squelette.suivi_messages');
    }
    public function configuration_messages() {
        return view('Squelette.configuration_messages');
    }
}
