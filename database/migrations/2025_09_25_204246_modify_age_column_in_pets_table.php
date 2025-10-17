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
        Schema::table('pets', function (Blueprint $table) {
            // Change age column from integer to decimal with 2 decimal places
            $table->decimal('age', 5, 2)->change(); // 5 digits total, 2 after decimal point
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            // Revert back to integer if needed
            $table->integer('age')->change();
        });
    }
};
