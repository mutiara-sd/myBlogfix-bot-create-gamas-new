<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            // Ubah task_id jadi nullable
            $table->unsignedBigInteger('task_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id')->nullable(false)->change();
        });
    }
};