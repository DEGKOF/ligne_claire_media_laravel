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
        Schema::create('investigation_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('theme'); // Corruption, Environnement, Santé publique, etc.
            $table->text('angle'); // angle journalistique
            $table->text('sources')->nullable(); // sources disponibles
            $table->string('format'); // Article long, Vidéo, Podcast, Infographie
            $table->decimal('budget', 20, 2)->nullable();
            $table->integer('estimated_weeks')->nullable();
            $table->text('needs')->nullable(); // besoins spécifiques
            $table->json('files')->nullable(); // fichiers joints
            $table->enum('status', ['pending', 'validated', 'rejected', 'in_progress', 'completed'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->decimal('budget_collected', 10, 2)->default(0);
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigation_proposals');
    }
};
