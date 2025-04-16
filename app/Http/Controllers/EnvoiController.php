<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Echeance;

class EnvoiController extends Controller
{
    public function index(){
        $echeances = Echeance::where('date_echeance', '>', Carbon::today())->get();
        Carbon::parse($echeances->date_echeance)->format('d/m/Y');
        return view('Squelette.accueil', compact('echeances'));
    }

}
