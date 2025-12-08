<?php

namespace App\Console\Commands;

use App\Models\Reminder;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendPendingReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send all pending reminders';

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        $this->info('Checking for pending reminders...');

        $pendingReminders = Reminder::where('is_sent', false)
            ->where('remind_at', '<=', now())
            ->get();

        if ($pendingReminders->isEmpty()) {
            $this->info('No pending reminders found.');
            return 0;
        }

        $this->info("Found {$pendingReminders->count()} pending reminder(s).");

        $sentCount = 0;
        $failedCount = 0;

        foreach ($pendingReminders as $reminder) {
            try {
                $success = $this->notificationService->sendReminder($reminder);

                if ($success) {
                    $reminder->update([
                        'is_sent' => true,
                        'sent_at' => now(),
                    ]);
                    $sentCount++;
                    $this->info("✓ Reminder ID {$reminder->id} sent successfully.");
                } else {
                    $failedCount++;
                    $this->error("✗ Failed to send reminder ID {$reminder->id}");
                }

            } catch (\Exception $e) {
                $failedCount++;
                $this->error("✗ Error sending reminder ID {$reminder->id}: " . $e->getMessage());
                Log::error("Reminder send error: " . $e->getMessage());
            }
        }

        $this->info("\nSummary:");
        $this->info("Sent: {$sentCount}");
        $this->info("Failed: {$failedCount}");

        return 0;
    }
}