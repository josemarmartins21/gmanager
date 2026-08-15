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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Atributos fundamentais
            $table->string('name');
            $table->decimal('price');
            $table->decimal('box_price');
            $table->integer('current_stock')->default(0);
            $table->integer('min_stock')->default(5);

            // FK - Chaves estrangeiras
            $table->foreignId('category_id')
            ->nullable()
            ->constrained()
            ->restrictOnDelete()
            ->restrictOnUpdate();

            $table->foreignId('user_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete()
            ->nullOnUpdate();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
