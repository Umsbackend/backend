<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailFrais extends Model
{ 
    protected $table = 'details_frais';
    protected $fillable = [
        'situation_financiere_id',
        'type_frais',
        'montant',
        'paye',
        'restant',
    ];

    public function situationFinanciere()
    {
        return $this->belongsTo(SituationFinanciere::class);
    }
}

