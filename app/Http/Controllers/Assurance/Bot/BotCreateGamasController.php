<?php

namespace App\Http\Controllers\Assurance\Bot;

use App\Http\Controllers\Controller;
use App\Models\Assurance\Bot\BotCreateGamas;

class BotCreateGamasController extends Controller
{
    public function botCreateGamas()
    {
        $homeData = BotCreateGamas::homeQuery();
        $inboxData = BotCreateGamas::inbox(auth()->user());
        $allData = BotCreateGamas::allList();

        return view('assurance.bot.bot-create-gamas', [
            'title' => 'Bot Create Gamas',
            compact('homeData', 'inboxData', 'allData'),
        ]);
    }
}
