<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->json('competences')->nullable(); // ['PHP','Laravel','React',...]
            $table->json('portfolio')->nullable();   // [{title, url, image}, ...]
            $table->enum('disponibilite', ['available', 'busy', 'unavailable'])->default('available');
            $table->decimal('tarif_jour', 10, 0)->nullable();  // Tarif journalier en FCFA
            $table->string('specialite')->nullable();
            $table->integer('annees_experience')->default(0);
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('website_url')->nullable();
            $table->integer('vues')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
