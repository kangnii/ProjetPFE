<?php

namespace App\Http\Controllers;

use App\Models\Echeance;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Imports\EcheancesImport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class EcheanceContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $echeances = Echeance::all();
        return view('Squelette.echeances', compact('echeances'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv'
        ]);
        Excel::import(new EcheancesImport, $request->file('file'));
        return back()->with('success', 'Excel Data Imported successfully.');

    }

    public function create()
    {
        $clients = Client::all();
        return view('Echeances.create_echeance', compact('clients'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'client'         => 'required|string',
            'type_contrat'   => 'required|string',
            'date_echeance'  => 'required|date',
        ]);

        // Récupération id du champ "client"
        $id = $request->input('client');


        // Recherche d’un client existant
        $client = Client::find($id);

        // Création de l’échéance associée
        Echeance::create([
            'nom'             => $client->nom,
            'prenoms'          => $client->prenoms,
            'numero_police'   => $request->input('numero_police'),
            'numero_whatsapp'   => $client->numero_whatsapp,
            'numeroclient'    => $client->numeroclient,
            'type_contrat'    => $request->input('type_contrat'),
            'date_echeance'   => $request->input('date_echeance'),
        ]);

        return redirect()->back()->with('success', 'Échéance ajoutée avec succès.');

    }

    public function edit($id){
        $echeance = Echeance::find($id);
        return view('Echeances.modify_echeance', compact('echeance'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenoms' => 'required|string',
            'numero_whatsapp' => 'required|max:20|:/^\+?regex[1-9]\d{1,14}$/',
            'numero_police' => 'required',
            'numeroclient' => 'required',
            'type_contrat' => 'required',
            'date_echeance' => 'required|date'
        ]);
        $echeance = Echeance::find($id);
        $echeance->update($request->all());

        return redirect()->route('echeance.index')->with('success', 'échéance mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $destroy = Echeance::find($id);
        if ($destroy) {
            $destroy->delete();
        }
        return redirect()->route('echeance.index');
    }
}
