<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add new column
        Schema::table('missing_pet_reports', function (Blueprint $table) {
            $table->timestamp('last_reposted_at')->nullable()->after('reject_reason');
        });

        // Step 2: Update existing 'acknowledged' status to 'approved'
        DB::table('missing_pet_reports')
            ->where('status', 'acknowledged')
            ->update(['status' => 'approved']);

        // Step 3: Modify the status column to use new enum values
        // Note: For MySQL, we need to use raw SQL to modify enum
        DB::statement("ALTER TABLE missing_pet_reports MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'found', 'archived') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert status changes
        DB::table('missing_pet_reports')
            ->where('status', 'approved')
            ->update(['status' => 'acknowledged']);

        // Revert enum back to original
        DB::statement("ALTER TABLE missing_pet_reports MODIFY COLUMN status ENUM('pending', 'acknowledged', 'rejected', 'archived') NOT NULL DEFAULT 'pending'");

        // Remove the new column
        Schema::table('missing_pet_reports', function (Blueprint $table) {
            $table->dropColumn('last_reposted_at');
        });
    }
};
