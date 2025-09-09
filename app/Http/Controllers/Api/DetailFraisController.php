<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailFrais;
use Illuminate\Http\Request;

class DetailFraisController extends Controller
{
    // Lister tous les détails
    public function index()
    {
        $details = DetailFrais::all();
        return response()->json($details);
    }

    // Créer un nouveau détail
    public function store(Request $request)
    {
        $validated = $request->validate([
            'situation_financiere_id' => 'required|exists:situation_financieres,id',
            'type_frais' => 'required|string',
            'montant' => 'required|numeric',
            'paye' => 'required|numeric',
            'restant' => 'required|numeric',
        ]);

        $detail = DetailFrais::create($validated);

        return response()->json($detail, 201);
    }

    // Voir un détail spécifique
    public function show($id)
    {
        $detail = DetailFrais::find($id);

        if (!$detail) {
            return response()->json(['message' => 'Detail not found'], 404);
        }

        return response()->json($detail);
    }

    // Mettre à jour un détail
    public function update(Request $request, $id)
    {
        $detail = DetailFrais::find($id);

        if (!$detail) {
            return response()->json(['message' => 'Detail not found'], 404);
        }

        $validated = $request->validate([
            'situation_financiere_id' => 'sometimes|exists:situations_financieres,id',
            'type_frais' => 'sometimes|string|max:255',
            'montant' => 'sometimes|numeric',
            'paye' => 'sometimes|numeric',
            'restant' => 'sometimes|numeric',
        ]);

        $detail->update($validated);

        return response()->json($detail);
    }

    // Supprimer un détail
    public function destroy($id)
    {
        $detail = DetailFrais::find($id);

        if (!$detail) {
            return response()->json(['message' => 'Detail not found'], 404);
        }

        $detail->delete();

        return response()->json(['message' => 'Detail deleted successfully']);
    }
}
