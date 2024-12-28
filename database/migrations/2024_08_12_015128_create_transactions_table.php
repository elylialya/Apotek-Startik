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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('customer_address');
            $table->string('total_amount'); // Total semua produk
            $table->string('amount_paid'); // Jumlah yang dibayarkan
            $table->enum('payment_method', ['cod', 'credit_card', 'bank_transfer', 'e-wallet']); // Metode pembayaran
            $table->boolean('is_returned')->default(false); // Menandai apakah transaksi sudah dikembalikan
            $table->text('return_reason')->nullable(); // Alasan pengembalian
            $table->timestamp('return_date')->nullable(); // Tanggal pengembalian
            $table->string('shipping_option')->nullable(); // Opsi pengiriman
            $table->enum('shipping_status', ['menunggu', 'shipped', 'delivered', 'canceled'])->default('menunggu'); // Status pengiriman
            $table->timestamp('shipping_date')->nullable(); // Tanggal pengiriman
            $table->string('snap_token')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
