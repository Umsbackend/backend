<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model

{
    protected $fillable = [
        'matricule', 'photo', 'nom', 'postnom', 'prenom', 'sexe', 'etat_civil',
        'lieu_naissance', 'date_naissance', 'nationalite',
        'adresse', 'contacts',
        'annee_academique', 'semestre', 'premier_choix', 'deuxieme_choix',
        'dernier_diplome', 'examen_admission',
        'pere', 'mere', 'supporteurs',
        'comment_connu', 'pourquoi_choisi', 'mutuelle', 'engagements',
        'documents'
    ];

    protected $casts = [
        'adresse' => 'array',
        'contacts' => 'array',
        'premier_choix' => 'array',
        'deuxieme_choix' => 'array',
        'dernier_diplome' => 'array',
        'pere' => 'array',
        'mere' => 'array',
        'supporteurs' => 'array',
        'mutuelle' => 'array',
        'documents' => 'array',
        // ✅ on supprime le cast 'examen_admission' => 'boolean',
        'engagements' => 'boolean',
    ];
}
