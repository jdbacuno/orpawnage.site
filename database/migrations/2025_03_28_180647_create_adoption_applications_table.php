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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('email');
            $table->integer('age');
            $table->date('birthdate');
            $table->string('contact_number');
            $table->text('address');
            $table->string('civil_status');
            $table->string('citizenship');
            $table->text('reason_for_adoption'); // Added for "Why do you want to adopt a pet?"
            $table->enum('visit_veterinarian', ['Yes', 'No', 'Sometimes']); // Added for veterinarian visits
            $table->integer('existing_pets'); // Added for existing pets information
            $table->string('valid_id'); // for storing valid ID file path
            $table->enum('status', ['to be confirmed', 'confirmed', 'to be scheduled', 'adoption on-going', 'picked up', 'rejected', 'archived'])->default('to be confirmed');
            $table->string('previous_status')->nullable();
            $table->string('transaction_number')->unique();
            $table->text('reject_reason')->nullable();
            $table->date('pickup_date')->nullable();
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
