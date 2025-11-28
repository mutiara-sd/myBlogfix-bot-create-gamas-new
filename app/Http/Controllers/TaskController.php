<?php
// app/Http/Controllers/TaskController.php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignee', 'labels']);

        // Filter by project
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filter by assignee
        if ($request->filled('assignee_id')) {
            if ($request->assignee_id === 'me') {
                $query->where('assignee_id', auth()->id());
            } else {
                $query->where('assignee_id', $request->assignee_id);
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by due date
        if ($request->filled('due_date')) {
            switch ($request->due_date) {
                case 'overdue':
                    $query->where('due_date', '<', now())->whereNotIn('status', ['done', 'completed']);
                    break;
                case 'today':
                    $query->whereDate('due_date', today());
                    break;
                case 'week':
                    $query->whereBetween('due_date', [now(), now()->addWeek()]);
                    break;
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $tasks = $query->orderBy('due_date', 'asc')
                       ->orderBy('priority', 'desc')
                       ->paginate(20);

        // KPI Stats
        $stats = [
            'total' => Task::count(),
            'completed' => Task::whereIn('status', ['done', 'completed'])->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'overdue' => Task::where('due_date', '<', now())
                ->whereNotIn('status', ['done', 'completed'])
                ->count(),
            'blocked' => Task::where('status', 'blocked')->count(),
        ];

        $projects = Project::where('status', 'active')->get();
        $users = User::all();

        return view('tasks.index', compact('tasks', 'stats', 'projects', 'users'));
    }

    public function create(Request $request)
    {
        $projects = Project::where('status', 'active')->get();
        $users = User::all();
        $labels = Label::all();
        
        // Pre-select project if coming from project page
        $selectedProjectId = $request->get('project_id');

        return view('tasks.create', compact('projects', 'users', 'labels', 'selectedProjectId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'minute_id' => 'nullable|exists:minutes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assignee_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,med,high,urgent',
            'status' => 'required|in:todo,in_progress,review,done,completed,blocked',
            'due_date' => 'nullable|date',
            'weight' => 'nullable|integer|min:1|max:10',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ]);

        $validated['progress_percent'] = 0;

        $task = Task::create($validated);

        if ($request->filled('labels')) {
            $task->labels()->attach($request->labels);
        }

        // Redirect ke project jika dari project page
        if ($request->has('from_project')) {
            return redirect()->route('projects.show', $task->project_id)
                ->with('success', 'Task berhasil dibuat!');
        }

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task berhasil dibuat!');
    }

    public function show(Task $task)
    {
        $task->load([
            'project', 
            'assignee', 
            'labels', 
            'progressUpdates.creator', 
            'comments.user', 
            'attachments',
            'minute.meeting'
        ]);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::where('status', 'active')->get();
        $users = User::all();
        $labels = Label::all();

        return view('tasks.edit', compact('task', 'projects', 'users', 'labels'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assignee_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,med,high,urgent',
            'status' => 'required|in:todo,in_progress,review,done,completed,blocked',
            'due_date' => 'nullable|date',
            'progress_percent' => 'nullable|integer|min:0|max:100',
            'weight' => 'nullable|integer|min:1|max:10',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ]);

        $task->update($validated);

        if ($request->has('labels')) {
            $task->labels()->sync($request->labels);
        }

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task berhasil diperbarui!');
    }

    public function destroy(Task $task)
    {
        $projectId = $task->project_id;
        $task->delete();

        return redirect()->route('projects.show', $projectId)
            ->with('success', 'Task berhasil dihapus!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,review,done,completed,blocked',
        ]);

        $task->update($validated);

        // Auto update progress based on status
        if ($validated['status'] === 'completed' || $validated['status'] === 'done') {
            $task->update(['progress_percent' => 100]);
        }

        return back()->with('success', 'Task status updated!');
    }
}