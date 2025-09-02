<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'matricule',
        'nom',
        'postnom',
        'prenom',
        'email_institutionnel',
        'date_naissance',
        'sexe',
        'adresse',
        'user_id',
        'status',
    ];

    // relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
