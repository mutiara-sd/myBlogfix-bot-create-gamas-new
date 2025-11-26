<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MeetingCommentController extends Controller
{
    public function store(Request $request, Meeting $meeting)
    {
        $request->validate([
            'comment_text' => 'required|string|max:1000',
            'attachment' => 'nullable|file|max:5120|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png,gif,zip,rar', // ← Max 5MB
        ], [
            'attachment.max' => 'File size must not exceed 5MB.',
            'attachment.mimes' => 'File type not supported.',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'comment_text' => $request->comment_text,
        ];

        // Handle file upload jika ada
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('comment_attachments', $fileName, 'public');
            
            $data['attachment_path'] = $filePath;
            $data['attachment_name'] = $file->getClientOriginalName();
            $data['attachment_size'] = $file->getSize();
        }

        $meeting->comments()->create($data);

        return redirect()
            ->route('meetings.show', $meeting)
            ->with('success', 'Comment added successfully!');
    }

    public function destroy(MeetingComment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return redirect()
                ->back()
                ->with('error', 'You can only delete your own comments.');
        }

        $meetingId = $comment->meeting_id;
        
        // File akan otomatis terhapus karena ada boot method di model
        $comment->delete();

        return redirect()
            ->route('meetings.show', $meetingId)
            ->with('success', 'Comment deleted successfully!');
    }

    public function downloadAttachment(MeetingComment $comment)
    {
        if (!$comment->attachment_path || !Storage::disk('public')->exists($comment->attachment_path)) {
            return redirect()
                ->back()
                ->with('error', 'File not found.');
        }

        return Storage::disk('public')->download(
            $comment->attachment_path,
            $comment->attachment_name
        );
    }
}