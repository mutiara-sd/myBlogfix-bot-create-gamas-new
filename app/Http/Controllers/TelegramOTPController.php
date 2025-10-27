<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TelegramOTPController extends Controller
{
    public function index()
    {
        return view('login.indexOtp', [
            'title' => 'Verify OTP',
        ]);
    }

    public function sendOtp(Request $request)
    {
        $userId = session('pending_user_id');

        if (! $userId) {
            return redirect()->route('signin')->withErrors(['otp' => 'OTPs session is not valid, please login again.']);
        }

        $user = User::find($userId);

        if (! $user || ! $user->telegram_id) {
            return back()->withErrors(['otp' => 'Please connect your telegram first!']);
        }

        $cacheKey = "otp_cooldown_{$user->id}";

        if (Cache::has($cacheKey)) {
            return response()->json([
                'message' => 'Tunggu 5 menit sebelum mengirim ulang OTP.',
                'remaining' => Cache::get($cacheKey) - now()->timestamp,
            ], 429);
        }

        Otp::where('user_id', $user->id)->delete();

        $otpCode = rand(100000, 999999);
        Otp::create([
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(5),
        ]);

        $cooldownTime = now()->addMinutes(5)->timestamp;
        Cache::put($cacheKey, $cooldownTime, 300);

        $botToken = config('services.telegram.bot_token');
        $message = "Kode OTP Anda: *$otpCode*\nBerlaku selama 5 menit.";

        $telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";
        Http::post($telegramUrl, [
            'chat_id' => $user->telegram_id,
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);

        return back()->with('success', 'Code already sent, please check your telegram.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $userId = session('pending_user_id');

        if (! $userId) {
            return redirect()->route('signin')->withErrors(['otp' => 'OTPs session is not valid, please login again.']);
        }

        $user = User::find($userId);

        $otp = Otp::where('user_id', $user->id)
            ->where('otp_code', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (! $otp) {
            return back()->withErrors(['otp' => 'The code is invalid.']);
        }

        $otp->delete();

        Auth::login($user);
        session()->forget('pending_user_id');

        return redirect()->intended('/');
    }
}
