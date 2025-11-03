<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisement_impressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertisement_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Tracking
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('page_url')->nullable();

            // Géolocalisation (estimée)
            $table->string('country')->nullable();
            $table->string('city')->nullable();

            // Device
            $table->string('device_type')->nullable(); // mobile, desktop, tablet
            $table->string('browser')->nullable();
            $table->string('os')->nullable();

            $table->timestamp('viewed_at');

            $table->index(['advertisement_id', 'viewed_at']);
            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisement_impressions');
    }
};
