<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Liste
    public function index()
    {
        return response()->json(Enrollment::all());
    }

    // Enregistrement
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string',
            'postnom' => 'required|string',
            'prenom' => 'required|string',
            'sexe' => 'required|in:masculin,feminin',
            'etat_civil' => 'required|string',
            'lieu_naissance' => 'required|string',
            'date_naissance' => 'required|date',
            'contacts.email' => 'required|email',
            'engagements' => 'required|boolean',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path;
        }

        if ($request->hasFile('documents')) {
            $docs = [];
            foreach ($request->file('documents') as $file) {
                $docs[] = [
                    'nom' => $file->getClientOriginalName(),
                    'fichier' => $file->store('documents', 'public'),
                    'requis' => true,
                ];
            }
            $data['documents'] = $docs;
        }


        $enrollment = Enrollment::create($request->all());

        return response()->json([
            'message' => 'Demande d’inscription enregistrée avec succès',
            'data' => $enrollment
        ], 201);
    }

    // Affichage d’un dossier
    public function show(Enrollment $enrollment)
    {
        return response()->json($enrollment);
    }

    // Mise à jour
    public function update(Request $request, Enrollment $enrollment)
    {
        $enrollment->update($request->all());
        return response()->json(['message' => 'Mise à jour réussie', 'data' => $enrollment]);
    }

    // Suppression
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return response()->json(['message' => 'Supprimé avec succès']);
    }
}
