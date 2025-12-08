<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada atau belum
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email', 255)->nullable()->unique()->after('username');
            }
            
            if (!Schema::hasColumn('users', 'telegram_id')) {
                $table->string('telegram_id', 50)->nullable()->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['email']); // Drop unique index dulu
            $table->dropColumn(['email', 'telegram_id']);
        });
    }
};