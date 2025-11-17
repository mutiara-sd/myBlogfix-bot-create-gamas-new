<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of meetings
     */
    public function index(Request $request)
    {
        $projects = Project::all();
        $users = User::all();

        // Query dengan eager loading
        $query = Meeting::with([
            'project',
            'organizer',
            'agendas',
            'minuteDecisions',
            'risks'
        ]);

        // Filter by project
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $meetings = $query->withCount(['agendas', 'minuteDecisions', 'risks'])
                         ->orderBy('scheduled_at', 'desc')
                         ->paginate(12);

        return view('meetings.index', compact('meetings', 'projects', 'users'));
    }

    /**
     * Show the form for creating a new meeting
     */
    public function create()
    {
        $projects = Project::where('status', 'active')->orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('meetings.create', compact('projects', 'users'));
    }

    /**
     * Store a newly created meeting
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'location' => 'nullable|string|max:255',
            'organizer_id' => 'required|exists:users,id',
            'status' => 'required|in:draft,done,cancelled',
        ]);

        $meeting = Meeting::create($validated);

        return redirect()->route('meetings.show', $meeting)
                        ->with('success', 'Meeting created successfully!');
    }

    /**
     * Display the specified meeting
     */
    public function show(Meeting $meeting)
    {
        $meeting->load([
            'project',
            'organizer',
            'agendas',
            'minuteDecisions',
            'risks'
        ]);

        return view('meetings.show', compact('meeting'));
    }

    /**
     * Show the form for editing the specified meeting
     */
    public function edit(Meeting $meeting)
    {
        $projects = Project::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('meetings.edit', compact('meeting', 'projects', 'users'));
    }

    /**
     * Update the specified meeting
     */
    public function update(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'location' => 'nullable|string|max:255',
            'organizer_id' => 'required|exists:users,id',
            'status' => 'required|in:draft,done,cancelled',
        ]);

        $meeting->update($validated);

        return redirect()->route('meetings.show', $meeting)
                        ->with('success', 'Meeting updated successfully!');
    }

    /**
     * Remove the specified meeting
     */
    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return redirect()->route('meetings.index')
                        ->with('success', 'Meeting deleted successfully!');
    }
}