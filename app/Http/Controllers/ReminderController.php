<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReminderController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Store reminder baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'remindable_type' => 'required|string',
            'remindable_id' => 'required|integer',
            'remind_at' => 'required|date|after:now',
            'notify_telegram' => 'boolean',
            'notify_email' => 'boolean',
            'note' => 'nullable|string|max:500',
        ]);

        // Pastikan minimal salah satu notifikasi dipilih
        if (!$request->notify_telegram && !$request->notify_email) {
            return back()->withErrors(['notification' => 'Please select at least one notification method.']);
        }

        $reminder = Reminder::create([
            'remindable_type' => $validated['remindable_type'],
            'remindable_id' => $validated['remindable_id'],
            'user_id' => auth()->id(),
            'remind_at' => $validated['remind_at'],
            'notify_telegram' => $request->has('notify_telegram'),
            'notify_email' => $request->has('notify_email'),
            'note' => $validated['note'] ?? null,
            'is_sent' => false,
        ]);

        return back()->with('success', 'Reminder created successfully!');
    }

    /**
     * Hapus reminder
     */
    public function destroy(Reminder $reminder)
    {
        // Pastikan user hanya bisa hapus reminder miliknya
        if ($reminder->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $reminder->delete();

        return back()->with('success', 'Reminder deleted successfully!');
    }

    /**
     * Mark reminder as sent manually
     */
    public function markAsSent(Reminder $reminder)
    {
        if ($reminder->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $reminder->update([
            'is_sent' => true,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Reminder marked as sent.');
    }

    /**
     * Kirim pending reminders (bisa dipanggil manual atau via cron)
     */
    public function sendPendingReminders()
    {
        // Ambil semua reminder yang waktunya sudah lewat dan belum terkirim
        $pendingReminders = Reminder::where('is_sent', false)
            ->where('remind_at', '<=', now())
            ->get();

        $sentCount = 0;
        $failedCount = 0;

        foreach ($pendingReminders as $reminder) {
            try {
                // Kirim notifikasi
                $success = $this->notificationService->sendReminder($reminder);

                if ($success) {
                    // Update status reminder
                    $reminder->update([
                        'is_sent' => true,
                        'sent_at' => now(),
                    ]);
                    $sentCount++;
                } else {
                    $failedCount++;
                    Log::warning("Failed to send reminder ID: {$reminder->id}");
                }

            } catch (\Exception $e) {
                $failedCount++;
                Log::error("Error sending reminder ID {$reminder->id}: " . $e->getMessage());
            }
        }

        $message = "Reminders sent: {$sentCount}, Failed: {$failedCount}";
        Log::info($message);

        return response()->json([
            'success' => true,
            'sent' => $sentCount,
            'failed' => $failedCount,
            'message' => $message
        ]);
    }
}