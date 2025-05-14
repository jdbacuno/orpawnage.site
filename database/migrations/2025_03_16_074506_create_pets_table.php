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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->integer('pet_number');
            $table->string('pet_name');
            $table->enum('species', ['feline', 'canine']);
            $table->integer('age');
            $table->enum('age_unit', ['months', 'years', 'weeks']);
            $table->enum('sex', ['male', 'female']);
            $table->enum('reproductive_status', ['intact', 'neutered', 'unknown'])->default('unknown');
            $table->string('color');
            $table->enum('source', ['surrendered', 'rescued', 'other'])->default('other');
            $table->string('image_path');
            $table->string('archive_reason')->nullable();
            $table->text('archive_notes')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
