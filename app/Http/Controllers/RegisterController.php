<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function RegisterForm()
    {
        $roles = Role::all();
        $roles = Role::where('slug', '!=', 'admin')->get();

        return view('register.index', compact('roles'), [
            'title' => 'Sign Up',
        ]);
    }

    public function DataRegister(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'telegram_id' => 'required|unique:users',
            'telegram_username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'password' => 'required|min:8|max:255',
            'role_id' => 'required',
        ]);

        $user = User::create($validatedData);

        if ($user) {
            $this->sendTelegramNotification($user);
        }

        return redirect('/signin')->with('success', 'Registration successful! Please wait for admin approval.');
    }

    private function sendTelegramNotification($user)
    {
        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');
        $roleName = optional($user->role)->name ?? 'Unknown Role';

        $message = "🔔 *New User Registered!* 🔔\n\n"
            ."Name: *{$user->name}*\n"
            ."Telegram ID: *{$user->telegram_id}*\n"
            ."Telegram Username: *@{$user->telegram_username}*\n"
            ."Role: *{$roleName}*\n"
            .'Registered at: '.now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i');

        try {
            Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send Telegram notification: '.$e->getMessage());
        }
    }
}
