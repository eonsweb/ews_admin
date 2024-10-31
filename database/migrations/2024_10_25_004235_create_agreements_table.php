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
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('transaction_id')->unique();
            $table->decimal('principal', 8, 2)->default(0); 
            $table->decimal('quantity', 8, 2)->default(1);
            $table->decimal('down_payment', 8, 2)->default(0); 
            $table->decimal('total_paid', 8, 2)->default(0); 
            $table->enum('status', ['active', 'completed', 'cancelled']);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration')->default(3);
            $table->timestamps();


            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
