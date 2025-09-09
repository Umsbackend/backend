<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    public function index()
    {
        return response()->json(Enrollment::all());
    }

    public function store(Request $request)
    {
        $data = $request->except(['photo', 'documents']);
        $data = $this->normalizeData($data);
        $validator = $this->validateData($data);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated = $this->handleFiles($request, $validated);
        $enrollment = Enrollment::create($validated);

        return response()->json([
            'message' => 'Demande d’inscription enregistrée avec succès',
            'data' => $enrollment
        ], 201);
    }

    public function show(Enrollment $enrollment)
    {
        return response()->json($enrollment);
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $data = $request->except(['photo', 'documents']);
        $data = $this->normalizeData($data);
        $validator = $this->validateData($data, $enrollment->id);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated = $this->handleFiles($request, $validated, $enrollment);
        $enrollment->update($validated);

        return response()->json([
            'message' => 'Mise à jour réussie',
            'data' => $enrollment
        ]);
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return response()->json(['message' => 'Supprimé avec succès']);
    }

    private function normalizeData(array $data): array
    {
        if (isset($data['engagements'])) {
            $val = strtolower(trim($data['engagements']));
            $data['engagements'] = in_array($val, ['1', 'true', 'oui', 'yes']) ? true : false;
        }

        if (isset($data['sexe'])) {
            $val = strtolower(trim($data['sexe']));
            $data['sexe'] = in_array($val, ['m', 'masculin']) ? 'masculin' : 'feminin';
        }

        return $data;
    }
private function validateData(array $data, $id = null)
{
    return Validator::make($data, [
        'matricule' => 'required|string|max:50|unique:enrollments,matricule,' . ($id ?? 'NULL'),
        'nom' => 'required|string|max:100',
        'postnom' => 'required|string|max:100',
        'prenom' => 'required|string|max:100',
        'sexe' => 'required|in:masculin,feminin',
        'etat_civil' => 'required|string|max:50',
        'lieu_naissance' => 'required|string|max:100',
        'date_naissance' => 'required|date',
        'nationalite' => 'nullable|string|max:100',

        // Champs castés en array
        'adresse' => 'nullable|array',
        'adresse.*' => 'string|max:255',

        'contacts' => 'nullable|array',
        'contacts.*' => 'string|max:50',

        'annee_academique' => 'nullable|string|max:20',
        'semestre' => 'nullable|string|max:10',

        'premier_choix' => 'nullable|array',
        'premier_choix.*' => 'string|max:100',

        'deuxieme_choix' => 'nullable|array',
        'deuxieme_choix.*' => 'string|max:100',

        'dernier_diplome' => 'nullable|array',
        'dernier_diplome.*' => 'string|max:100',

        'examen_admission' => 'nullable|boolean',

        'pere' => 'nullable|array',
        'pere.*' => 'string|max:100',

        'mere' => 'nullable|array',
        'mere.*' => 'string|max:100',

        'supporteurs' => 'nullable|array',
        'supporteurs.*' => 'string|max:255',

        'comment_connu' => 'nullable|string|max:255',
        'pourquoi_choisi' => 'nullable|string|max:255',

        'mutuelle' => 'nullable|array',
        'mutuelle.*' => 'string|max:50',

        // Fichiers
        'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        'documents' => 'nullable|array',
        'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',

        'engagements' => 'required|boolean',

        // Statut
        'status' => ['required', Rule::in(['actif', 'inactif', 'rejete'])],
    ]);
}


    private function handleFiles(Request $request, array $data, $enrollment = null): array
    {
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
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

        return $data;
    }
}
