<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function index()
//    {
//        return view('Squelette.clients');
//    }

    public function create()
    {
        return view('Clients.client_create');

    }

    public function store(Request $request)
    {
        $validate = request()->validate([
            'nom' => 'required|string',
            'prenoms' => 'required|string',
            'numero_whatsapp' => 'required|max:20|unique:clients,numero_whatsapp|:/^\+?regex[1-9]\d{1,14}$/',
            'numeroclient' => 'required|unique:clients,numeroclient'
        ]);
        $client = new Client();
       $client ->nom = request() ->input('nom');
       $client ->prenoms = request() ->input('prenoms');
       $client ->numero_whatsapp = request() ->input('numero_whatsapp');
       $client ->numeroclient = request() ->input('numeroclient');


       $client->save();

        return redirect()->route('client.create')->with('success', 'Client ajouté avec succès !');

    }

    /**
     * Display the specified resource.
     */
    public function index()
    {
        $clients = Client::all();
        return view('Squelette.clients', compact('clients'));
    }

    public function edit(Request $request, $id)
    {
        $client = Client::find($id);
        return view('Clients.client_modify', compact('client'));

    }

    public function update(Request $request, $id)
    {
            $request->validate([
                'nom' => 'required|string',
                'prenoms' => 'required|string',
                'numero_whatsapp' => 'required|max:20|:/^\+?regex[1-9]\d{1,14}$/',
                'numeroclient' => 'required'
            ]);
            $client = Client::find($id);
            $client->update($request->all());

        return redirect()->route('client.index')->with('success', 'Client mis à jour avec succès.');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        if ($client) {
            $client->delete();
        }
          return redirect()->route('client.index')->with('success', 'Client supprimé avec succès.');
    }

}
