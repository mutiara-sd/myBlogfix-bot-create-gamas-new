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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            
            // Polymorphic relationship - bisa untuk Task, Meeting, dll
            $table->string('remindable_type', 100)->comment('Model class: App\Models\Task, App\Models\Meeting');
            $table->unsignedBigInteger('remindable_id')->comment('ID dari task/meeting/dll');
            
            // User yang membuat reminder
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade')
                  ->comment('User yang buat reminder');
            
            // Waktu reminder
            $table->dateTime('remind_at')->comment('Waktu reminder akan dikirim');
            
            // Channel notifikasi (bisa pilih lebih dari 1)
            $table->boolean('notify_telegram')->default(false)->comment('Kirim via Telegram?');
            $table->boolean('notify_email')->default(false)->comment('Kirim via Email?');
            
            // Note/pesan custom (optional)
            $table->text('note')->nullable()->comment('Catatan/pesan custom');
            
            // Status pengiriman
            $table->boolean('is_sent')->default(false)->comment('Sudah terkirim?');
            $table->dateTime('sent_at')->nullable()->comment('Kapan terkirim');
            
            $table->timestamps();
            
            // Indexes untuk performance
            $table->index(['remindable_type', 'remindable_id'], 'remindable_index');
            $table->index(['remind_at', 'is_sent'], 'pending_reminders_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};