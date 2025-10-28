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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Numéro de commande unique
            $table->foreignId('issue_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Si connecté

            // Informations client
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();

            // Format et livraison
            $table->enum('format', ['paper', 'digital']); // papier ou numérique
            $table->string('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_country')->default('Bénin');

            // Paiement
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['card', 'mobile_money', 'bank_transfer']);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('transaction_id')->nullable(); // ID de transaction du gateway
            $table->timestamp('paid_at')->nullable();

            // Statut de la commande
            $table->enum('status', [
                'pending',           // En attente de paiement
                'paid',             // Payé
                'processing',       // En préparation
                'shipped',          // Expédié (pour version papier)
                'delivered',        // Livré / Téléchargé
                'cancelled',        // Annulé
                'refunded'         // Remboursé
            ])->default('pending');

            $table->text('notes')->nullable(); // Notes internes
            $table->string('tracking_number')->nullable(); // Numéro de suivi pour version papier

            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index('order_number');
            $table->index('customer_email');
            $table->index('status');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
