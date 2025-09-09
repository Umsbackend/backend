<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AideFinanciere extends Model
{
    protected $table = 'aides_financieres'; // <-- corrige ici

    protected $fillable = [
        'situation_financiere_id',
        'type',
        'montant',
        'date_versement',
    ];

    public function situationFinanciere()
    {
        return $this->belongsTo(SituationFinanciere::class);
    }
}