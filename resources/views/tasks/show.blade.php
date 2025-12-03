<x-layout>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('projects.show', $task->project) }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="flex-grow-1">
                    <h1 class="text-dark fw-bold mb-2">{{ $task->title }}</h1>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <a href="{{ route('projects.show', $task->project) }}" class="text-decoration-none">
                            <span class="text-muted">
                                <i class="fas fa-folder me-1"></i>
                                {{ $task->project->name }} ({{ $task->project->code }})
                            </span>
                        </a>
                        
                        @php
                            $statusColors = [
                                'todo' => 'secondary',
                                'in_progress' => 'warning',
                                'review' => 'info',
                                'completed' => 'success',
                                'done' => 'success',
                                'blocked' => 'danger'
                            ];
                            $priorityColors = [
                                'urgent' => 'danger',
                                'high' => 'warning',
                                'med' => 'info',
                                'low' => 'secondary'
                            ];
                        @endphp
                        
                        <span class="badge bg-{{ $statusColors[$task->status] ?? 'secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                        
                        <span class="badge bg-{{ $priorityColors[$task->priority] ?? 'secondary' }}">
                            {{ ucfirst($task->priority) }} Priority
                        </span>

                        @foreach($task->labels as $label)
                            <span class="badge" style="background-color: {{ $label->color }};">
                                {{ $label->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="btn-group" role="group">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary border-2">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-primary dropdown-toggle border-0" 
                        data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button class="dropdown-item text-danger" 
                                    type="button"
                                    onclick="openDeleteModal({{ $task->id }}, '{{ $task->title }}')">
                                <i class="fas fa-trash me-2"></i>Delete Task
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8 mb-4">
            <!-- Task Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-align-left me-2 text-info"></i>Description
                    </h5>
                </div>
                <div class="card-body">
                    @if($task->description)
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $task->description }}</p>
                    @else
                        <p class="text-muted fst-italic mb-0">No description provided for this task.</p>
                    @endif
                </div>
            </div>

            <!-- Progress Updates -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2 text-primary"></i>Progress Updates
                        </h5>
                        <button class="btn btn-sm btn-outline-primary" onclick="document.getElementById('addProgressModal').style.display='flex'">
                            <i class="fas fa-plus me-1"></i>Add Update
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($task->progressUpdates->count() > 0)
                        <div class="timeline">
                            @foreach($task->progressUpdates as $update)
                                <div class="timeline-item">
                                    <div class="timeline-marker" style="background: #6f42c1;"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <strong>{{ $update->creator->name }}</strong>
                                                <span class="badge bg-primary ms-2">{{ $update->percent }}%</span>
                                            </div>
                                            <small class="text-muted">{{ $update->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if($update->note)
                                            <p class="mb-2">{{ $update->note }}</p>
                                        @endif
                                        @if($update->is_blocked)
                                            <span class="badge bg-danger">
                                                <i class="fas fa-exclamation-circle me-1"></i>Blocked
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-chart-line fa-2x mb-3"></i>
                            <p class="mb-0">No progress updates yet. Add the first update!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-comments me-2 text-success"></i>Comments ({{ $task->comments->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Add Comment Form -->
                    <form action="{{ route('comments.store', $task->id) }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="commentable_type" value="App\Models\Task">
                        <input type="hidden" name="commentable_id" value="{{ $task->id }}">
                        <div class="mb-3">
                            <textarea class="form-control" 
                                      name="body" 
                                      rows="3" 
                                      placeholder="Write a comment..." 
                                      required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="background: #6f42c1; border-color: #6f42c1;">
                            <i class="fas fa-paper-plane me-2"></i>Post Comment
                        </button>
                    </form>

                    <!-- Comments List -->
                    @if($task->comments->count() > 0)
                        <div class="comments-list">
                            @foreach($task->comments as $comment)
                                <div class="comment-item {{ !$loop->last ? 'border-bottom pb-3 mb-3' : '' }}">
                                    <div class="d-flex">
                                        @if($comment->user->profile_picture)
                                            <img src="{{ filter_var($comment->user->profile_picture, FILTER_VALIDATE_URL)
                                                    ? $comment->user->profile_picture
                                                    : asset('storage/' . $comment->user->profile_picture) }}"
                                                alt="{{ $comment->user->name }}"
                                                class="rounded-circle me-3"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center me-3" 
                                                style="width: 40px; height: 40px; background: #6f42c1;">
                                                <span class="text-white fw-bold">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <strong>{{ $comment->user->name }}</strong>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0">{{ $comment->body }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Task Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-secondary"></i>Task Details
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Assignee -->
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Assignee</label>
                        @if($task->assignee)
                            <div class="d-flex align-items-center">
                                @if($task->assignee->profile_picture)
                                    <img src="{{ filter_var($task->assignee->profile_picture, FILTER_VALIDATE_URL)
                                            ? $task->assignee->profile_picture
                                            : asset('storage/' . $task->assignee->profile_picture) }}"
                                        alt="{{ $task->assignee->name }}"
                                        class="rounded-circle me-2"
                                        style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #e2e8f0;">
                                @else
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center me-2" 
                                        style="width: 32px; height: 32px; background: #6f42c1;">
                                        <small class="text-white fw-bold">{{ strtoupper(substr($task->assignee->name, 0, 1)) }}</small>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ $task->assignee->name }}</div>
                                    <small class="text-muted">{{ $task->assignee->email }}</small>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">Unassigned</p>
                        @endif
                    </div>

                    <!-- Due Date -->
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Due Date</label>
                        @if($task->due_date)
                            @php
                                $isOverdue = $task->due_date->isPast() && !in_array($task->status, ['completed', 'done']);
                            @endphp
                            <div class="{{ $isOverdue ? 'text-danger fw-semibold' : 'fw-semibold' }}">
                                {{ $task->due_date->format('M d, Y') }}
                                @if($isOverdue)
                                    <i class="fas fa-exclamation-circle ms-1"></i>
                                    <div class="small">Overdue by {{ $task->due_date->diffForHumans(null, true) }}</div>
                                @endif
                            </div>
                        @else
                            <p class="text-muted mb-0">No due date set</p>
                        @endif
                    </div>

                    <!-- Progress -->
                    <div class="mb-3">
                        <label class="text-muted small mb-2 d-flex justify-content-between">
                            <span>Progress</span>
                            <span class="fw-semibold">{{ $task->progress_percent }}%</span>
                        </label>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" 
                                 role="progressbar" 
                                 style="width: {{ $task->progress_percent }}%; background: #6f42c1;"
                                 aria-valuenow="{{ $task->progress_percent }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    <!-- Created -->
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Created</label>
                        <div class="fw-semibold">{{ $task->created_at->format('M d, Y H:i') }}</div>
                        <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                    </div>

                    <!-- Last Updated -->
                    <div class="mb-0">
                        <label class="text-muted small mb-1">Last Updated</label>
                        <div class="fw-semibold">{{ $task->updated_at->format('M d, Y H:i') }}</div>
                        <small class="text-muted">{{ $task->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>

            <!-- Quick Status Update -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Update Status</label>
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="review" {{ $task->status == 'review' ? 'selected' : '' }}>Review</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="blocked" {{ $task->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                            </select>
                        </div>
                    </form>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Edit Task
                        </a>
                        <a href="{{ route('projects.show', $task->project) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-folder me-2"></i>View Project
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Progress Modal -->
<div id="addProgressModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div class="card border-0 shadow-lg" style="width: 500px; max-width: 90%;">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">Add Progress Update</h5>
        </div>
        <form action="{{ route('progress.store', $task) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Progress (%)</label>
                    <input type="number" name="percent" class="form-control" min="0" max="100" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Note</label>
                    <textarea name="note" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_blocked" value="1" id="isBlocked">
                    <label class="form-check-label" for="isBlocked">
                        Task is blocked
                    </label>
                </div>
            </div>
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('addProgressModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #6f42c1; border-color: #6f42c1;">Save Update</button>
                </div>
            </div>
        </form>
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
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #6f42c1;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -25px;
    top: 17px;
    bottom: -20px;
    width: 2px;
    background: #e5e7eb;
}

.timeline-content {
    background: #f9fafb;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #6f42c1;
}

.comment-item {
    padding: 15px;
    background: #f9fafb;
    border-radius: 8px;
    margin-bottom: 15px;
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

document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (document.getElementById('deleteModal')?.classList.contains('active')) {
            closeDeleteModal();
        }
        if (document.getElementById('addProgressModal').style.display === 'flex') {
            document.getElementById('addProgressModal').style.display = 'none';
        }
    }
});
</script>
</x-layout>