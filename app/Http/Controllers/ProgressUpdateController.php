<?php

namespace App\Http\Controllers;

use App\Models\ProgressUpdate;
use App\Models\Task;
use Illuminate\Http\Request;

class ProgressUpdateController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'update' => 'required|string',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
        ]);

        $task->progressUpdates()->create([
            'user_id' => auth()->id(),
            'update' => $validated['update'],
            'progress_percentage' => $validated['progress_percentage'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Progress update added successfully!');
    }

    public function destroy(ProgressUpdate $progressUpdate)
    {
        $progressUpdate->delete();

        return redirect()->back()->with('success', 'Progress update deleted successfully!');
    }
}