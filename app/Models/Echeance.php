<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echeance extends Model
{
    use HasFactory;
    protected $table = 'echeances';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nom', 'prenoms', 'numero_whatsapp', 'date_echeance',
        'numero_police', 'numeroclient', 'type_contrat'
    ];

    function client(){
        return $this->belongsTo(Client::class);
    }
}
