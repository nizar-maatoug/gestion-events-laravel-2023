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
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            $table->string("nom",60);
            $table->string("prenom",60);
            $table->enum("genre",['HOMME','FEMME']);
            $table->string("photo");
            $table->integer("score")->default(0)->unsigned();
            $table->foreignId("categorie_id")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId("equipe_id")->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athletes');
    }
};
