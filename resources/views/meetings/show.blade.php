<x-layout>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('meetings.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-dark fw-bold mb-1">{{ $meeting->title }}</h1>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted">
                            <i class="fas fa-project-diagram me-1"></i>
                            {{ $meeting->project ? $meeting->project->name : 'No project' }}
                        </span>
                        <span class="badge 
                            @if($meeting->status == 'draft') bg-warning
                            @elseif($meeting->status == 'done') bg-success
                            @elseif($meeting->status == 'cancelled') bg-danger
                            @endif">
                            {{ ucfirst($meeting->status) }}
                        </span>
                        <span class="text-muted">
                            <i class="fas fa-user-tie me-1"></i>{{ $meeting->organizer->name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="btn-group" role="group">
                <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-outline-primary border-2">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle border-0" 
                        data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button class="dropdown-item text-danger" 
                                    type="button"
                                    onclick="openDeleteModal('{{ $meeting->id }}', '{{ $meeting->title }}')">
                                <i class="fas fa-trash me-2"></i>Delete Meeting
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

    <!-- Meeting Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px; background: rgba(139, 92, 246, 0.1);">
                        <i class="fas fa-list fa-2x" style="color: #8b5cf6;"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $meeting->agendas->count() }}</h3>
                    <p class="text-muted mb-0">Agenda Items</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px; background: rgba(59, 130, 246, 0.1);">
                        <i class="fas fa-check-circle fa-2x" style="color: #3b82f6;"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $meeting->minuteDecisions->count() }}</h3>
                    <p class="text-muted mb-0">Decisions Made</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px; background: rgba(245, 158, 11, 0.1);">
                        <i class="fas fa-exclamation-triangle fa-2x" style="color: #f59e0b;"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $meeting->risks->count() }}</h3>
                    <p class="text-muted mb-0">Identified Risks</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column - Meeting Minutes -->
        <div class="col-lg-8 mb-4">
            
            <!-- Notulen Editor Card -->
            <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #8b5cf6 !important;">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 2px solid #e9ecef;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold" style="color: #2d3748;">
                            <i class="fas fa-edit me-2" style="color: #8b5cf6;"></i>Notulen Editor
                        </h5>
                        <span class="badge" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6; font-size: 0.85rem;">
                            {{ $meeting->agendas->count() + $meeting->minuteDecisions->count() + $meeting->risks->count() }} items
                        </span>
                    </div>
                </div>
                <div class="card-body p-4" style="background: #fafbfc;">
                    
                    <!-- AGENDA SECTION -->
                    <div class="notulen-section mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0" style="color: #4b5563;">
                                <i class="fas fa-list-ul me-2" style="color: #8b5cf6;"></i>Agenda
                            </h6>
                            <button type="button" class="btn btn-sm rounded-pill" 
                                style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6; border: none; font-weight: 600; padding: 6px 16px;"
                                onclick="toggleAgendaForm()"
                                onmouseover="this.style.background='rgba(139, 92, 246, 0.2)'"
                                onmouseout="this.style.background='rgba(139, 92, 246, 0.1)'">
                                <i class="fas fa-plus me-1"></i>Add
                            </button>
                        </div>

                        <!-- Form Add Agenda -->
                        <div id="agendaForm" style="display: none;" class="mb-3">
                            <form action="{{ route('agendas.store', $meeting->id) }}" method="POST">
                                @csrf
                                <div class="input-group shadow-sm">
                                    <input type="text" name="agenda_text" placeholder="Enter agenda item..." required 
                                        class="form-control border-0" style="background: white; padding: 12px 16px;">
                                    <button type="submit" class="btn" style="background: #8b5cf6; color: white; padding: 12px 20px;">
                                        <i class="fas fa-check me-1"></i>Save
                                    </button>
                                    <button type="button" onclick="toggleAgendaForm()" class="btn btn-light">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- List Agenda -->
                        @if ($meeting->agendas->count() > 0)
                            <div class="agenda-list">
                                @foreach ($meeting->agendas as $index => $agenda)
                                    <div class="agenda-item d-flex align-items-start gap-3 p-3 mb-2 rounded" 
                                         style="background: white; border-left: 3px solid #8b5cf6; transition: all 0.2s;"
                                         onmouseover="this.style.boxShadow='0 2px 8px rgba(139, 92, 246, 0.15)'"
                                         onmouseout="this.style.boxShadow='none'">
                                        <span class="badge rounded-circle d-flex align-items-center justify-content-center" 
                                              style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6; width: 28px; height: 28px; font-weight: 600;">
                                            {{ $index + 1 }}
                                        </span>
                                        <span class="flex-grow-1" style="color: #2d3748; line-height: 1.6;">{{ $agenda->agenda_text }}</span>
                                        <form action="{{ route('agendas.destroy', $agenda->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this agenda?')" 
                                                class="btn btn-sm rounded-circle" 
                                                style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; width: 32px; height: 32px; padding: 0;"
                                                onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'"
                                                onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                                                <i class="fas fa-trash-alt" style="font-size: 12px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5 rounded" style="background: white; border: 2px dashed #e5e7eb;">
                                <i class="fas fa-list-ul mb-3" style="font-size: 2.5rem; color: #d1d5db;"></i>
                                <p class="text-muted mb-0">No agenda items yet. Click "Add" to create one.</p>
                            </div>
                        @endif
                    </div>

                    <!-- DECISIONS SECTION -->
                    <div class="notulen-section mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0" style="color: #4b5563;">
                                <i class="fas fa-check-circle me-2" style="color: #10b981;"></i>Decisions
                            </h6>
                        </div>

                        <!-- Form Add Decision -->
                        <form action="{{ route('decisions.store', $meeting->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="input-group shadow-sm">
                                <span class="input-group-text border-0" style="background: white;">
                                    <i class="fas fa-plus" style="color: #10b981;"></i>
                                </span>
                                <input type="text" name="decision_text" placeholder="Add decision..." required 
                                    class="form-control border-0" style="background: white; padding: 12px 16px;">
                                <button type="submit" class="btn" style="background: #10b981; color: white; padding: 12px 20px;">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </form>

                        <!-- List Decisions -->
                        @forelse ($meeting->minuteDecisions as $decision)
                            <div class="decision-item d-flex align-items-center gap-3 p-3 mb-2 rounded" 
                                 style="background: white; border-left: 3px solid #10b981; transition: all 0.2s;"
                                 onmouseover="this.style.boxShadow='0 2px 8px rgba(16, 185, 129, 0.15)'"
                                 onmouseout="this.style.boxShadow='none'">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                     style="width: 28px; height: 28px; background: rgba(16, 185, 129, 0.1);">
                                    <i class="fas fa-check" style="color: #10b981; font-size: 12px;"></i>
                                </div>
                                <span class="flex-grow-1" style="color: #2d3748; line-height: 1.6;">{{ $decision->decision_text }}</span>
                                <form action="{{ route('decisions.destroy', $decision->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this decision?')" 
                                        class="btn btn-sm rounded-circle" 
                                        style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; width: 32px; height: 32px; padding: 0;"
                                        onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'"
                                        onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                                        <i class="fas fa-trash-alt" style="font-size: 12px;"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="text-center py-5 rounded" style="background: white; border: 2px dashed #e5e7eb;">
                                <i class="fas fa-clipboard-check mb-3" style="font-size: 2.5rem; color: #d1d5db;"></i>
                                <p class="text-muted mb-0">No decisions recorded yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- RISKS SECTION -->
                    <div class="notulen-section mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0" style="color: #4b5563;">
                                <i class="fas fa-exclamation-triangle me-2" style="color: #f59e0b;"></i>Risks
                            </h6>
                            <button type="button" class="btn btn-sm rounded-pill" 
                                style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: none; font-weight: 600; padding: 6px 16px;"
                                onclick="toggleRiskForm()"
                                onmouseover="this.style.background='rgba(245, 158, 11, 0.2)'"
                                onmouseout="this.style.background='rgba(245, 158, 11, 0.1)'">
                                <i class="fas fa-plus me-1"></i>Add
                            </button>
                        </div>

                        <!-- Form Add Risk -->
                        <div id="riskForm" style="display: none;" class="mb-3 p-3 rounded" style="background: white; border: 1px solid #fbbf24;">
                            <form action="{{ route('risks.store', $meeting->id) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <input type="text" name="risk_title" placeholder="Risk title..." required 
                                        class="form-control" style="border-color: #fbbf24;">
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="owner" placeholder="Owner (e.g., @user)" 
                                        class="form-control" style="border-color: #fbbf24;">
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="mitigation" placeholder="Mitigation plan..." 
                                        class="form-control" style="border-color: #fbbf24;">
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-sm" style="background: #f59e0b; color: white;">
                                        <i class="fas fa-check me-1"></i>Save
                                    </button>
                                    <button type="button" onclick="toggleRiskForm()" class="btn btn-sm btn-light">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- List Risks -->
                        @if ($meeting->risks->count() > 0)
                            <div class="row g-3">
                                @foreach ($meeting->risks as $risk)
                                    <div class="col-md-12">
                                        <div class="risk-item p-3 rounded position-relative" 
                                             style="background: white; border-left: 3px solid #f59e0b; transition: all 0.2s;"
                                             onmouseover="this.style.boxShadow='0 2px 8px rgba(245, 158, 11, 0.15)'"
                                             onmouseout="this.style.boxShadow='none'">
                                            <form action="{{ route('risks.destroy', $risk->id) }}" method="POST" 
                                                class="position-absolute top-0 end-0 m-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Delete this risk?')" 
                                                    class="btn btn-sm rounded-circle" 
                                                    style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; width: 32px; height: 32px; padding: 0;"
                                                    onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'"
                                                    onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                                                    <i class="fas fa-trash-alt" style="font-size: 12px;"></i>
                                                </button>
                                            </form>
                                            
                                            <div class="d-flex align-items-start gap-3" style="padding-right: 40px;">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                                     style="width: 28px; height: 28px; background: rgba(245, 158, 11, 0.1);">
                                                    <i class="fas fa-exclamation" style="color: #f59e0b; font-size: 12px;"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-semibold mb-2" style="color: #2d3748;">{{ $risk->risk_title }}</h6>
                                                    
                                                    @if($risk->owner || $risk->mitigation)
                                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                                            @if($risk->owner)
                                                                <span class="badge rounded-pill" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-weight: 500;">
                                                                    <i class="fas fa-user me-1" style="font-size: 10px;"></i>{{ $risk->owner }}
                                                                </span>
                                                            @endif
                                                            @if($risk->mitigation)
                                                                <small class="text-muted">
                                                                    <i class="fas fa-shield-alt me-1" style="color: #f59e0b;"></i>
                                                                    <strong>Mitigation:</strong> {{ $risk->mitigation }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5 rounded" style="background: white; border: 2px dashed #e5e7eb;">
                                <i class="fas fa-shield-alt mb-3" style="font-size: 2.5rem; color: #d1d5db;"></i>
                                <p class="text-muted mb-0">No risks identified yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex gap-2 pt-3 mt-4" style="border-top: 2px solid #e9ecef;">
                        <button type="button" class="btn flex-fill" 
                            style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6; border: 2px solid rgba(139, 92, 246, 0.2); font-weight: 600;"
                            onmouseover="this.style.background='rgba(139, 92, 246, 0.15)'"
                            onmouseout="this.style.background='rgba(139, 92, 246, 0.1)'">
                            <i class="fas fa-save me-2"></i>Save Draft
                        </button>
                        <button type="button" class="btn flex-fill" 
                            style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 2px solid rgba(59, 130, 246, 0.2); font-weight: 600;"
                            onmouseover="this.style.background='rgba(59, 130, 246, 0.15)'"
                            onmouseout="this.style.background='rgba(59, 130, 246, 0.1)'">
                            <i class="fas fa-paper-plane me-2"></i>Submit for Review
                        </button>
                        <button type="button" class="btn flex-fill" 
                            style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: 2px solid rgba(16, 185, 129, 0.2); font-weight: 600;"
                            onmouseover="this.style.background='rgba(16, 185, 129, 0.15)'"
                            onmouseout="this.style.background='rgba(16, 185, 129, 0.1)'">
                            <i class="fas fa-check-double me-2"></i>Approve
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Meeting Details -->
        <div class="col-lg-4">
            <!-- Meeting Details Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-secondary"></i>Meeting Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Scheduled</label>
                        <div class="fw-semibold">
                            <i class="fas fa-calendar me-1" style="color: #8b5cf6;"></i>
                            {{ $meeting->scheduled_at->format('M d, Y') }}
                        </div>
                        <div class="fw-semibold">
                            <i class="fas fa-clock me-1" style="color: #8b5cf6;"></i>
                            {{ $meeting->scheduled_at->format('H:i') }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="text-muted small">Location</label>
                        <div class="fw-semibold">
                            <i class="fas fa-map-marker-alt me-1" style="color: #8b5cf6;"></i>
                            {{ $meeting->location ?? 'No location specified' }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="text-muted small">Organizer</label>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center me-2" 
                                style="width: 32px; height: 32px;">
                                <small class="text-white fw-bold">{{ strtoupper(substr($meeting->organizer->name, 0, 1)) }}</small>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $meeting->organizer->name }}</div>
                                <small class="text-muted">{{ $meeting->organizer->email }}</small>
                            </div>
                        </div>
                    </div>
                    
                    @if($meeting->project)
                    <div class="mb-3">
                        <label class="text-muted small">Project</label>
                        <div class="fw-semibold">
                            <i class="fas fa-project-diagram me-1" style="color: #8b5cf6;"></i>
                            {{ $meeting->project->name }}
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="text-muted small">Created</label>
                        <div class="fw-semibold">{{ $meeting->created_at->format('M d, Y') }}</div>
                        <small class="text-muted">{{ $meeting->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Edit Meeting
                        </a>
                        <button class="btn btn-outline-success" disabled>
                            <i class="fas fa-file-export me-2"></i>Export Minutes
                        </button>
                        <button class="btn btn-outline-info" disabled>
                            <i class="fas fa-share me-2"></i>Share Meeting
                        </button>
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
function toggleAgendaForm() {
    const form = document.getElementById('agendaForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function toggleRiskForm() {
    const form = document.getElementById('riskForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

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