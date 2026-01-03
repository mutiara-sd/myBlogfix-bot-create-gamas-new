<x-layout>
    <style>
        :root {
            --telkom-red: #E30613;
            --telkom-red-dark: #C8161D;
            --telkom-red-light: #ffebee;
        }
        
        /* KPI Card Modern Style */
        .kpi-card {
            border-left: 4px solid;
            transition: all 0.3s ease;
        }
        
        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        
        .kpi-card.success {
            border-left-color: #10b981;
        }
        
        .kpi-card.danger {
            border-left-color: var(--telkom-red);
        }
        
        .kpi-card.warning {
            border-left-color: #f59e0b;
        }
        
        .kpi-card.info {
            border-left-color: #3b82f6;
        }
        
        .kpi-value {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
        }
        
        .kpi-label {
            font-size: 0.95rem;
            color: #6b7280;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .kpi-subtitle {
            font-size: 0.875rem;
        }
        
        .kpi-icon {
            font-size: 1.5rem;
            opacity: 0.7;
        }
        
        /* Button Primary Telkom */
        .btn-primary {
            background-color: var(--telkom-red) !important;
            border-color: var(--telkom-red) !important;
        }
        
        .btn-primary:hover {
            background-color: var(--telkom-red-dark) !important;
            border-color: var(--telkom-red-dark) !important;
        }
        
        /* Badge & Progress Bar */
        .badge.bg-primary {
            background-color: var(--telkom-red) !important;
        }
        
        .progress-bar.bg-primary {
            background-color: var(--telkom-red) !important;
        }
        
        /* Table Hover */
        .table-hover tbody tr:hover {
            background-color: rgba(227, 6, 19, 0.05);
        }
        
        /* Focus States */
        .form-select:focus,
        .form-control:focus {
            border-color: var(--telkom-red);
            box-shadow: 0 0 0 0.2rem rgba(227, 6, 19, 0.15);
        }
    </style>

    <!-- PAGE TITLE WITH DYNAMIC GREETING -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1" id="dynamic-greeting">
                        <script>
                            const now = new Date();
                            const hour = now.getHours();
                            const userName = "{{ Auth::user()->name ?? 'User' }}";
                            let greeting = "";
                            
                            if (hour >= 5 && hour < 10) {
                                greeting = "Selamat Pagi";
                            } else if (hour >= 10 && hour < 15) {
                                greeting = "Selamat Siang";
                            } else if (hour >= 15 && hour < 18) {
                                greeting = "Selamat Sore";
                            } else {
                                greeting = "Selamat Malam";
                            }
                            
                            document.write(greeting + ", " + userName + "!");
                        </script>
                    </h4>
                    <p class="text-muted mb-0" id="current-time">
                        <script>
                            const options = {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                            };
                            document.write(new Date().toLocaleDateString('id-ID', options));
                        </script>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERS SECTION -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard') }}" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Project</label>
                                <select class="form-select" name="project_id" id="projectFilter">
                                    <option value="">All Projects</option>
                                    @if(isset($projects) && $projects->count() > 0)
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Assignee</label>
                                <select class="form-select" name="assignee_id" id="assigneeFilter">
                                    <option value="">All Assignees</option>
                                    <option value="me" {{ request('assignee_id') == 'me' ? 'selected' : '' }}>Me</option>
                                    @if(isset($users) && $users->count() > 0)
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('assignee_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select class="form-select" name="status" id="statusFilter">
                                    <option value="">All Status</option>
                                    <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>To Do</option>
                                    <option value="doing" {{ request('status') == 'doing' ? 'selected' : '' }}>In Progress</option>
                                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                                    <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i>Apply Filter
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI CARDS - Modern Minimal Style -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card kpi-card success border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="kpi-label mb-2">On-Time Tasks</p>
                            <h2 class="kpi-value text-success mb-0">{{ $onTimePercentage ?? 0 }}%</h2>
                        </div>
                        <i class="fas fa-check-circle kpi-icon text-success"></i>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $onTimePercentage ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card kpi-card danger border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="kpi-label mb-2">Overdue Tasks</p>
                            <h2 class="kpi-value mb-0" style="color: var(--telkom-red);">{{ $overdueTasks ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-exclamation-circle kpi-icon" style="color: var(--telkom-red);"></i>
                    </div>
                    <small class="text-muted kpi-subtitle">Requires immediate attention</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card kpi-card info border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="kpi-label mb-2">Blocked Tasks</p>
                            <h2 class="kpi-value text-primary mb-0">{{ $blockedTasks ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-ban kpi-icon text-primary"></i>
                    </div>
                    <small class="text-muted">Need resolution</small>
                </div>
            </div>
        </div>
    </div>

    <!-- TASKS TABLE -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="fas fa-tasks me-2" style="color: var(--telkom-red);"></i>
                        <span class="fw-semibold">Tasks</span>
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-1"></i>View All
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if(isset($tasks) && $tasks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="ps-4" style="width: 5%">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </div>
                                        </th>
                                        <th scope="col" class="fw-semibold text-muted px-3 py-3" style="width: 35%">TITLE</th>
                                        <th scope="col" class="fw-semibold text-muted px-3 py-3" style="width: 20%">PROJECT</th>
                                        <th scope="col" class="fw-semibold text-muted px-3 py-3" style="width: 15%">ASSIGNEE</th>
                                        <th scope="col" class="fw-semibold text-muted px-3 py-3" style="width: 12%">DUE</th>
                                        <th scope="col" class="fw-semibold text-muted px-3 py-3" style="width: 8%">STATUS</th>
                                        <th scope="col" class="fw-semibold text-muted px-3 py-3" style="width: 5%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $task->id }}">
                                                </div>
                                            </td>
                                            <td class="px-3 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        @php
                                                            $statusColor = [
                                                                'done' => 'success',
                                                                'completed' => 'success',
                                                                'doing' => 'warning',
                                                                'review' => 'info',
                                                                'blocked' => 'danger',
                                                                'todo' => 'secondary'
                                                            ];
                                                            $color = $statusColor[$task->status] ?? 'secondary';
                                                        @endphp
                                                        <i class="fas fa-circle text-{{ $color }}" style="font-size: 8px;"></i>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none">
                                                            <h6 class="mb-1 fw-semibold text-dark">{{ $task->title }}</h6>
                                                        </a>
                                                        @if($task->description)
                                                            <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3">
                                                @if($task->project)
                                                    <a href="{{ route('projects.show', $task->project) }}" class="text-decoration-none">
                                                        <span class="badge px-3 py-2 rounded-pill" style="background-color: rgba(227, 6, 19, 0.1); color: var(--telkom-red); font-weight: 500;">
                                                            {{ $task->project->name }}
                                                        </span>
                                                    </a>
                                                @else
                                                    <span class="text-muted small">No Project</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3">
                                                @if($task->assignee)
                                                    <div class="d-flex align-items-center">
                                                        @if($task->assignee->profile_picture)
                                                            <img src="{{ filter_var($task->assignee->profile_picture, FILTER_VALIDATE_URL)
                                                                    ? $task->assignee->profile_picture
                                                                    : asset('storage/' . $task->assignee->profile_picture) }}"
                                                                alt="{{ $task->assignee->name }}"
                                                                class="rounded-circle me-2"
                                                                style="width: 32px; height: 32px; object-fit: cover;">
                                                        @else
                                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                                 style="width: 32px; height: 32px; background: rgba(227, 6, 19, 0.1);">
                                                                <span class="fw-bold small" style="color: var(--telkom-red);">{{ strtoupper(substr($task->assignee->name, 0, 2)) }}</span>
                                                            </div>
                                                        @endif
                                                        <span class="fw-medium small">{{ $task->assignee->name }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Unassigned</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3">
                                                @if($task->due_date)
                                                    @php
                                                        $isOverdue = $task->due_date->isPast() && !in_array($task->status, ['completed', 'done']);
                                                        $dueClass = $isOverdue ? 'fw-semibold' : ($task->due_date->isToday() ? 'text-warning fw-semibold' : 'text-muted');
                                                        $dueStyle = $isOverdue ? 'color: var(--telkom-red);' : '';
                                                    @endphp
                                                    <span class="{{ $dueClass }} small" style="{{ $dueStyle }}">
                                                        {{ $task->due_date->format('M d, Y') }}
                                                        @if($isOverdue)
                                                            <i class="fas fa-exclamation-circle ms-1"></i>
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3">
                                                @php
                                                    $statusColors = [
                                                        'todo' => 'secondary',
                                                        'doing' => 'warning',
                                                        'review' => 'info',
                                                        'completed' => 'success',
                                                        'done' => 'success',
                                                        'blocked' => 'danger'
                                                    ];
                                                    $statusBg = $statusColors[$task->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $statusBg }} px-3 py-1 rounded-pill" style="font-weight: 500;">
                                                    {{ ucfirst($task->status) }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 50px; height: 6px; background-color: rgba(227, 6, 19, 0.1);">
                                                        <div class="progress-bar" role="progressbar" style="width: {{ $task->progress_percent ?? 0 }}%; background-color: var(--telkom-red);"></div>
                                                    </div>
                                                    <small class="text-muted fw-medium">{{ $task->progress_percent ?? 0 }}%</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center p-4 border-top">
                            <div>
                                <small class="text-muted">
                                    Showing <span class="fw-semibold">{{ $tasks->firstItem() ?? 0 }}</span> to 
                                    <span class="fw-semibold">{{ $tasks->lastItem() ?? 0 }}</span> of 
                                    <span class="fw-semibold">{{ $tasks->total() ?? 0 }}</span> entries
                                </small>
                            </div>
                            <nav>
                                {{ $tasks->appends(request()->query())->links() }}
                            </nav>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No tasks found</h5>
                            <p class="text-muted">Try adjusting your filters or create a new task</p>
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>Create New Task
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    // Auto-refresh time every minute
    function updateTime() {
        const now = new Date();
        const hour = now.getHours();
        const userName = "{{ Auth::user()->name ?? 'User' }}";
        let greeting = "";
        
        if (hour >= 5 && hour < 10) {
            greeting = "Selamat Pagi";
        } else if (hour >= 10 && hour < 15) {
            greeting = "Selamat Siang"; 
        } else if (hour >= 15 && hour < 18) {
            greeting = "Selamat Sore";
        } else {
            greeting = "Selamat Malam";
        }
        
        document.getElementById('dynamic-greeting').innerHTML = greeting + ", " + userName + "!";
        
        const options = {
            weekday: 'long',
            year: 'numeric', 
            month: 'long',
            day: 'numeric',
        };
        document.getElementById('current-time').innerHTML = now.toLocaleDateString('id-ID', options);
    }
    
    setInterval(updateTime, 60000);
    
    // Select all checkbox functionality
    document.getElementById('selectAll')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>