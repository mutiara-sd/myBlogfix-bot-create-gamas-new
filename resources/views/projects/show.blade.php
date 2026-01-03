<x-layout>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left me"></i>
                </a>
                <div>
                    <h1 class="text-dark fw-bold mb-1">{{ $project->name }}</h1>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted">Code: <strong>{{ $project->code }}</strong></span>
                        @if($project->status === 'active')
                            <span class="badge telkom-badge-active">Active</span>
                        @else
                            <span class="badge bg-secondary">Archived</span>
                        @endif
                        <span class="text-muted">
                            <i class="fas fa-user me-1"></i>{{ $project->owner->name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="btn-group" role="group">
                <a href="{{ route('projects.edit', $project) }}" class="btn telkom-btn-outline">
                    <i class="fas fa-edit me-2"></i>
                </a>
                <div class="btn-group" role="group">
                    <button class="btn btn-sm telkom-btn-outline dropdown-toggle border-0" 
                        data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('projects.toggle-archive', $project) }}" method="POST" class="d-inline w-100">
                                @csrf
                                @method('PATCH')
                                <button class="dropdown-item" type="submit">
                                    <i class="fas fa-{{ $project->status === 'active' ? 'archive' : 'undo' }} me-2"></i>
                                    {{ $project->status === 'active' ? 'Archive Project' : 'Unarchive Project' }}
                                </button>
                            </form>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button class="dropdown-item text-danger" 
                                    type="button"
                                    data-project-id="{{ $project->id }}"
                                    data-project-name="{{ $project->name }}"
                                    onclick="openDeleteModal(this.dataset.projectId, this.dataset.projectName)">
                                <i class="fas fa-trash me-2"></i>Delete Project
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

    <!-- Project Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 telkom-stat-card">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 telkom-icon-circle">
                        <i class="fas fa-tasks fa-2x telkom-text"></i>
                    </div>
                    <h3 class="fw-bold mb-1 telkom-text">{{ $project->tasks->count() }}</h3>
                    <p class="text-muted mb-0">Total Tasks</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 telkom-stat-card">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px; background: rgba(40, 167, 69, 0.1);">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $project->tasks->where('status', 'completed')->count() }}</h3>
                    <p class="text-muted mb-0">Completed</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 telkom-stat-card">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px; background: rgba(255, 193, 7, 0.1);">
                        <i class="fas fa-spinner fa-2x text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $project->tasks->where('status', 'in_progress')->count() }}</h3>
                    <p class="text-muted mb-0">In Progress</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 telkom-stat-card">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px; background: rgba(220, 53, 69, 0.1);">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $project->tasks->where('status', 'blocked')->count() }}</h3>
                    <p class="text-muted mb-0">Blocked</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8 mb-4">
            <!-- Project Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 telkom-text"></i>Project Description
                    </h5>
                </div>
                <div class="card-body">
                    @if($project->description)
                        <p class="mb-0">{{ $project->description }}</p>
                    @else
                        <p class="text-muted fst-italic mb-0">No description provided for this project.</p>
                    @endif
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2 telkom-text"></i>Recent Tasks
                        </h5>
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm telkom-btn-outline">View All Tasks</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($project->tasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($project->tasks->take(5) as $task)
                                <a href="{{ route('tasks.show', $task->id) }}" class="list-group-item px-0 text-decoration-none hover-task-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark">{{ $task->title }}</h6>
                                            <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                            <i class="fas fa-chevron-right text-muted"></i>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-plus-circle fa-2x mb-3"></i>
                            <p class="mb-3">No tasks yet. Create your first task!</p>
                            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" 
                            class="btn btn-sm btn-primary telkom-btn">
                                <i class="fas fa-plus me-1"></i>Add Task
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Project Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info me-2 telkom-text"></i>Project Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Created</label>
                        <div class="fw-semibold">{{ $project->created_at->format('M d, Y') }}</div>
                        <small class="text-muted">{{ $project->created_at->diffForHumans() }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="text-muted small">Last Updated</label>
                        <div class="fw-semibold">{{ $project->updated_at->format('M d, Y') }}</div>
                        <small class="text-muted">{{ $project->updated_at->diffForHumans() }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="text-muted small">Owner</label>
                        <div class="d-flex align-items-center">
                            @if($project->owner->profile_picture)
                                <!-- Jika ada foto profil, tampilkan foto -->
                                <img src="{{ filter_var($project->owner->profile_picture, FILTER_VALIDATE_URL)
                                        ? $project->owner->profile_picture
                                        : asset('storage/' . $project->owner->profile_picture) }}"
                                    alt="{{ $project->owner->name }}"
                                    class="rounded-circle me-2 telkom-avatar"
                                    style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <!-- Jika belum ada foto profil, tampilkan inisial -->
                                <div class="rounded-circle telkom-avatar-initial d-inline-flex align-items-center justify-content-center me-2" 
                                    style="width: 32px; height: 32px;">
                                    <small class="text-white fw-bold">{{ strtoupper(substr($project->owner->name, 0, 1)) }}</small>
                                </div>
                            @endif
                            <div>
                                <div class="fw-semibold">{{ $project->owner->name }}</div>
                                <small class="text-muted">{{ $project->owner->email }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Meetings -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar me-2 telkom-text"></i>Recent Meetings
                        </h5>
                        <a href="{{ route('meetings.index') }}" class="btn btn-sm telkom-btn-outline">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($project->meetings->count() > 0)
                        @foreach($project->meetings->take(3) as $meeting)
                            <a href="{{ route('meetings.show', $meeting->id) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }} hover-card">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center telkom-meeting-icon" 
                                            style="width: 40px; height: 40px;">
                                            <i class="fas fa-video telkom-text"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-dark">{{ $meeting->title }}</h6>
                                        <small class="text-muted">{{ $meeting->scheduled_at->format('M d, Y H:i') }}</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-chevron-right text-muted"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-calendar-plus fa-2x mb-2"></i>
                            <p class="mb-0">No meetings scheduled</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 telkom-text"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('tasks.create') }}" class="btn telkom-btn-outline">
                            <i class="fas fa-plus me-2"></i>Add Task
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="delete-modal" id="deleteModal">
    <div class="delete-modal-content">
        <div class="delete-modal-header">
            <div class="delete-icon">
                <i class="fas fa-trash" style="color: white; font-size: 24px;"></i>
            </div>
            <h3 class="delete-modal-title">Delete Project?</h3>
            <p class="delete-modal-text">
                Are you sure you want to delete "<span id="deleteModalProjectName"></span>"? 
                This action cannot be undone.
            </p>
        </div>
        <div class="delete-modal-body">
            <button type="button" class="btn-delete-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-delete-confirm" onclick="confirmDelete()">Yes, Delete</button>
        </div>
    </div>
</div>

<!-- Hidden form untuk delete -->
<form id="deleteProjectForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
/* Telkom Infra Color Scheme */
:root {
    --telkom-red: #E30613;
    --telkom-red-dark: #C00510;
    --telkom-red-light: #FFE8EA;
}

/* Primary Colors */
.telkom-text {
    color: var(--telkom-red);
}

.telkom-btn {
    background: var(--telkom-red) !important;
    border-color: var(--telkom-red) !important;
    color: white !important;
    transition: all 0.3s ease;
}

.telkom-btn:hover {
    background: var(--telkom-red-dark) !important;
    border-color: var(--telkom-red-dark) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(227, 6, 19, 0.3);
}

.telkom-btn-outline {
    color: var(--telkom-red) !important;
    border-color: var(--telkom-red) !important;
    transition: all 0.3s ease;
}

.telkom-btn-outline:hover {
    background: var(--telkom-red) !important;
    border-color: var(--telkom-red) !important;
    color: white !important;
}

.telkom-back-btn {
    transition: all 0.3s ease;
}

.telkom-back-btn:hover {
    color: var(--telkom-red) !important;
    border-color: var(--telkom-red) !important;
}

/* Badges */
.telkom-badge-active {
    background: var(--telkom-red);
    color: white;
}

.telkom-badge-progress {
    background: var(--telkom-red);
    font-size: 0.9em;
    padding: 0.5rem 0.75rem;
}

/* Stats Cards */
.telkom-stat-card {
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.telkom-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(227, 6, 19, 0.15) !important;
    border-color: var(--telkom-red-light);
}

.telkom-icon-circle {
    width: 60px;
    height: 60px;
    background: var(--telkom-red-light);
}

/* Progress Bar */
.telkom-progress {
    background: linear-gradient(90deg, var(--telkom-red) 0%, #ff4757 100%);
    transition: width 0.6s ease;
}

/* Avatar */
.telkom-avatar {
    border: 2px solid var(--telkom-red-light);
}

.telkom-avatar-initial {
    background: var(--telkom-red);
}

/* Meeting Icon */
.telkom-meeting-icon {
    background: var(--telkom-red-light);
}

/* Hover Effects */
.hover-task-item {
    transition: all 0.2s ease;
    border-radius: 8px;
    border: none !important;
}

.hover-task-item:hover {
    background-color: var(--telkom-red-light);
    transform: translateX(5px);
}

.hover-task-item:hover h6 {
    color: var(--telkom-red) !important;
}

.hover-card {
    transition: all 0.2s ease;
    border-radius: 8px;
    padding: 8px;
    margin: -8px;
}

.hover-card:hover {
    background-color: var(--telkom-red-light);
    transform: translateX(5px);
}

a.text-decoration-none:hover .hover-card h6 {
    color: var(--telkom-red) !important;
}

/* Cards */
.card {
    transition: all 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

/* Buttons */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Delete Confirmation Modal */
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
    background: linear-gradient(135deg, var(--telkom-red-light) 0%, #ffd1d4 100%);
    padding: 32px;
    text-align: center;
    border-bottom: 1px solid #ffb3b8;
}

.delete-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, var(--telkom-red) 0%, var(--telkom-red-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    box-shadow: 0 8px 24px rgba(227, 6, 19, 0.4);
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
    background: linear-gradient(135deg, var(--telkom-red) 0%, var(--telkom-red-dark) 100%);
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
    box-shadow: 0 8px 25px rgba(227, 6, 19, 0.4);
}
</style>

<script>
let deleteProjectId = null;
let deleteFormAction = '';

function openDeleteModal(projectId, projectName) {
    console.log('Opening delete modal for:', projectId, projectName);
    deleteProjectId = projectId;
    deleteFormAction = `/projects/${projectId}`;
    
    document.getElementById('deleteModalProjectName').textContent = projectName;
    document.getElementById('deleteModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
    document.body.style.overflow = 'auto';
    deleteProjectId = null;
}

function confirmDelete() {
    if (deleteFormAction) {
        const form = document.getElementById('deleteProjectForm');
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