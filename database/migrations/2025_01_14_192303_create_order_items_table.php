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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');  // معرّف الطلب المرتبط
            $table->unsignedBigInteger('product_id');  // معرّف المنتج المرتبط
            $table->string('product_name');  // اسم المنتج
            $table->decimal('price', 10, 2);  // سعر المنتج عند وقت الطلب
            $table->integer('quantity');  // الكمية المشتراة من المنتج
             // علاقات المفاتيح الأجنبية
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product_categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
