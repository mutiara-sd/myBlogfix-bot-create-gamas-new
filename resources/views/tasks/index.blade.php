<x-layout>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="text-dark fw-bold mb-2">Task Management</h1>
            <p class="text-muted mb-0">Track and manage all your tasks across projects</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary" style="background: #6f42c1; border-color: #6f42c1;">
                <i class="fas fa-plus me-2"></i>New Task
            </a>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- KPI Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px; background: rgba(111, 66, 193, 0.1);">
                        <i class="fas fa-tasks fa-2x" style="color: #6f42c1;"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['total'] }}</h3>
                    <p class="text-muted mb-0">Total Tasks</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px; background: rgba(40, 167, 69, 0.1);">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['completed'] }}</h3>
                    <p class="text-muted mb-0">Completed</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px; background: rgba(255, 193, 7, 0.1);">
                        <i class="fas fa-spinner fa-2x text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['in_progress'] }}</h3>
                    <p class="text-muted mb-0">In Progress</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px; background: rgba(220, 53, 69, 0.1);">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['overdue'] }}</h3>
                    <p class="text-muted mb-0">Overdue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tasks.index') }}" class="row g-3">
                <!-- Search -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search tasks..." value="{{ request('search') }}">
                </div>

                <!-- Project Filter -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Project</label>
                    <select name="project_id" class="form-select">
                        <option value="">All Projects</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Assignee Filter -->
                <div class="col-md-2">
                    <label class="form-label small text-muted">Assignee</label>
                    <select name="assignee_id" class="form-select">
                        <option value="">All</option>
                        <option value="me" {{ request('assignee_id') == 'me' ? 'selected' : '' }}>My Tasks</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('assignee_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="col-md-2">
                    <label class="form-label small text-muted">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>To Do</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="review" {{ request('status') == 'review' ? 'selected' : '' }}>Review</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>

                <!-- Priority Filter -->
                <div class="col-md-2">
                    <label class="form-label small text-muted">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="">All Priority</option>
                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="med" {{ request('priority') == 'med' ? 'selected' : '' }}>Medium</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" style="background: #6f42c1; border-color: #6f42c1;">
                        <i class="fas fa-filter me-2"></i>Apply Filters
                    </button>
                    @if(request()->hasAny(['search', 'project_id', 'assignee_id', 'status', 'priority']))
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tasks Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>Tasks List
                </h5>
                <span class="badge bg-secondary">{{ $tasks->total() }} tasks</span>
            </div>
        </div>
        <div class="card-body p-0">
            @if($tasks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Task</th>
                                <th class="px-4 py-3">Project</th>
                                <th class="px-4 py-3">Assignee</th>
                                <th class="px-4 py-3">Priority</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Due Date</th>
                                <th class="px-4 py-3">Progress</th>
                                <th class="px-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div>
                                            <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none fw-semibold text-dark">
                                                {{ $task->title }}
                                            </a>
                                            @if($task->labels->count() > 0)
                                                <div class="mt-1">
                                                    @foreach($task->labels->take(2) as $label)
                                                        <span class="badge" style="background-color: {{ $label->color }}20; color: {{ $label->color }}; font-size: 0.7em;">
                                                            {{ $label->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('projects.show', $task->project) }}" class="text-decoration-none">
                                            <small class="text-muted d-block">{{ $task->project->code }}</small>
                                            <span class="fw-semibold">{{ $task->project->name }}</span>
                                        </a>
                                    </td>
                                    <td class="px-4 py-3">
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
                                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center me-2" 
                                                        style="width: 32px; height: 32px; background: #6f42c1;">
                                                        <small class="text-white fw-bold">{{ strtoupper(substr($task->assignee->name, 0, 1)) }}</small>
                                                    </div>
                                                @endif
                                                <span class="small">{{ $task->assignee->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted small">Unassigned</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $priorityColors = [
                                                'urgent' => 'danger',
                                                'high' => 'warning',
                                                'med' => 'info',
                                                'low' => 'secondary'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $priorityColors[$task->priority] ?? 'secondary' }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusColors = [
                                                'todo' => 'secondary',
                                                'in_progress' => 'warning',
                                                'review' => 'info',
                                                'completed' => 'success',
                                                'done' => 'success',
                                                'blocked' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$task->status] ?? 'secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($task->due_date)
                                            @php
                                                $isOverdue = $task->due_date->isPast() && !in_array($task->status, ['completed', 'done']);
                                            @endphp
                                            <div class="{{ $isOverdue ? 'text-danger fw-semibold' : '' }}">
                                                {{ $task->due_date->format('M d, Y') }}
                                                @if($isOverdue)
                                                    <i class="fas fa-exclamation-circle ms-1"></i>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted small">No due date</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 8px; width: 80px;">
                                                <div class="progress-bar" 
                                                     style="width: {{ $task->progress_percent }}%; background: #6f42c1;"
                                                     role="progressbar">
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $task->progress_percent }}%</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('tasks.show', $task) }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" 
                                               class="btn btn-sm btn-outline-secondary"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    type="button"
                                                    onclick="openDeleteModal({{ $task->id }}, '{{ $task->title }}')"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($tasks->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $tasks->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No tasks found</h5>
                    <p class="text-muted">Try adjusting your filters or create a new task</p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary mt-3" style="background: #6f42c1; border-color: #6f42c1;">
                        <i class="fas fa-plus me-2"></i>Create New Task
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="delete-modal" id="deleteModal">
    <div class="delete-modal-content">
        <div class="delete-modal-header">
            <div class="delete-icon">
                <i class="fas fa-trash" style="color: white; font-size: 24px;"></i>
            </div>
            <h3 class="delete-modal-title">Delete Task?</h3>
            <p class="delete-modal-text">
                Are you sure you want to delete "<span id="deleteModalTaskName"></span>"? 
                This action cannot be undone.
            </p>
        </div>
        <div class="delete-modal-body">
            <button type="button" class="btn-delete-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-delete-confirm" onclick="confirmDelete()">Yes, Delete</button>
        </div>
    </div>
</div>

<form id="deleteTaskForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.card {
    transition: all 0.2s ease;
}

