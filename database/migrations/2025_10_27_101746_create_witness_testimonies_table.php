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
        Schema::create('witness_testimonies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('category'); // Corruption, Injustice, Infrastructure, etc.
            $table->text('description');
            $table->string('location')->nullable(); // lieu de l'événement
            $table->timestamp('event_date')->nullable(); // date de l'événement
            $table->json('media_files')->nullable(); // fichiers vidéo/photo
            $table->boolean('anonymous_publication')->default(false);
            $table->boolean('consent_given')->default(false);
            $table->enum('status', ['pending', 'validated', 'rejected', 'published'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('witness_testimonies');
    }
};
