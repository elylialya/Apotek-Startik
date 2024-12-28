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
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable(); // Menambahkan kolom deskripsi
            $table->string('dosage')->nullable();    // Menambahkan kolom dosis
        });
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('description'); // Menghapus kolom deskripsi
            $table->dropColumn('dosage');      // Menghapus kolom dosis
        });
    }
};
