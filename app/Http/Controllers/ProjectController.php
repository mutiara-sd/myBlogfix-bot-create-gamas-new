<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Project::with('owner')
            ->withCount('tasks') // ✅ Tambahan ini buat tasks_count
            ->where('owner_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->paginate(10);

        if ($request->expectsJson()) {
            return response()->json($projects);
        }

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'code' => 'nullable|string|max:10|unique:projects,code',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Generate code if not provided
        $code = $request->code ?: Project::generateUniqueCode($request->name);

        $project = Project::create([
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description,
            'owner_id' => Auth::id(),
            'status' => 'active'
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project created successfully',
                'project' => $project->load('owner')
            ], 201);
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View|JsonResponse
    {
        // Check if user owns the project
        if ($project->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this project');
        }

        $project->load(['owner', 'meetings' => function ($query) {
            $query->latest()->take(5);
        }, 'tasks' => function ($query) {
            $query->latest()->take(10);
        }]);

        if (request()->expectsJson()) {
            return response()->json($project);
        }

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        // Check if user owns the project
        if ($project->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this project');
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project): JsonResponse|RedirectResponse
    {
        // Check if user owns the project
        if ($project->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this project');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'code' => 'required|string|max:10|unique:projects,code,' . $project->id,
            'status' => 'in:active,archived'
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $project->update($request->only(['name', 'code', 'description', 'status']));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully',
                'project' => $project->load('owner')
            ]);
        }

        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): JsonResponse|RedirectResponse
    {
        // Check if user owns the project
        if ($project->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this project');
        }

        $project->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully'
            ]);
        }

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
    }

    /**
     * Archive the specified project.
     */
    public function archive(Project $project): JsonResponse|RedirectResponse
    {
        // Check if user owns the project
        if ($project->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this project');
        }

        $project->archive();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project archived successfully',
                'project' => $project
            ]);
        }

        return back()->with('success', 'Project archived successfully');
    }

    /**
     * Activate the specified project.
     */
    public function activate(Project $project): JsonResponse|RedirectResponse
    {
        // Check if user owns the project
        if ($project->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this project');
        }

        $project->activate();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project activated successfully',
                'project' => $project
            ]);
        }

        return back()->with('success', 'Project activated successfully');
    }

    /**
     * ✅ Toggle archive status - Method baru untuk blade temanmu
     */
    public function toggleArchive(Project $project): JsonResponse|RedirectResponse
    {
        // Check if user owns the project
        if ($project->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this project');
        }

        // Toggle status
        if ($project->status === 'active') {
            $project->archive();
            $message = 'Project archived successfully';
        } else {
            $project->activate();
            $message = 'Project activated successfully';
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'project' => $project
            ]);
        }

        return back()->with('success', $message);
    }
}