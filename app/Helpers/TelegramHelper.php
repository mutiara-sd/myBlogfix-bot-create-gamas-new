<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TelegramHelper
{
    public static function sendMessage($message)
    {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }
}
