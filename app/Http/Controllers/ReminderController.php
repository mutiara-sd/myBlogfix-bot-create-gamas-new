<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function store(Request $request, $task)
    {
        // TODO: implement later
        return back()->with('info', 'Reminder feature coming soon');
    }

    public function destroy($reminder)
    {
        // TODO: implement later
        return back()->with('info', 'Reminder feature coming soon');
    }
}