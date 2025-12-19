<x-layout>
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
                                    <option value="review" {{ request('status') == 'review' ? 'selected' : '' }}>In Review</option>
                                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                                    <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i>Apply Filter
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI CARDS -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium">On-time</p>
                            <h2 class="mb-0 text-success fw-bold">{{ $onTimePercentage ?? 0 }}%</h2>
                        </div>
                        <div class="avatar-lg bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-clock text-success fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium">Overdue</p>
                            <h2 class="mb-0 text-danger fw-bold">{{ $overdueTasks ?? 0 }}</h2>
                        </div>
                        <div class="avatar-lg bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-exclamation-triangle text-danger fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium">In Review</p>
                            <h2 class="mb-0 text-warning fw-bold">{{ $inReviewTasks ?? 0 }}</h2>
                        </div>
                        <div class="avatar-lg bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-eye text-warning fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium">Blocked</p>
                            <h2 class="mb-0 text-secondary fw-bold">{{ $blockedTasks ?? 0 }}</h2>
                        </div>
                        <div class="avatar-lg bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-ban text-secondary fs-2"></i>
                        </div>
                    </div>
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
                        <i class="fas fa-tasks text-primary me-2"></i>
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
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="ps-4" style="width: 5%">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </div>
                                        </th>
                                        <th scope="col" class="fw-semibold text-muted" style="width: 35%">TITLE</th>
                                        <th scope="col" class="fw-semibold text-muted" style="width: 20%">PROJECT</th>
                                        <th scope="col" class="fw-semibold text-muted" style="width: 15%">ASSIGNEE</th>
                                        <th scope="col" class="fw-semibold text-muted" style="width: 12%">DUE</th>
                                        <th scope="col" class="fw-semibold text-muted" style="width: 8%">STATUS</th>
                                        <th scope="col" class="fw-semibold text-muted" style="width: 5%">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $task->id }}">
                                                </div>
                                            </td>
                                            <td>
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
                                            <td>
                                                @if($task->project)
                                                    <a href="{{ route('projects.show', $task->project) }}" class="text-decoration-none">
                                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                                            {{ $task->project->name }}
                                                        </span>
                                                    </a>
                                                @else
                                                    <span class="text-muted small">No Project</span>
                                                @endif
                                            </td>
                                            <td>
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
                                                            <div class="avatar-sm bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                                <span class="text-success fw-bold small">{{ strtoupper(substr($task->assignee->name, 0, 2)) }}</span>
                                                            </div>
                                                        @endif
                                                        <span class="fw-medium">{{ $task->assignee->name }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Unassigned</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->due_date)
                                                    @php
                                                        $isOverdue = $task->due_date->isPast() && !in_array($task->status, ['completed', 'done']);
                                                        $dueClass = $isOverdue ? 'text-danger' : ($task->due_date->isToday() ? 'text-warning' : 'text-muted');
                                                    @endphp
                                                    <span class="{{ $dueClass }} fw-medium">
                                                        {{ $task->due_date->format('M d, Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} px-3 py-1 rounded-pill">
                                                    {{ ucfirst($task->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 50px; height: 6px;">
                                                        <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $task->progress_percent ?? 0 }}%"></div>
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