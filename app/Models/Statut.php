<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    protected $fillable = ['libelle'];
    protected $guards = ['id'];
    public function echeances(){
        return $this->hasMany(Echeance::class);
    }
}
