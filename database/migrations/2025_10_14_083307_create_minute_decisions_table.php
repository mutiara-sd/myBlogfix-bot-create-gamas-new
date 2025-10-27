<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('minute_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('minute_id')->constrained('minutes')->onDelete('cascade');
            $table->text('decision_text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('minute_decisions');
    }
};
