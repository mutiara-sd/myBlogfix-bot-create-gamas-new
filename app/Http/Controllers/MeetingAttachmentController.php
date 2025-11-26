<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MeetingAttachmentController extends Controller
{
    public function store(Request $request, Meeting $meeting)
    {
        $request->validate([
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png,gif,zip,rar',
        ], [
            'file.required' => 'Please select a file to upload.',
            'file.max' => 'File size must not exceed 10MB.',
            'file.mimes' => 'File type not supported. Allowed types: PDF, Word, Excel, PowerPoint, Images, ZIP.',
        ]);

        $file = $request->file('file');
        
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('meeting_attachments', $fileName, 'public');

        $attachment = $meeting->attachments()->create([
            'uploaded_by' => Auth::id(),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()
            ->route('meetings.show', $meeting)
            ->with('success', 'File uploaded successfully!');
    }

    public function download(MeetingAttachment $attachment)
    {
        if (!Storage::disk('public')->exists($attachment->file_path)) {
            return redirect()
                ->back()
                ->with('error', 'File not found.');
        }

        return Storage::disk('public')->download(
            $attachment->file_path,
            $attachment->file_name
        );
    }

    public function destroy(MeetingAttachment $attachment)
    {
        $meetingId = $attachment->meeting_id;
        
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $attachment->delete();

        return redirect()
            ->route('meetings.show', $meetingId)
            ->with('success', 'File deleted successfully!');
    }
}