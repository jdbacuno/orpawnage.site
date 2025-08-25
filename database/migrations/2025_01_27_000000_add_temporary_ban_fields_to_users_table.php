<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_temporarily_banned')->default(false);
            $table->text('temporary_ban_reason')->nullable();
            $table->timestamp('temporarily_banned_at')->nullable();
            $table->timestamp('temporary_ban_expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_temporarily_banned',
                'temporary_ban_reason',
                'temporarily_banned_at',
                'temporary_ban_expires_at'
            ]);
        });
    }
};
