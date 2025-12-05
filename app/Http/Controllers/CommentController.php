<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    /**
     * Store comment untuk Task
     */
    public function storeForTask(Request $request, Task $task)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:5000',
            'attachment' => 'nullable|file|max:5120|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png,gif,zip,rar',
        ]);

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('comments/attachments', 'public');
        }

        // Create comment using polymorphic relationship
        $comment = $task->comments()->create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
            'attachment_path' => $attachmentPath,
        ]);

        return redirect()->back()->with('success', 'Comment posted successfully!');
    }

    /**
     * Store comment untuk Meeting (opsional, kalau mau unified)
     */
    public function storeForMeeting(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:5000',
            'attachment' => 'nullable|file|max:5120|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png,gif,zip,rar',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('comments/attachments', 'public');
        }

        $comment = $meeting->comments()->create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
            'attachment_path' => $attachmentPath,
        ]);

        return redirect()->back()->with('success', 'Comment posted successfully!');
    }

    /**
     * Update comment
     */
    public function update(Request $request, Comment $comment)
    {
        // Check ownership
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $comment->update([
            'body' => $validated['body'],
        ]);

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    /**
     * Delete comment
     */
    public function destroy(Comment $comment)
    {
        // Check ownership
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete attachment file if exists
        if ($comment->attachment_path) {
            Storage::disk('public')->delete($comment->attachment_path);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }

    /**
     * Download comment attachment
     */
    public function download(Comment $comment)
    {
        if (!$comment->attachment_path) {
            abort(404, 'Attachment not found.');
        }

        $filePath = storage_path('app/public/' . $comment->attachment_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        $fileName = basename($comment->attachment_path);

        return response()->download($filePath, $fileName);
    }

    /**
     * View attachment (untuk preview image/pdf)
     */
    public function view(Comment $comment)
    {
        if (!$comment->attachment_path) {
            abort(404, 'Attachment not found.');
        }

        $filePath = storage_path('app/public/' . $comment->attachment_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        $mimeType = mime_content_type($filePath);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
        ]);
    }
}