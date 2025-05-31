<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surrender_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('transaction_number')->unique();
            $table->string('full_name');
            $table->string('email');
            $table->date('birthdate');
            $table->integer('age');
            $table->string('contact_number');
            $table->string('address');
            $table->string('civil_status');
            $table->string('citizenship');
            $table->string('pet_name')->nullable();
            $table->string('species');
            $table->string('breed')->nullable();
            $table->string('sex');
            $table->text('reason');
            $table->string('valid_id_path');
            $table->json('animal_photos');
            $table->enum('status', ['to be confirmed', 'confirmed', 'to be scheduled', 'surrender on-going', 'picked up', 'rejected', 'archived'])->default('to be confirmed');
            $table->string('previous_status')->nullable();
            $table->text('reject_reason')->nullable();
            $table->date('surrender_date')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surrender_applications');
    }
};
