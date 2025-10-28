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
        Schema::create('investigator_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('expertise_areas')->nullable(); // domaines d'expertise
            $table->string('portfolio_url')->nullable();
            $table->text('experience')->nullable(); // description de l'expérience
            $table->json('languages')->nullable(); // langues parlées
            $table->boolean('is_verified')->default(false); // vérifié par LCM
            $table->integer('investigations_completed')->default(0);
            $table->decimal('total_budget_managed', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigator_profiles');
    }
};
