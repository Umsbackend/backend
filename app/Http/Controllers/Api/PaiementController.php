<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index()
    {
        return response()->json(Paiement::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
           'situation_financiere_id' => 'required|exists:situation_financieres,id',
            'montant' => 'required|numeric|min:0',
            'mode' => 'required|string|in:Visa,Virement,Mobile Money',
            'statut' => 'required|string|in:en_attente,confirme,echoue',
        ]);

        $paiement = Paiement::create($data);

        return response()->json([
            'message' => 'Paiement enregistré avec succès',
            'data' => $paiement
        ], 201);
    }

    public function show(Paiement $paiement)
    {
        return response()->json($paiement);
    }

    public function update(Request $request, Paiement $paiement)
    {
        $paiement->update($request->all());

        return response()->json([
            'message' => 'Mise à jour réussie',
            'data' => $paiement
        ]);
    }

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();

        return response()->json(['message' => 'Supprimé avec succès']);
    }
}