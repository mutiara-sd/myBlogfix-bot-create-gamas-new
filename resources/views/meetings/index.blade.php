<x-layout>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-dark fw-bold mb-1">Meetings & Notulen</h2>
            <p class="text-muted mb-0">Manage and track your meetings</p>
        </div>
        <a href="{{ route('meetings.create') }}" class="btn btn-primary" style="background:#6f42c1; border-color:#6f42c1;">
            <i class="fas fa-plus me-2"></i>New Meeting
        </a>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter: Project Dropdown & Status Tabs -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Project Filter -->
        <form method="GET" class="d-flex align-items-center gap-2">
            <label class="text-muted mb-0">Project:</label>
            <select name="project_id" onchange="this.form.submit()" class="form-select" style="width: auto;">
                <option value="">All Projects</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Status Tabs -->
        <ul class="nav nav-pills custom-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ !request('status') ? 'active' : '' }}" 
                   href="{{ route('meetings.index', ['project_id' => request('project_id')]) }}">
                    <i class="fas fa-list me-2"></i>All Meetings
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') === 'draft' ? 'active' : '' }}" 
                   href="{{ route('meetings.index', ['status' => 'draft', 'project_id' => request('project_id')]) }}">
                    <i class="fas fa-edit me-2"></i>Draft
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') === 'done' ? 'active' : '' }}" 
                   href="{{ route('meetings.index', ['status' => 'done', 'project_id' => request('project_id')]) }}">
                    <i class="fas fa-check-circle me-2"></i>Done
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request('status') === 'cancelled' ? 'active' : '' }}" 
                   href="{{ route('meetings.index', ['status' => 'cancelled', 'project_id' => request('project_id')]) }}">
                    <i class="fas fa-times-circle me-2"></i>Cancelled
                </a>
            </li>
        </ul>
    </div>

    <!-- Meetings Grid -->
    @if($meetings->count() > 0)
        <div class="row">
            @foreach($meetings as $meeting)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm meeting-card" style="transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <!-- Meeting Header -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="card-title text-dark fw-bold mb-1">{{ $meeting->title }}</h5>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-project-diagram me-1"></i>
                                        {{ $meeting->project ? $meeting->project->name : 'No project' }}
                                    </p>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle border-0" 
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('meetings.show', $meeting) }}">
                                            <i class="fas fa-eye me-2"></i>View
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('meetings.edit', $meeting) }}">
                                            <i class="fas fa-edit me-2"></i>Edit
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" 
                                                    type="button"
                                                    data-meeting-id="{{ $meeting->id }}"
                                                    data-meeting-title="{{ $meeting->title }}"
                                                    onclick="openDeleteModal(this.dataset.meetingId, this.dataset.meetingTitle)">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div class="mb-3">
                                <span class="badge 
                                    @if($meeting->status == 'draft') bg-warning
                                    @elseif($meeting->status == 'done') bg-success
                                    @elseif($meeting->status == 'cancelled') bg-danger
                                    @endif">
                                    {{ ucfirst($meeting->status) }}
                                </span>
                            </div>

                            <!-- Meeting Info -->
                            <div class="mb-3" style="min-height: 100px;">
                                <div class="mb-2">
                                    <i class="fas fa-calendar" style="color: #8b5cf6; width: 20px;"></i>
                                    <small class="text-muted">{{ $meeting->scheduled_at->format('M d, Y') }}</small>
                                </div>
                                <div class="mb-2">
                                    <i class="fas fa-clock" style="color: #8b5cf6; width: 20px;"></i>
                                    <small class="text-muted">{{ $meeting->scheduled_at->format('H:i') }}</small>
                                </div>
                                <div class="mb-2">
                                    <i class="fas fa-map-marker-alt" style="color: #8b5cf6; width: 20px;"></i>
                                    <small class="text-muted">{{ $meeting->location ?? 'No location' }}</small>
                                </div>
                                <div>
                                    <i class="fas fa-user-tie" style="color: #8b5cf6; width: 20px;"></i>
                                    <small class="text-muted">{{ $meeting->organizer->name }}</small>
                                </div>
                            </div>

                            <!-- Meeting Stats -->
                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <div class="bg-light p-2 rounded text-center">
                                        <div class="fw-bold" style="color: #8b5cf6;">{{ $meeting->agendas_count ?? 0 }}</div>
                                        <small class="text-muted">Agenda</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="bg-light p-2 rounded text-center">
                                        <div class="fw-bold" style="color: #3b82f6;">{{ $meeting->minute_decisions_count ?? 0 }}</div>
                                        <small class="text-muted">Decisions</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="bg-light p-2 rounded text-center">
                                        <div class="fw-bold" style="color: #f59e0b;">{{ $meeting->risks_count ?? 0 }}</div>
                                        <small class="text-muted">Risks</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card Footer -->
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="{{ route('meetings.show', $meeting) }}" class="btn btn-outline-primary btn-sm w-100" style="border-color: #8b5cf6; color: #8b5cf6;">
                                <i class="fas fa-arrow-right me-2"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $meetings->appends(['status' => request('status'), 'project_id' => request('project_id')])->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-calendar-times text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-muted mb-3">No Meetings Found</h4>
            <p class="text-muted mb-4">
                @if(request('status'))
                    No meetings with status "{{ request('status') }}" found.
                @else
                    You haven't created any meetings yet. Start by creating your first meeting!
                @endif
            </p>
            <a href="{{ route('meetings.create') }}" class="btn btn-primary" style="background: #8b5cf6; border-color:#8b5cf6;">
                <i class="fas fa-plus me-2"></i>Create Your First Meeting
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
            <h3 class="delete-modal-title">Delete Meeting?</h3>
            <p class="delete-modal-text">
                Are you sure you want to delete "<span id="deleteModalMeetingTitle"></span>"? 
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
<form id="deleteMeetingForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.meeting-card {
    transition: all 0.3s ease;
}

.meeting-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(139, 92, 246, 0.15) !important;
}

/* Tab Styling */
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
    color: #8b5cf6;
    text-decoration: none !important;
}

.nav-pills .nav-link:focus {
    outline: none !important;
    box-shadow: none !important;
}

.nav-pills .nav-link.active {
    color: #8b5cf6 !important;
    background: transparent !important;
}

.nav-pills .nav-link.active::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background-color: #8b5cf6;
    border-radius: 3px;
}

/* Delete Modal */
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
let deleteMeetingId = null;
let deleteFormAction = '';

function openDeleteModal(meetingId, meetingTitle) {
    deleteMeetingId = meetingId;
    deleteFormAction = `/meetings/${meetingId}`;
    
    document.getElementById('deleteModalMeetingTitle').textContent = meetingTitle;
    document.getElementById('deleteModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
    document.body.style.overflow = 'auto';
    deleteMeetingId = null;
}

function confirmDelete() {
    if (deleteFormAction) {
        const form = document.getElementById('deleteMeetingForm');
        form.action = deleteFormAction;
        form.submit();
    }
}

// Close modal saat klik outside
document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal dengan Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('deleteModal')?.classList.contains('active')) {
        closeDeleteModal();
    }
});
</script>
</x-layout>