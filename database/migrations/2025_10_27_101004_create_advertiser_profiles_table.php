<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertiser_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Informations entreprise
            $table->string('company_name')->nullable();
            $table->string('legal_form')->nullable(); // SARL, SA, EI, etc.
            $table->string('rccm')->nullable(); // Registre de Commerce
            $table->string('ifu')->nullable(); // Identifiant Fiscal Unique
            $table->string('sector')->nullable(); // Secteur d'activité
            $table->integer('employees_count')->nullable();
            $table->year('founded_year')->nullable();

            // Coordonnées
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('Bénin');
            $table->string('phone')->nullable();
            $table->string('website')->nullable();

            // Contact commercial
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_position')->nullable(); // Poste

            // Documents
            $table->string('logo')->nullable();
            $table->string('company_document')->nullable(); // Statuts, registre
            $table->string('id_document')->nullable(); // Pièce d'identité du responsable

            // Statut et validation
            $table->enum('status', ['pending', 'active', 'suspended', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->foreignId('validated_by')->nullable()->constrained('users');

            // Facturation
            $table->decimal('balance', 10, 2)->default(0)->nullable();
            $table->decimal('credit_limit', 10, 2)->default(0);
            $table->boolean('auto_recharge')->default(false);
            $table->decimal('auto_recharge_threshold', 10, 2)->nullable();
            $table->decimal('auto_recharge_amount', 10, 2)->nullable();

            // Notifications
            $table->boolean('notify_low_balance')->default(true);
            $table->boolean('notify_campaign_end')->default(true);
            $table->boolean('notify_campaign_approved')->default(true);

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertiser_profiles');
    }
};
