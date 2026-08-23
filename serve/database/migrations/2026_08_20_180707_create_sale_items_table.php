<?php

use App\Models\Product;
use App\Models\Sale;
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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();

            // Atributos fundamentais
            $table->integer('qty');
            $table->decimal('subtotal');
            $table->string('product_name');
            $table->decimal('product_price');

            // FK - Chaves estrangeiras
            $table->foreignIdFor(Product::class, 'product_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete()
            ->cascadeOnUpdate();
            
            $table->foreignIdFor(Sale::class, 'sale_id')
            ->nullable()
            ->constrained()
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
