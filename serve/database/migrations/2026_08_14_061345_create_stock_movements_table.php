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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            // Atributos fundamentais
            $table->integer('box_qty')->nullable()->default(0);
            $table->integer('units_per_box')->nullable()->default(0);
            $table->integer('total_units');
            $table->text('note');
            $table->enum('type', ['IN', 'lose', 'adjustment']);

            $table->string('product_name');
            $table->decimal('box_price')->nullable();

            // FK - Chaves estrangeiras
            $table->foreignId('product_id')
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
        Schema::dropIfExists('stock_movements');
    }
};
