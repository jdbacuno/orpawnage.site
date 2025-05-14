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
        Schema::create('missing_pet_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->string('owner_name');
            $table->string('contact_no');
            $table->string('pet_name');
            $table->string('last_seen_location');
            $table->date('last_seen_date');
            $table->text('pet_description');
            $table->string('valid_id_path');
            $table->json('pet_photos');
            $table->json('location_photos')->nullable();
            $table->string('status')->default('pending');
            $table->string('reject_reason')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missing_pet_reports');
    }
};