.table-hover tbody tr:hover {
    background-color: rgba(111, 66, 193, 0.05);
}

.progress {
    background-color: rgba(111, 66, 193, 0.1);
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

/* Delete Modal Styles */
.delete-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(8px);
    z-index: 20000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.delete-modal.active {
    opacity: 1;
    visibility: visible;
}

.delete-modal-content {
    background: white;
    border-radius: 20px;
    box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
    width: 100%;
    max-width: 480px;
    transform: scale(0.8) translateY(30px);
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    overflow: hidden;
}

.delete-modal.active .delete-modal-content {
    transform: scale(1) translateY(0);
}

.delete-modal-header {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    padding: 32px;
    text-align: center;
    border-bottom: 1px solid #fecaca;
}

.delete-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    box-shadow: 0 8px 24px rgba(239, 68, 68, 0.3);
}

.delete-modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px 0;
}

.delete-modal-text {
    color: #6b7280;
    line-height: 1.5;
    margin: 0;
}

.delete-modal-body {
    padding: 24px 32px 32px;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.btn-delete-cancel {
    background: #f3f4f6;
    color: #374151;
    padding: 12px 24px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-delete-cancel:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}

.btn-delete-confirm {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-delete-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
}
</style>

<script>
let deleteTaskId = null;
let deleteFormAction = '';

function openDeleteModal(taskId, taskName) {
    deleteTaskId = taskId;
    deleteFormAction = /tasks/${taskId};
    
    document.getElementById('deleteModalTaskName').textContent = taskName;
    document.getElementById('deleteModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
    document.body.style.overflow = 'auto';
    deleteTaskId = null;
}

function confirmDelete() {
    if (deleteFormAction) {
        const form = document.getElementById('deleteTaskForm');
        form.action = deleteFormAction;
        form.submit();
    }
}

// Close modal when clicking outside
document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (document.getElementById('deleteModal')?.classList.contains('active')) {
            closeDeleteModal();
        }
    }
});
</script>
</x-layout>