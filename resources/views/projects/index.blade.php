<x-layout>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-dark fw-bold mb-1">Projects</h2>
            <p class="text-muted mb-0">Manage and track your projects</p>
        </div>
        <a href="{{ route('projects.create') }}" class="btn btn-primary telkom-btn">
            <i class="fas fa-plus me-2"></i>New Project
        </a>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Tabs -->
    <ul class="nav nav-pills mb-4 custom-tabs" id="statusTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ !request('status') ? 'active' : '' }}" 
               href="{{ route('projects.index') }}">
                <i class="fas fa-list me-2"></i>All Projects
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link {{ request('status') === 'active' ? 'active' : '' }}" 
               href="{{ route('projects.index', ['status' => 'active']) }}">
                <i class="fas fa-play-circle me-2"></i>Active
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link {{ request('status') === 'archived' ? 'active' : '' }}" 
               href="{{ route('projects.index', ['status' => 'archived']) }}">
                <i class="fas fa-archive me-2"></i>Archived
            </a>
        </li>
    </ul>


    <!-- Projects Grid -->
    @if($projects->count() > 0)
        <div class="row">
            @foreach($projects as $project)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm project-card">
                        <div class="card-body p-4">
                            <!-- Project Header -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="card-title text-dark fw-bold mb-1">{{ $project->name }}</h5>
                                    <p class="text-muted small mb-2">Code: {{ $project->code }}</p>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle border-0" 
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('projects.show', $project) }}">
                                            <i class="fas fa-eye me-2"></i>View
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('projects.edit', $project) }}">
                                            <i class="fas fa-edit me-2"></i>Edit
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('projects.toggle-archive', $project) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="dropdown-item" type="submit">
                                                    <i class="fas fa-{{ $project->status === 'active' ? 'archive' : 'undo' }} me-2"></i>
                                                    {{ $project->status === 'active' ? 'Archive' : 'Unarchive' }}
                                                </button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" 
                                                    type="button"
                                                    data-project-id="{{ $project->id }}"
                                                    data-project-name="{{ $project->name }}"
                                                    onclick="openDeleteModal(this.getAttribute('data-project-id'), this.getAttribute('data-project-name'))">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Project Description -->
                            <p class="text-muted mb-3" style="min-height: 48px;">
                                {{ Str::limit($project->description, 100) ?: 'No description provided.' }}
                            </p>

                            <!-- Project Stats -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="telkom-stat-box">
                                        <div class="fw-bold telkom-text">{{ $project->tasks_count ?? 0 }}</div>
                                        <small class="text-muted">Tasks</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="telkom-stat-box">
                                        <div class="fw-bold telkom-text">0%</div>
                                        <small class="text-muted">Complete</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar telkom-progress" style="width: 0%"></div>
                            </div>

                            <!-- Project Footer -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($project->status === 'active')
                                        <span class="badge telkom-badge-active">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Archived</span>
                                    @endif
                                </div>
                                <div class="text-muted small">
                                    <i class="fas fa-user me-1"></i>{{ $project->owner->name ?? 'Unknown' }}
                                </div>
                            </div>
                            
                            <div class="text-muted small mt-2">
                                <i class="fas fa-calendar me-1"></i>Created {{ $project->created_at->diffForHumans() }}
                            </div>
                        </div>
                        
                        <!-- Card Footer with Action -->
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-danger telkom-btn-outline w-100">
                                <i class="fas fa-arrow-right me-2"></i>View Project
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $projects->appends(['status' => request('status')])->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-folder-open text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-muted mb-3">No Projects Found</h4>
            <p class="text-muted mb-4">
                @if(request('status') === 'active')
                    You don't have any active projects.
                @elseif(request('status') === 'archived')
                    You don't have any archived projects.
                @else
                    You haven't created any projects yet. Start by creating your first project!
                @endif
            </p>
            <a href="{{ route('projects.create') }}" class="btn btn-primary telkom-btn">
                <i class="fas fa-plus me-2"></i>Create Your First Project
            </a>
        </div>
    @endif
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

/* Primary Button - Telkom Red */
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

/* Outline Button - Telkom Red */
.telkom-btn-outline {
    color: var(--telkom-red) !important;
    border-color: var(--telkom-red) !important;
    transition: all 0.3s ease;
}

.telkom-btn-outline:hover {
    background: var(--telkom-red) !important;
    border-color: var(--telkom-red) !important;
    color: white !important;
    transform: translateY(-2px);
}

/* Project Card Hover Effect */
.project-card {
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(227, 6, 19, 0.15) !important;
    border-color: var(--telkom-red-light);
}

/* Telkom Stats Box */
.telkom-stat-box {
    background: linear-gradient(135deg, #fff5f5 0%, #ffe8ea 100%);
    padding: 12px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid var(--telkom-red-light);
}

.telkom-text {
    color: var(--telkom-red);
}

/* Progress Bar - Telkom Red */
.telkom-progress {
    background: linear-gradient(90deg, var(--telkom-red) 0%, #ff4757 100%);
    transition: width 0.6s ease;
}

/* Badge - Telkom Red */
.telkom-badge-active {
    background: var(--telkom-red);
    color: white;
}

/* Navigation Tabs */
.nav-pills .nav-link {
    color: #6c757d;
    background: transparent !important;
    border: none !important;
    border-radius: 0 !important;
    margin-right: 20px;
    padding-bottom: 8px;
    position: relative;
    transition: color 0.3s ease;
    text-decoration: none !important;
    outline: none !important;
    box-shadow: none !important;
}

.nav-pills .nav-link:hover {
    color: var(--telkom-red);
    text-decoration: none !important;
}

.nav-pills .nav-link:focus {
    outline: none !important;
    box-shadow: none !important;
}

.nav-pills .nav-link.active {
    color: var(--telkom-red) !important;
    background: transparent !important;
}

.nav-pills .nav-link.active::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background-color: var(--telkom-red);
    border-radius: 3px;
}

.card-title {
    font-size: 1.1rem;
}

.badge {
    font-size: 0.75em;
}

.dropdown-toggle::after {
    display: none;
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