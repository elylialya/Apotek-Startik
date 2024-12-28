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
        Schema::create('return', function (Blueprint $table) {
            $table->boolean('is_returned')->default(false);
            $table->text('return_reason')->nullable();
            $table->timestamp('return_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('return', function (Blueprint $table) {
            $table->dropColumn(['is_returned', 'return_reason', 'return_date']);
        });
    }
};
