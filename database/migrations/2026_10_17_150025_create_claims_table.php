<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->string('traveler_name'); // Nom du voyageur
            $table->string('traveler_email'); // Email de contact
            $table->string('traveler_phone')->nullable(); // Téléphone (optionnel)
            $table->string('item_name'); // Ce que le voyageur a perdu (ex: Portefeuille noir)
            $table->text('description'); // Description détaillée
            $table->date('lost_on'); // Date de la perte

            // Lien facultatif vers l'objet trouvé (item_id nullable)
            $table->foreignId('item_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
