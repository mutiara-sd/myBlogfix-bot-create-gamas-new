<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->input('q', '');
            
            Log::info('🔍 Search started', ['query' => $query]);
            
            // Minimal 2 karakter
            if (strlen($query) < 2) {
                return response()->json([
                    'projects' => [],
                    'meetings' => [],
                    'tasks' => [],
                    'message' => 'Query too short'
                ]);
            }

            $results = [
                'projects' => [],
                'meetings' => [],
                'tasks' => [],
                'success' => true
            ];

            // 1. SEARCH PROJECTS - Pakai DB Query langsung
            try {
                $projects = DB::table('projects')
                    ->where('name', 'like', "%{$query}%")
                    ->orWhere('code', 'like', "%{$query}%")
                    ->limit(5)
                    ->get(['id', 'name', 'code', 'status', 'description']);
                
                $results['projects'] = $projects->map(function($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                        'code' => $project->code,
                        'status' => $project->status,
                        'description' => $project->description ?? 'No description',
                        'url' => url('/projects/' . $project->id)
                    ];
                })->toArray();
                
                Log::info('✅ Projects found', ['count' => count($results['projects'])]);
            } catch (\Exception $e) {
                Log::error('❌ Projects search error: ' . $e->getMessage());
                $results['projects'] = [];
            }

            // 2. SEARCH MEETINGS 
            try {
                // Cek dulu apakah tabel meetings ada
                if (DB::getSchemaBuilder()->hasTable('meetings')) {
                    $meetings = DB::table('meetings')
                        ->leftJoin('projects', 'meetings.project_id', '=', 'projects.id')
                        ->where('meetings.title', 'like', "%{$query}%")
                        ->limit(5)
                        ->get([
                            'meetings.id',
                            'meetings.title',
                            'meetings.scheduled_at',
                            'meetings.location',
                            'projects.name as project_name'
                        ]);
                    
                    $results['meetings'] = $meetings->map(function($meeting) {
                        return [
                            'id' => $meeting->id,
                            'title' => $meeting->title,
                            'scheduled_at' => date('d M Y, H:i', strtotime($meeting->scheduled_at)),
                            'location' => $meeting->location ?? '-',
                            'project_name' => $meeting->project_name ?? 'No Project',
                            'url' => url('/meetings/' . $meeting->id)
                        ];
                    })->toArray();
                    
                    Log::info('✅ Meetings found', ['count' => count($results['meetings'])]);
                } else {
                    Log::warning('⚠️ Meetings table not found');
                }
            } catch (\Exception $e) {
                Log::error('❌ Meetings search error: ' . $e->getMessage());
                $results['meetings'] = [];
            }

            // 3. SEARCH TASKS 
            try {
                if (DB::getSchemaBuilder()->hasTable('tasks')) {
                    $tasks = DB::table('tasks')
                        ->leftJoin('projects', 'tasks.project_id', '=', 'projects.id')
                        ->leftJoin('users', 'tasks.assignee_id', '=', 'users.id')
                        ->where('tasks.title', 'like', "%{$query}%")
                        ->orWhere('tasks.description', 'like', "%{$query}%")
                        ->limit(5)
                        ->get([
                            'tasks.id',
                            'tasks.title',
                            'tasks.status',
                            'tasks.priority',
                            'tasks.due_date',
                            'tasks.description',
                            'tasks.progress_percent',
                            'projects.name as project_name',
                            'users.name as assignee_name'
                        ]);
                    
                    $results['tasks'] = $tasks->map(function($task) {
                        return [
                            'id' => $task->id,
                            'title' => $task->title,
                            'status' => $task->status,
                            'priority' => $task->priority,
                            'project_name' => $task->project_name ?? 'No Project',
                            'assignee_name' => $task->assignee_name ?? 'Unassigned',
                            'due_date' => $task->due_date ? date('M d, Y', strtotime($task->due_date)) : 'No due date',
                            'description' => $task->description ?? 'No description',
                            'progress_percent' => $task->progress_percent ?? 0,
                            'url' => url('/tasks/' . $task->id)
                        ];
                    })->toArray();
                    
                    Log::info('✅ Tasks found', ['count' => count($results['tasks'])]);
                } else {
                    Log::warning('⚠️ Tasks table not found');
                }
            } catch (\Exception $e) {
                Log::error('❌ Tasks search error: ' . $e->getMessage());
                $results['tasks'] = [];
            }

            Log::info('🎉 Search completed successfully');
            
            return response()->json($results);

        } catch (\Exception $e) {
            Log::error('💥 FATAL Search Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'projects' => [],
                'meetings' => [],
                'tasks' => [],
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
}