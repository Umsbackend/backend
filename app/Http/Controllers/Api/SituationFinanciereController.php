<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SituationFinanciere;
use Illuminate\Http\Request;

class SituationFinanciereController extends Controller
{
    
    public function index()
    {
        return response()->json(SituationFinanciere::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
        'student_id' => 'required|exists:students,id',
        'montant_total' => 'required|numeric',
        'montant_paye' => 'required|numeric',
        'montant_restant' => 'required|numeric',
        'identite' => 'nullable|string|max:255',
        'pourcentage_paiement' => 'nullable|integer|min:0|max:100',
        'date_limite' => 'nullable|date',
        ]);

        $sf = SituationFinanciere::create($data);

        return response()->json([
            'message' => 'Situation financière enregistrée avec succès',
            'data' => $sf
        ], 201);
    }

    public function show(SituationFinanciere $situations_financiere)
    {
        return response()->json($situations_financiere);
    }

    public function update(Request $request, SituationFinanciere $situations_financiere)
    {
        $situations_financiere->update($request->all());

        return response()->json([
            'message' => 'Mise à jour réussie',
            'data' => $situations_financiere
        ]);
    }

    public function destroy(SituationFinanciere $situations_financiere)
    {
        $situations_financiere->delete();

        return response()->json(['message' => 'Supprimé avec succès']);
    }
}