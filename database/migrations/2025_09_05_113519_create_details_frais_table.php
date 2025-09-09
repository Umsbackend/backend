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
        Schema::create('details_frais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('situation_financiere_id')->constrained()->onDelete('cascade');
            $table->string('type_frais'); // académique, assurance, labo, stage
            $table->decimal('montant', 12, 2);
            $table->decimal('paye', 12, 2)->default(0);
            $table->decimal('restant', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_frais');
    }
};
