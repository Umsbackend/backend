<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AideFinanciere;
use Illuminate\Http\Request;

class AideFinanciereController extends Controller
{
    public function index()
    {
        return response()->json(AideFinanciere::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
        'situation_financiere_id' => 'required|exists:situation_financieres,id',
        'type' => 'required|string|in:Aide Bourse,Aide Social',
        'montant' => 'required|numeric|min:0',
        'date_versement' => 'required|date',

        ]);

        $af = AideFinanciere::create($data);

        return response()->json([
            'message' => 'Aide financière enregistrée avec succès',
            'data' => $af
        ], 201);
    }

    public function show(AideFinanciere $aides_financiere)
    {
        return response()->json($aides_financiere);
    }

    public function update(Request $request, AideFinanciere $aides_financiere)
    {
        $aides_financiere->update($request->all());

        return response()->json([
            'message' => 'Mise à jour réussie',
            'data' => $aides_financiere
        ]);
    }

    public function destroy(AideFinanciere $aides_financiere)
    {
        $aides_financiere->delete();

        return response()->json(['message' => 'Supprimé avec succès']);
    }
}

   