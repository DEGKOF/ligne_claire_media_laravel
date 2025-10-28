<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('display_name')->nullable();

            // Champs pour les annonceurs
            $table->string('company_name')->nullable();
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->decimal('balance', 10, 2)->default(0);

            $table->enum('role', [
                'journaliste',
                'redacteur',
                'admin',
                'master_admin',
                'advertiser',
                'contributor',
                'investigator',
                'witness'
            ])->default('journaliste');

            $table->boolean('is_active')->default(true);

            // Statut spécifique pour les annonceurs
            $table->enum('advertiser_status', ['pending', 'active', 'suspended'])->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // Index pour optimiser les requêtes
            $table->index('role');
            $table->index(['role', 'is_active']);
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
