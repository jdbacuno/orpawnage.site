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
        Schema::create('archived_adoption_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_id')->nullable(); // for traceability
            $table->unsignedBigInteger('pet_id');
            $table->string('full_name');
            $table->string('email');
            $table->integer('age');
            $table->date('birthdate');
            $table->string('contact_number');
            $table->string('address');
            $table->string('civil_status');
            $table->string('citizenship');
            $table->string('transaction_number');
            $table->timestamp('adopted_at')->nullable();
            $table->timestamps();

            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_adoption_applications');
    }
};
