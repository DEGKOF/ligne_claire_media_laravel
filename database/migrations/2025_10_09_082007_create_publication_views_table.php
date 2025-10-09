<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publication_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publication_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->timestamp('viewed_at');

            // Index pour éviter les doublons rapides (même IP dans les 5 minutes)
            $table->index(['publication_id', 'ip_address', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publication_views');
    }
};
