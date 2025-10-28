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
        Schema::create('witness_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('anonymous_allowed')->default(false); // autoriser publication anonyme
            $table->boolean('receive_notifications')->default(true);
            $table->json('categories_interest')->nullable(); // catégories d'intérêt
            $table->integer('testimonies_submitted')->default(0);
            $table->integer('testimonies_published')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('witness_profiles');
    }
};
