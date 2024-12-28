<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id'); // ID pemasok
            $table->decimal('total_amount', 15, 2); // Total pembayaran
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending'); // Status
            $table->date('order_date'); // Tanggal pesanan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
    /**
     * Reverse the migrations.
     */
};
