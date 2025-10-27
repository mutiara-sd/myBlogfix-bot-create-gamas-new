<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Project;
use App\Models\User;
use App\Models\Agenda;
use App\Models\MinuteDecision;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
    $projects = Project::all();
    $users = User::all();

    // pakai eager load biar relasi tiap meeting beda
    $meetings = Meeting::with([
            'project',
            'organizer',
            'agendas',
            'minuteDecisions'
        ])
        ->when($request->project_id, fn($q, $projectId) => $q->where('project_id', $projectId))
        ->orderBy('scheduled_at', 'desc')
        ->get();

    // optional: force refresh relasi
    $meetings->each->load('agendas', 'minuteDecisions');

    return view('meetings.index', compact('meetings', 'projects', 'users'));
}



    public function store(Request $request)
    {
        $request->validate([
            'project_id'   => 'required|exists:projects,id',
            'title'        => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'location'     => 'nullable|string|max:255',
            'organizer_id' => 'required|exists:users,id',
            'status'       => 'nullable|in:draft,done,cancelled',
        ]);

        Meeting::create([
            'project_id'   => $request->project_id,
            'title'        => $request->title,
            'scheduled_at' => $request->scheduled_at,
            'location'     => $request->location,
            'organizer_id' => $request->organizer_id,
            'status'       => $request->status ?? 'draft',
        ]);

        return redirect()->route('meetings.index')
            ->with('success', 'Meeting berhasil dibuat!');
    }

    public function show(Meeting $meeting)
    {
        // Load relationships untuk detail view
        $meeting->load(['project', 'organizer', 'agendas', 'minuteDecisions']);
        
        return view('meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        $projects = Project::all();
        $users = User::all();
        
        return view('meetings.edit', compact('meeting', 'projects', 'users'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'project_id'   => 'required|exists:projects,id',
            'title'        => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'location'     => 'nullable|string|max:255',
            'organizer_id' => 'required|exists:users,id',
            'status'       => 'in:draft,done,cancelled',
        ]);

        $meeting->update([
            'project_id'   => $request->project_id,
            'title'        => $request->title,
            'scheduled_at' => $request->scheduled_at,
            'location'     => $request->location,
            'organizer_id' => $request->organizer_id,
            'status'       => $request->status,
        ]);

        return redirect()->route('meetings.index')
            ->with('success', 'Meeting berhasil diperbarui!');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return redirect()->route('meetings.index')
            ->with('success', 'Meeting berhasil dihapus!');
    }
}