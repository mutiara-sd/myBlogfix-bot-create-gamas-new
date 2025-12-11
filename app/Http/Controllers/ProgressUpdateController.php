<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ProgressUpdate;
use Illuminate\Http\Request;

class ProgressUpdateController extends Controller
{
    public function store(Request $request, Task $task)
    {
    $validated = $request->validate([
        'percent' => [
            'required',
            'integer',
            'min:' . $task->progress_percent,
            'max:100'
        ],
        'note' => 'nullable|string|max:1000',
        'is_blocked' => 'nullable|boolean',
    ], [
        'percent.min' => "Progress cannot decrease. Current progress is {$task->progress_percent}%.",
    ]);

    $currentProgress = $task->progress_percent;
    $targetProgress = $validated['percent'];
    
    // Hitung increment (selisih)
    $increment = $targetProgress - $currentProgress;
    
    if ($increment == 0) {
        return redirect()
            ->back()
            ->with('info', "Progress is already at {$currentProgress}%.");
    }

    // ✅ Simpan sebagai INCREMENT
    $task->progressUpdates()->create([
        'created_by' => auth()->id(),
        'percent' => $increment,  // Simpan selisihnya!
        'note' => $validated['note'] ?? null,
        'is_blocked' => $request->has('is_blocked'),
    ]);

    return redirect()
        ->route('tasks.show', $task)
        ->with('success', "Progress updated to {$targetProgress}%!");
    }

    public function destroy(ProgressUpdate $progressUpdate)
    {
        $task = $progressUpdate->task;
        $progressUpdate->delete();
        
        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Progress update deleted!');
    }
}