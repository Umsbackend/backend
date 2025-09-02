<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

namespace App\Http\Controllers;

use App\Models\DemandeInscription;
use App\Models\Enrollment;
use App\Models\Etudiant;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DemandeController extends Controller
{
    public function valider($id)
    {
        $demande = Enrollment::findOrFail($id);

        // 1. Générer un matricule unique
        $matricule = "ETU-" . date('Y') . "-" . Str::upper(Str::random(5));

        // 2. Générer un email institutionnel
        $emailInstitutionnel = strtolower($demande->prenom . "." . $demande->nom) . "@univ-rdc.cd";

        // 3. Créer un mot de passe par défaut
        $passwordDefaut = "12345678";

        // 4. Créer un user
        $user = User::create([
            'name' => $demande->prenom . " " . $demande->nom,
            'email' => $emailInstitutionnel,
            'password' => Hash::make($passwordDefaut),
            'role' => 'etudiant'
        ]);

        // 5. Enregistrer l’étudiant
        $etudiant = Student::create([
            'matricule' => $matricule,
            'nom' => $demande->nom,
            'postnom' => $demande->postnom,
            'prenom' => $demande->prenom,
            'email_institutionnel' => $emailInstitutionnel,
            'date_naissance' => $demande->date_naissance,
            'sexe' => $demande->sexe,
            'adresse' => $demande->adresse,
            'user_id' => $user->id,
        ]);

        // 6. Mettre à jour la demande
        $demande->update([
            'status' => 'validee'
        ]);

        return response()->json([
            'message' => 'Demande validée avec succès',
            'etudiant' => $etudiant,
            'user' => $user
        ]);
    }
}

