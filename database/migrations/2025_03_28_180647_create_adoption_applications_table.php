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
        Schema::create('adoption_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User applying
            $table->foreignId('pet_id')->constrained()->onDelete('cascade'); // Pet being adopted
            $table->string('full_name');
            $table->string('email');
            $table->integer('age');
            $table->date('birthdate');
            $table->string('contact_number');
            $table->text('address');
            $table->string('civil_status');
            $table->string('citizenship');
            $table->enum('status', ['to be scheduled', 'to be picked up', 'picked up', 'rejected'])->default('to be scheduled');
            $table->string('transaction_number')->unique(); // ← Add this line
            $table->text('reject_reason')->nullable();
            $table->date('pickup_date')->nullable(); // Allows NULL for "Not set"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_applications');
    }
};
