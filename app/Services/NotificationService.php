<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Kirim notifikasi reminder ke user
     */
    public function sendReminder($reminder)
    {
        $user = $reminder->user;
        $remindable = $reminder->remindable; // Task atau Meeting
        
        $success = false;

        // Kirim ke Telegram jika dicentang
        if ($reminder->notify_telegram && $user->telegram_id) {
            $telegramSent = $this->sendTelegramNotification($user, $reminder, $remindable);
            if ($telegramSent) {
                $success = true;
            }
        }

        // Kirim ke Email jika dicentang
        if ($reminder->notify_email && $user->email) {
            $emailSent = $this->sendEmailNotification($user, $reminder, $remindable);
            if ($emailSent) {
                $success = true;
            }
        }

        return $success;
    }

    /**
     * Kirim ke Telegram (mirip kayak OTP kamu)
     */
    private function sendTelegramNotification($user, $reminder, $remindable)
    {
        try {
            $botToken = config('services.telegram.bot_token');
            
            // Format pesan
            $message = $this->formatTelegramMessage($reminder, $remindable);
            
            $telegramUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";
            
            $response = Http::post($telegramUrl, [
                'chat_id' => $user->telegram_id,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);

            if ($response->successful()) {
                Log::info("Telegram reminder sent to user {$user->id}");
                return true;
            }

            Log::error("Failed to send Telegram reminder: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("Telegram notification error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Format pesan untuk Telegram
     */
    private function formatTelegramMessage($reminder, $remindable)
    {
        $type = class_basename(get_class($remindable)); // Task atau Meeting
        $title = $remindable->title ?? $remindable->name;
        
        $message = "🔔 *REMINDER NOTIFICATION*\n\n";
        $message .= "📌 *{$type}:* {$title}\n";
        
        if ($reminder->note) {
            $message .= "📝 *Note:* {$reminder->note}\n";
        }
        
        if (isset($remindable->due_date)) {
            $message .= "⏰ *Due Date:* " . $remindable->due_date->format('d M Y H:i') . "\n";
        }
        
        $message .= "\n_Reminder dikirim pada: " . now()->format('d M Y H:i') . "_";
        
        return $message;
    }

    /**
     * Kirim ke Email
     */
    private function sendEmailNotification($user, $reminder, $remindable)
    {
        try {
            $type = class_basename(get_class($remindable));
            $title = $remindable->title ?? $remindable->name;

            Mail::raw(
                $this->formatEmailMessage($reminder, $remindable),
                function ($message) use ($user, $type, $title) {
                    $message->to($user->email)
                            ->subject("Reminder: {$type} - {$title}");
                }
            );

            Log::info("Email reminder sent to user {$user->id}");
            return true;

        } catch (\Exception $e) {
            Log::error("Email notification error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Format pesan untuk Email
     */
    private function formatEmailMessage($reminder, $remindable)
    {
        $type = class_basename(get_class($remindable));
        $title = $remindable->title ?? $remindable->name;
        
        $message = "REMINDER NOTIFICATION\n\n";
        $message .= "Type: {$type}\n";
        $message .= "Title: {$title}\n\n";
        
        if ($reminder->note) {
            $message .= "Note: {$reminder->note}\n\n";
        }
        
        if (isset($remindable->due_date)) {
            $message .= "Due Date: " . $remindable->due_date->format('d M Y H:i') . "\n";
        }
        
        $message .= "\nReminder sent at: " . now()->format('d M Y H:i');
        
        return $message;
    }
}