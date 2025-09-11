<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Map any legacy values before changing the enum definition
        DB::statement("UPDATE `surrender_applications` SET `status` = 'completed' WHERE `status` = 'picked up'");

        // Update enum to include 'completed' and remove 'picked up'
        DB::statement(
            "ALTER TABLE `surrender_applications` MODIFY `status` ENUM('to be confirmed','confirmed','to be scheduled','surrender on-going','completed','rejected','archived') NOT NULL DEFAULT 'to be confirmed'"
        );
    }

    public function down()
    {
        // Revert any 'completed' back to 'picked up' before restoring enum
        DB::statement("UPDATE `surrender_applications` SET `status` = 'picked up' WHERE `status` = 'completed'");

        // Restore original enum including 'picked up' and without 'completed'
        DB::statement(
            "ALTER TABLE `surrender_applications` MODIFY `status` ENUM('to be confirmed','confirmed','to be scheduled','surrender on-going','picked up','rejected','archived') NOT NULL DEFAULT 'to be confirmed'"
        );
    }
};


