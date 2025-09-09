<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Afficher la liste des étudiants
     */
    public function index()
    {
        return response()->json(Student::all(), 200);
    }

    /**
     * Ajouter un nouvel étudiant
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|unique:students,matricule',
            'nom' => 'required|string|max:255',
            'postnom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email_institutionnel' => 'required|email|unique:students,email_institutionnel',
            'date_naissance' => 'required|date',
            'sexe' => ['required', Rule::in(['M', 'F'])],
            'adresse' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
            'status' => ['required', Rule::in(['actif', 'inactif', 'rejete'])],
        ]);

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Étudiant créé avec succès',
            'data' => $student
        ], 201);
    }

    /**
     * Afficher un étudiant précis
     */
    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        return response()->json($student, 200);
    }

    /**
     * Mettre à jour un étudiant
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        $validated = $request->validate([
            'matricule' => 'sometimes|string|unique:students,matricule,' . $student->id,
            'nom' => 'sometimes|string|max:255',
            'postnom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'email_institutionnel' => 'sometimes|email|unique:students,email_institutionnel,' . $student->id,
            'date_naissance' => 'sometimes|date',
            'sexe' => ['sometimes', Rule::in(['M', 'F'])],
            'adresse' => 'sometimes|string|max:255',
            'user_id' => 'sometimes|integer|exists:users,id',
            'status' => ['sometimes', Rule::in(['actif', 'inactif', 'rejete'])],
        ]);

        $student->update($validated);

        return response()->json([
            'message' => 'Étudiant mis à jour avec succès',
            'data' => $student
        ], 200);
    }

    /**
     * Supprimer un étudiant
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        $student->delete();

        return response()->json(['message' => 'Étudiant supprimé avec succès'], 200);
    }
}
