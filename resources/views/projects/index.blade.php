<x-layout>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-dark fw-bold mb-1">Projects</h2>
            <p class="text-muted mb-0">Manage and track your projects</p>
        </div>
        <a href="{{ route('projects.create') }}" class="btn btn-primary" style="background:#6f42c1; border-color:#6f42c1;">
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
                    <div class="card h-100 border-0 shadow-sm project-card" style="transition: all 0.3s ease;">
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
                                            <form action="{{ route('projects.destroy', $project) }}" method="POST" 
                                                  class="d-inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </button>
                                            </form>
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
                                    <div class="bg-light p-2 rounded text-center">
                                        <div class="fw-bold text-primary">{{ $project->tasks_count ?? 0 }}</div>
                                        <small class="text-muted">Tasks</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-2 rounded text-center">
                                        <div class="fw-bold" style="color: #6f42c1;">0%</div>
                                        <small class="text-muted">Complete</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar" style="background: linear-gradient(45deg, #6f42c1, #9b59b6); width: 0%"></div>
                            </div>

                            <!-- Project Footer -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($project->status === 'active')
                                        <span class="badge bg-success">Active</span>
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
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-primary btn-sm w-100">
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
            <a href="{{ route('projects.create') }}" class="btn btn-primary" style="background: #6f42c1; border-color:#6f42c1;">
                <i class="fas fa-plus me-2"></i>Create Your First Project
            </a>
        </div>
    @endif
</div>

<style>
.project-card {
    transition: all 0.3s ease;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(111, 66, 193, 0.1) !important;
}

/* ✅ Fix untuk tab - hilangkan border & outline */
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
    color: #6f42c1;
    text-decoration: none !important;
}

.nav-pills .nav-link:focus {
    outline: none !important;
    box-shadow: none !important;
}

.nav-pills .nav-link.active {
    color: #6f42c1 !important;
    background: transparent !important;
}

.nav-pills .nav-link.active::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background-color: #6f42c1;
    border-radius: 3px;
}

.progress-bar {
    transition: width 0.6s ease;
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
</style>
</x-layout>