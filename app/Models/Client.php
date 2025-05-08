<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = ['nom','prenoms','numero_whatsapp', 'numeroclient', 'numero_police'];
    protected $primaryKey = 'id';
    protected $dates = ['created_at','updated_at'];

    function echeances(){
        return $this->hasMany(Echeance::class);
    }



}
