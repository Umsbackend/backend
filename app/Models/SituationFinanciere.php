<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SituationFinanciere extends Model
{
    protected $table = 'situations_financieres';
    protected $fillable = [
        'student_id',
        'montant_total',
        'montant_paye',
        'montant_restant',
        'identite',
        'pourcentage_paiement',
        'date_limite',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function detailsFrais()
    {
        return $this->hasMany(DetailFrais::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function aides()
    {
        return $this->hasMany(AideFinanciere::class);
    }

}
