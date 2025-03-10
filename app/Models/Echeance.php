<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Echeance extends Model
{
    protected $fillable = ['titre_echeance', 'clients_id', 'statut_id', 'fichier'];
    protected $dates = ['date_echeance'];
    public function clients(){
        return $this->belongsTo(Client::class);
    }
    public function statut(){
        return $this->belongsTo(Statut::class);
    }

}
