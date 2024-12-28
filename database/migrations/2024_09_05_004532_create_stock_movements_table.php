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
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out']); // 'in' untuk stok masuk, 'out' untuk stok keluar
            $table->integer('quantity');
            $table->date('date');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
};
