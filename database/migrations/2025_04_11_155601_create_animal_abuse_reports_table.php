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
        Schema::create('animal_abuse_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique(); // ← Add this line
            $table->string('full_name')->nullable();
            $table->string('contact_no');
            $table->string('incident_location');
            $table->date('incident_date');
            $table->string('species');
            $table->string('animal_condition');
            $table->text('additional_notes');
            $table->string('valid_id_path')->nullable();
            $table->json('incident_photos')->nullable();
            $table->string('status')->default('pending');
            $table->string('reject_reason')->default('');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_abuse_reports');
    }
};
