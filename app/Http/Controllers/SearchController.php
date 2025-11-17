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
                    'users' => [],
                    'message' => 'Query too short'
                ]);
            }

            $results = [
                'projects' => [],
                'meetings' => [],
                'users' => [],
                'success' => true
            ];

            // 1. SEARCH PROJECTS - Pakai DB Query langsung
            try {
                $projects = DB::table('projects')
                    ->where('name', 'like', "%{$query}%")
                    ->orWhere('code', 'like', "%{$query}%")
                    ->limit(5)
                    ->get(['id', 'name', 'code', 'status']);
                
                $results['projects'] = $projects->map(function($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                        'code' => $project->code,
                        'status' => $project->status,
                        'url' => url('/projects/' . $project->id)
                    ];
                })->toArray();
                
                Log::info('✅ Projects found', ['count' => count($results['projects'])]);
            } catch (\Exception $e) {
                Log::error('❌ Projects search error: ' . $e->getMessage());
                $results['projects'] = [];
            }

            // 2. SEARCH MEETINGS - Pakai DB Query langsung
            try {
                // Cek dulu apakah tabel meetings ada
                if (DB::getSchemaBuilder()->hasTable('meetings')) {
                    $meetings = DB::table('meetings')
                        ->where('title', 'like', "%{$query}%")
                        ->limit(5)
                        ->get(['id', 'title', 'scheduled_at', 'location']);
                    
                    $results['meetings'] = $meetings->map(function($meeting) {
                        return [
                            'id' => $meeting->id,
                            'title' => $meeting->title,
                            'scheduled_at' => date('d M Y, H:i', strtotime($meeting->scheduled_at)),
                            'location' => $meeting->location ?? '-',
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

            // 3. SEARCH USERS - Pakai DB Query langsung
            try {
                $users = DB::table('users')
                    ->where('name', 'like', "%{$query}%")
                    ->orWhere('username', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->limit(5)
                    ->get(['id', 'name', 'username', 'email', 'profile_picture']);
                
                $results['users'] = $users->map(function($user) {
                    $profilePic = null;
                    if (!empty($user->profile_picture)) {
                        if (filter_var($user->profile_picture, FILTER_VALIDATE_URL)) {
                            $profilePic = $user->profile_picture;
                        } else {
                            $profilePic = asset('storage/' . $user->profile_picture);
                        }
                    }
                    
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username ?? explode('@', $user->email)[0],
                        'email' => $user->email,
                        'profile_picture' => $profilePic,
                        'url' => '#'
                    ];
                })->toArray();
                
                Log::info('✅ Users found', ['count' => count($results['users'])]);
            } catch (\Exception $e) {
                Log::error('❌ Users search error: ' . $e->getMessage());
                $results['users'] = [];
            }

            Log::info('🎉 Search completed successfully');
            
            return response()->json($results);

        } catch (\Exception $e) {
            Log::error('💥 FATAL Search Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'projects' => [],
                'meetings' => [],
                'users' => [],
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
}