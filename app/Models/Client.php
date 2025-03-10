<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'prenom', 'numero','email'];
    protected $guard = ['id'];
    public function echeances(){
        return $this->hasMany(Echeance::class);
    }
}
