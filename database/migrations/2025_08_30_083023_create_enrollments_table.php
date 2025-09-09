<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->nullable();
            $table->string('photo')->nullable();
            $table->string('nom');
            $table->string('postnom');
            $table->string('prenom');
            $table->enum('sexe', ['masculin', 'feminin']);
            $table->string('etat_civil');
            $table->string('lieu_naissance');
            $table->date('date_naissance');
            $table->string('nationalite')->default('CONGOLAISE');

            // JSON pour regrouper les objets imbriqués
            $table->json('adresse');
            $table->json('contacts');

            // Choix académiques
            $table->string('annee_academique')->default('2024-2025');
            $table->enum('semestre', ['PREMIER', 'SECOND']);
            $table->json('premier_choix');
            $table->json('deuxieme_choix');

            // Diplôme + examen
            $table->json('dernier_diplome');
            $table->string('examen_admission', 50)->nullable();

            // Parents
            $table->json('pere');
            $table->json('mere');
            $table->json('supporteurs')->nullable();

            // Engagement
            $table->text('comment_connu');
            $table->text('pourquoi_choisi');
            $table->json('mutuelle');
            $table->boolean('engagements')->default(false);

            // Documents
            $table->json('documents')->nullable();
            $table->enum('status', ['pending', 'validated', 'rejected'])
                  ->default('pending'); // statut demande
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
