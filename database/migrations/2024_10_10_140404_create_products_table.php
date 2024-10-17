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
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('category_id')->default(0);
            $table->decimal('sale_price', 8, 2)->default(0); // Sale price with 2 decimal places
            $table->decimal('stock_price', 8, 2)->default(0); // Stock price with 2 decimal places
            $table->string('photo')->nullable();
            
            // Foreign key constraint to `categories` table
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
