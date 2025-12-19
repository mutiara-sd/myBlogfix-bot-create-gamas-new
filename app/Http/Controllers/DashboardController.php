<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Query tasks
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
        
        $tasks = $query->orderBy('due_date', 'asc')
                       ->orderBy('priority', 'desc')
                       ->paginate(10);
        
        // Ambil projects dan users
        $projects = Project::where('status', 'active')->get();
        $users = User::all();
        
        // ✅ KPI Stats - DIPERBAIKI tanpa kolom completed_at
        $completedTasks = Task::whereIn('status', ['done', 'completed'])->count();
        
        if ($completedTasks > 0) {
            // ✅ Hitung on-time berdasarkan updated_at (waktu terakhir task diupdate)
            $completedOnTime = Task::whereIn('status', ['done', 'completed'])
                ->whereNotNull('due_date')
                ->whereRaw('updated_at <= due_date')
                ->count();
            $onTimePercentage = round(($completedOnTime / $completedTasks) * 100);
        } else {
            $onTimePercentage = 0;
        }
        
        $overdueTasks = Task::where('due_date', '<', Carbon::now())
            ->whereNotIn('status', ['done', 'completed'])
            ->count();
        
        $inReviewTasks = Task::where('status', 'review')->count();
        $blockedTasks = Task::where('status', 'blocked')->count();
        
        return view('dashboard', compact(
            'tasks',
            'projects',
            'users',
            'onTimePercentage',
            'overdueTasks',
            'inReviewTasks',
            'blockedTasks'
        ));
    }
}