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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('shopping_carts')->onDelete('cascade'); // CartID
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // ProductID
            $table->integer('quantity'); // Quantity
            $table->decimal('unit_price', 10, 2); // UnitPrice
            $table->decimal('total_price', 10, 2); // TotalPrice
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
