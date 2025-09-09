<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'situation_financiere_id',
        'montant',
        'mode',
        'statut',
    ];

    public function situationFinanciere()
    {
        return $this->belongsTo(SituationFinanciere::class);
    }
}