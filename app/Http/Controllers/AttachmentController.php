<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Store attachment for Task
     */
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Store file
            $filepath = $file->store('attachments/tasks', 'public');
            
            // Create attachment record
            $task->attachments()->create([
                'user_id' => auth()->id(),
                'name' => $file->getClientOriginalName(),
                'path' => $filepath,
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            return redirect()->back()->with('success', 'File uploaded successfully!');
        }

        return redirect()->back()->with('error', 'No file uploaded.');
    }

    /**
     * Download attachment
     */
    public function download(Attachment $attachment)
    {
        $filePath = storage_path('app/public/' . $attachment->path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $attachment->name);
    }

    /**
     * Delete attachment
     */
    public function destroy(Attachment $attachment)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($attachment->path)) {
            Storage::disk('public')->delete($attachment->path);
        }

        // Delete record
        $attachment->delete();

        return redirect()->back()->with('success', 'Attachment deleted successfully!');
    }
}