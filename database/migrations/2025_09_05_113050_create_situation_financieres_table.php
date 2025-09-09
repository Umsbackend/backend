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
        Schema::create('situation_financieres', function (Blueprint $table) {
             $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->decimal('montant_total', 12, 2);
            $table->decimal('montant_paye', 12, 2)->default(0);
            $table->decimal('montant_restant', 12, 2);
            $table->string('identite')->nullable();
            $table->integer('pourcentage_paiement')->default(0);
            $table->date('date_limite')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('situation_financieres');
    }
};
