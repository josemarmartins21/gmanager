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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            // Atributos fundamentais
            $table->decimal('total');
            $table->decimal('total_payed');
            $table->boolean('status');
            $table->text('note')->nullable();

            // FK - Chaves estrangeiras
            $table->foreignId('user_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete()
            ->nullOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
