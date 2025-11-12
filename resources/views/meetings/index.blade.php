<x-layout>
<style>
    .btn-new-meeting {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-new-meeting:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
        color: white;
        text-decoration: none;
    }

    /* Custom Side Modal untuk New Meeting */
    .side-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .side-modal.active {
        opacity: 1;
        visibility: visible;
    }

    .side-modal-content {
        position: absolute;
        top: 0;
        right: 0;
        width: 500px;
        height: 100%;
        background: white;
        box-shadow: -10px 0 30px rgba(0, 0, 0, 0.2);
        transform: translateX(100%);
        transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        display: flex;
        flex-direction: column;
    }

    .side-modal.active .side-modal-content {
        transform: translateX(0);
    }

    .side-modal-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 25px 30px;
        flex-shrink: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .side-modal-title {
        font-weight: 700;
        color: #2d3748;
        margin: 0;
        font-size: 1.4rem;
    }

    .side-modal-close {
        background: rgba(107, 114, 128, 0.1);
        border: none;
        color: #6b7280;
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .side-modal-close:hover {
        background: rgba(107, 114, 128, 0.2);
        color: #374151;
    }

    .side-modal-body {
        padding: 30px;
        background: #fafbfc;
        flex: 1;
        overflow-y: auto;
        min-height: 0;
        max-height: calc(100vh - 160px);
    }

    /* Center Modal untuk Detail Meeting */
    .center-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(12px);
        z-index: 10000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .center-modal.active {
        opacity: 1;
        visibility: visible;
    }

    .center-modal-content {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 32px 80px rgba(0, 0, 0, 0.25);
        width: 100%;
        max-width: 900px;
        max-height: 95vh;
        overflow: hidden;
        transform: scale(0.85) translateY(40px);
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .center-modal.active .center-modal-content {
        transform: scale(1) translateY(0);
    }

    .center-modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #8b5cf6 100%);
        color: white;
        padding: 0;
        display: flex;
        align-items: stretch;
        position: relative;
        min-height: 120px;
        overflow: hidden;
    }

    .center-modal-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(120, 75, 162, 0.6) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(102, 126, 234, 0.6) 0%, transparent 50%);
        opacity: 0.7;
    }

    .meeting-header-left {
        flex: 1;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        z-index: 2;
    }

    .meeting-icon-large {
        background: rgba(255, 255, 255, 0.25);
        width: 64px;
        height: 64px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .center-modal-title {
        font-weight: 800;
        margin: 0;
        font-size: 1.8rem;
        position: relative;
        z-index: 2;
        line-height: 1.2;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1)
        color: #ffffff !important;
    }

    .meeting-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        margin-top: 8px;
        font-weight: 500;
    }

    .center-modal-close {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: white;
        cursor: pointer;
        padding: 12px;
        border-radius: 12px;
        transition: all 0.3s ease;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 3;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .center-modal-close:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: scale(1.05);
    }

    .center-modal-body {
        padding: 0;
        background: #f8fafc;
        flex: 1;
        overflow-y: auto;
        position: relative;
    }

    .meeting-content-wrapper {
        display: grid;
        grid-template-columns: 1fr 300px;
        min-height: 500px;
    }

    .meeting-main-content {
        padding: 40px;
        background: white;
    }

    .meeting-sidebar {
        background: linear-gradient(180deg, #f1f5f9 0%, #e2e8f0 100%);
        padding: 40px 30px;
        border-left: 1px solid #e2e8f0;
    }

    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        text-transform: capitalize;
        margin-bottom: 24px;
    }

    .status-indicator.draft {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .status-indicator.done {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-indicator.cancelled {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .info-group {
        margin-bottom: 32px;
    }

    .info-group h4 {
        color: #374151;
        font-size: 1rem;
        font-weight: 700;
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        color: #6b7280;
        font-size: 0.9rem;
    }

    .info-icon {
        width: 18px;
        height: 18px;
        color: #8b5cf6;
        flex-shrink: 0;
    }

    .about-section {
        background: #f8fafc;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
    }

    .about-section h4 {
        color: #374151;
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 12px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .about-section p {
        color: #6b7280;
        line-height: 1.6;
        margin: 0;
        font-size: 0.9rem;
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

    .edit-form-group {
        margin-bottom: 20px;
    }

    .edit-form-group label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .center-modal-footer {
        padding: 25px 30px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        background: white;
    }

    .mb-3 {
        margin-bottom: 25px;
    }

    .modal-body label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .modal-body label span[style*="color:red"] {
        color: #8b5cf6 !important;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }

    .form-control:hover {
        border-color: #c7d2fe;
    }

    .side-modal-footer {
        padding: 25px 30px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        background: white;
        flex-shrink: 0;
    }

    .btn-primary {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-1px);
    }

    .btn-success {
        background: #10b981;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .center-modal-content {
            margin: 10px;
            max-width: calc(100% - 20px);
        }
        
        .meeting-content-wrapper {
            grid-template-columns: 1fr;
        }
        
        .meeting-sidebar {
            border-left: none;
            border-top: 1px solid #e2e8f0;
        }
    }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    
    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h1 style="margin-bottom: 20px;">
            <i class="fas fa-users"></i> Meetings & Notulen
        </h1>
        
        <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 20px;">
            <span>Project:</span>
            <form method="GET" style="display: inline;">
                <select name="project_id" onchange="this.form.submit()" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">All Projects</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </form>
            
            <button type="button" 
                class="btn-new-meeting"
                onclick="openSideModal()">
                <i class="fas fa-plus"></i> New Meeting
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="background: #f8f9fa; padding: 20px; border-bottom: 1px solid #dee2e6;">
            <h2><i class="fas fa-calendar-alt"></i> Meeting List</h2>
        </div>
        
        @if($meetings->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px; padding: 20px;">
                @foreach($meetings as $meeting)
                    <div style="background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%); border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; color: #2d3748; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer;" 
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.12)'" 
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.08)'"
                         onclick="openCenterModal({{ $meeting->id }}, '{{ $meeting->title }}', '{{ $meeting->scheduled_at->format('Y-m-d\TH:i') }}', '{{ $meeting->location }}', '{{ $meeting->organizer_id }}', '{{ $meeting->organizer->name }}', '{{ $meeting->status }}', {{ $meeting->project_id }}, '{{ $meeting->project ? $meeting->project->name : '' }}', '{{ $meeting->scheduled_at->format('M d, Y') }}', '{{ $meeting->scheduled_at->format('H:i') }}')">
                        
                        <!-- Status Badge -->
                        <div style="position: absolute; top: 15px; right: 15px;">
                            <span style="padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase;
                                @if($meeting->status == 'draft') background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid #ffc107; @endif
                                @if($meeting->status == 'done') background: rgba(40, 167, 69, 0.2); color: #28a745; border: 1px solid #28a745; @endif
                                @if($meeting->status == 'cancelled') background: rgba(220, 53, 69, 0.2); color: #dc3545; border: 1px solid #dc3545; @endif">
                                {{ $meeting->status }}
                            </span>
                        </div>

                        <!-- Meeting Icon -->
                        <div style="margin-bottom: 15px;">
                            <div style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                                <i class="fas fa-users" style="color: white; font-size: 20px;"></i>
                            </div>
                        </div>

                        <!-- Meeting Title -->
                        <h3 style="margin: 0 0 8px 0; font-size: 1.2rem; font-weight: 600; color: #2d3748; line-height: 1.4;">
                            {{ $meeting->title }}
                        </h3>

                        <!-- Meeting Info -->
                        <div style="margin-bottom: 15px; color: #64748b; font-size: 0.9rem;">
                            <div style="margin-bottom: 8px;">
                                <i class="fas fa-calendar" style="margin-right: 8px; color: #8b5cf6;"></i>
                                {{ $meeting->scheduled_at->format('M d, Y') }}
                            </div>
                            <div style="margin-bottom: 8px;">
                                <i class="fas fa-clock" style="margin-right: 8px; color: #8b5cf6;"></i>
                                {{ $meeting->scheduled_at->format('H:i') }}
                            </div>
                            <div style="margin-bottom: 8px;">
                                <i class="fas fa-map-marker-alt" style="margin-right: 8px; color: #8b5cf6;"></i>
                                {{ $meeting->location ?? 'No location specified' }}
                            </div>
                            <div>
                                <i class="fas fa-user-tie" style="margin-right: 8px; color: #8b5cf6;"></i>
                                {{ $meeting->organizer->name }}
                            </div>
                        </div>

                        <!-- Actions -->
                        <div style="display: flex; gap: 10px; margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                            
                            <button type="button" onclick="event.stopPropagation(); showDeleteConfirmation('{{ $meeting->title }}', '{{ route('meetings.destroy', $meeting) }}')"
                                    style="background: #ef4444; color: white; padding: 8px 12px; border-radius: 8px; border: none; cursor: pointer; font-size: 0.85rem; font-weight: 500; transition: all 0.3s ease; display: flex; align-items: center; gap: 5px;"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>

                        
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px;">
                <i class="fas fa-calendar-times" style="font-size: 48px; opacity: 0.5; margin-bottom: 20px;"></i>
                <h3>No meetings found</h3>
                <p style="color: #6c757d; margin-top: 10px;">Create your first meeting to get started!</p>
            </div>
        @endif
    </div>
</div>

<!-- SIDE MODAL untuk New Meeting -->
<div class="side-modal" id="sideModal">
    <div class="side-modal-content">
        <div class="side-modal-header">
            <h5 class="side-modal-title">Create New Meeting</h5>
            <button type="button" class="side-modal-close" onclick="closeSideModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="meetingForm" action="{{ route('meetings.store') }}" method="POST">
            @csrf
            <div class="side-modal-body">
                <!-- Project -->
                <div class="mb-3">
                    <label>Project <span style="color:red">*</span></label>
                    <select name="project_id" class="form-control" required>
                        <option value="">-- Select Project --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Title -->
                <div class="mb-3">
                    <label>Meeting Title <span style="color:red">*</span></label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <!-- Scheduled At -->
                <div class="mb-3">
                    <label>Date & Time <span style="color:red">*</span></label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" required>
                </div>

                <!-- Location -->
                <div class="mb-3">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control">
                </div>

                <!-- Organizer -->
                <div class="mb-3">
                    <label>Organizer <span style="color:red">*</span></label>
                    <select name="organizer_id" class="form-control" required>
                        <option value="">-- Select Organizer --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="draft" selected>Draft</option>
                        <option value="done">Done</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <divaria-busy="" class="side-modal-footer">
                <button type="button" class="btn-secondary" onclick="closeSideModal()">Cancel</button>
                <button type="submit" class="btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>

<!-- CENTER MODAL untuk Detail/Edit Meeting -->
<div class="center-modal" id="centerModal">
    <div class="center-modal-content">
        <div class="center-modal-header">
            <div class="meeting-header-left">
                <h5 class="center-modal-title" id="centerModalTitle" style="color: #ffffff !important;">Meeting Details</h5>
                <div class="meeting-subtitle" id="centerModalSubtitle">Project Meeting</div>
            </div>
            <button type="button" class="center-modal-close" onclick="closeCenterModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="center-modal-body">
            <!-- Detail View -->
            <div id="detailView">
                <div class="meeting-content-wrapper">
                    <div class="meeting-main-content">
                        <div class="notulen-section">
                            <h4 style="margin-bottom: 20px; color: #374151; font-weight: 700;">
                                <i class="fas fa-clipboard-list"></i>
                                Meeting Minutes
                            </h4>
                            
                            @foreach($meetings as $mtg)
                                <div id="meetingMinutes-{{ $mtg->id }}" style="display: none;">
                                    @include('meetings.partials.agenda_decision', ['meeting' => $mtg])
                                </div>
                            @endforeach

                            <!-- Action Items Section -->
                            <div class="notulen-group">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                    <h5 style="margin: 0; color: #4b5563; font-weight: 600;">Action Items (<span style="color: #3b82f6;">→ Tasks</span>)</h5>
                                    <button type="button" class="btn-add-task" onclick="addTask()" style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer;">
                                        <i class="fas fa-plus"></i> Add Task
                                    </button>
                                </div>
                                <div id="actionItems">
                                    <div class="action-item" style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #f8fafc; border-radius: 8px; margin-bottom: 10px;">
                                        <input type="checkbox" disabled style="margin: 0;">
                                        <span style="flex: 1; color: #374151;">Implement feature Y</span>
                                        <span style="background: #3b82f6; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px;">@ani</span>
                                        <div style="display: flex; align-items: center; gap: 10px; font-size: 12px; color: #6b7280;">
                                            <div style="display: flex; align-items: center; gap: 3px;">
                                                <i class="fas fa-plus"></i>
                                                <span>Due: 2025-09-15</span>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 3px;">
                                                <i class="fas fa-calendar"></i>
                                                <span>Due: 99-15</span>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 3px;">
                                                <i class="fas fa-user"></i>
                                                <span>@ani</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="meeting-sidebar">
                        <div class="status-indicator" id="statusIndicator">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: currentColor;"></div>
                            <span id="statusText">Draft</span>
                        </div>
                        
                        <div class="info-group">
                            <h4><i class="fas fa-calendar-alt"></i> Schedule</h4>
                            <div class="info-item">
                                <i class="fas fa-calendar info-icon"></i>
                                <span id="detailDate">-</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-clock info-icon"></i>
                                <span id="detailTime">-</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt info-icon"></i>
                                <span id="detailLocation">-</span>
                            </div>
                        </div>
                        
                        <div class="info-group">
                            <h4><i class="fas fa-users-cog"></i> Details</h4>
                            <div class="info-item">
                                <i class="fas fa-user-tie info-icon"></i>
                                <span id="detailOrganizer">-</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-project-diagram info-icon"></i>
                                <span id="detailProject">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div id="editView" style="display: none;">
                <div class="meeting-content-wrapper" style="grid-template-columns: 1fr;">
                    <div class="meeting-main-content">
                        <form id="editMeetingForm" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                <div class="edit-form-group">
                                    <label>Project <span style="color:#8b5cf6">*</span></label>
                                    <select name="project_id" id="editProjectId" class="form-control" required>
                                        <option value="">-- Select Project --</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="edit-form-group">
                                    <label>Status</label>
                                    <select name="status" id="editStatus" class="form-control">
                                        <option value="draft">Draft</option>
                                        <option value="done">Done</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>

                            <div class="edit-form-group">
                                <label>Meeting Title <span style="color:#8b5cf6">*</span></label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                <div class="edit-form-group">
                                    <label>Date & Time <span style="color:#8b5cf6">*</span></label>
                                    <input type="datetime-local" name="scheduled_at" id="editScheduledAt" class="form-control" required>
                                </div>

                                <div class="edit-form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" id="editLocation" class="form-control">
                                </div>
                            </div>

                            <div class="edit-form-group">
                                <label>Organizer <span style="color:#8b5cf6">*</span></label>
                                <select name="organizer_id" id="editOrganizerId" class="form-control" required>
                                    <option value="">-- Select Organizer --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="center-modal-footer">
            <button type="button" class="btn-secondary" onclick="closeCenterModal()">Close</button>
            <button type="button" id="editToggleBtn" class="btn-success" onclick="toggleEditMode()">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button type="submit" id="saveBtn" class="btn-primary" style="display: none;" onclick="saveMeeting()">
                <i class="fas fa-save"></i> Save
            </button>
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

<script>
let isEditMode = false;
let currentMeetingId = null;
let deleteFormAction = '';

// Side Modal Functions (untuk New Meeting)
function openSideModal() {
    document.getElementById('meetingForm').reset();
    document.getElementById('sideModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeSideModal() {
    document.getElementById('sideModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Center Modal Functions (untuk Detail/Edit Meeting)
function openCenterModal(id, title, scheduledAt, location, organizerId, organizerName, status, projectId, projectName, dateFormatted, timeFormatted) {
    currentMeetingId = id;
    isEditMode = false;
    
    // Set modal title
    document.getElementById('centerModalTitle').textContent = title;
    document.getElementById('centerModalSubtitle').textContent = projectName || 'No project assigned';
    
    // Fill detail view
    document.getElementById('detailProject').textContent = projectName || 'No project assigned';
    document.getElementById('detailDate').textContent = dateFormatted;
    document.getElementById('detailTime').textContent = timeFormatted;
    document.getElementById('detailLocation').textContent = location || 'No location specified';
    document.getElementById('detailOrganizer').textContent = organizerName;
    
    // Set status indicator
    const statusIndicator = document.getElementById('statusIndicator');
    const statusText = document.getElementById('statusText');
    statusText.textContent = status.charAt(0).toUpperCase() + status.slice(1);
    statusIndicator.className = 'status-indicator ' + status;
    
    // Fill edit form (hidden initially)
    document.getElementById('editProjectId').value = projectId;
    document.getElementById('editTitle').value = title;
    document.getElementById('editScheduledAt').value = scheduledAt;
    document.getElementById('editLocation').value = location || '';
    document.getElementById('editOrganizerId').value = organizerId;
    document.getElementById('editStatus').value = status;
    
    // Set form action
    document.getElementById('editMeetingForm').action = `/meetings/${id}`;

    // Set form action
    document.getElementById('editMeetingForm').action = `/meetings/${id}`;

    // Sembunyikan semua meeting minutes
    document.querySelectorAll('[id^="meetingMinutes-"]').forEach(el => el.style.display = 'none');

    // Tampilkan meeting yang diklik
    document.getElementById('meetingMinutes-' + id).style.display = 'block';
    
    // Show modal
    document.getElementById('centerModal').classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Reset to detail view
    showDetailView();
}

function closeCenterModal() {
    document.getElementById('centerModal').classList.remove('active');
    document.body.style.overflow = 'auto';
    isEditMode = false;
    showDetailView();
}

function toggleEditMode() {
    isEditMode = !isEditMode;
    
    if (isEditMode) {
        showEditView();
    } else {
        showDetailView();
    }
}

function showDetailView() {
    document.getElementById('detailView').style.display = 'block';
    document.getElementById('editView').style.display = 'none';
    document.getElementById('editToggleBtn').style.display = 'inline-block';
    document.getElementById('saveBtn').style.display = 'none';
    document.getElementById('editToggleBtn').innerHTML = '<i class="fas fa-edit"></i> Edit';
    isEditMode = false;
}

function showEditView() {
    document.getElementById('detailView').style.display = 'none';
    document.getElementById('editView').style.display = 'block';
    document.getElementById('editToggleBtn').style.display = 'inline-block';
    document.getElementById('saveBtn').style.display = 'inline-block';
    document.getElementById('editToggleBtn').innerHTML = '<i class="fas fa-eye"></i> View';
    isEditMode = true;
}

function saveMeeting() {
    document.getElementById('editMeetingForm').submit();
}

// Delete Confirmation Functions
function showDeleteConfirmation(meetingTitle, formAction) {
    document.getElementById('deleteModalMeetingTitle').textContent = meetingTitle;
    deleteFormAction = formAction;
    document.getElementById('deleteModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

function confirmDelete() {
    // Create and submit form
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = deleteFormAction;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    
    form.appendChild(csrfToken);
    form.appendChild(methodField);
    
    document.body.appendChild(form);
    form.submit();
}

// Variables untuk agenda & decision delete
let deleteAgendaFormAction = '';
let deleteDecisionFormAction = '';

// ========== AGENDA DELETE FUNCTIONS ==========
function showDeleteAgendaConfirmation(agendaText, formAction) {
    document.getElementById('deleteAgendaText').textContent = agendaText;
    deleteAgendaFormAction = formAction;
    document.getElementById('deleteAgendaModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteAgendaModal() {
    document.getElementById('deleteAgendaModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

function confirmDeleteAgenda() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = deleteAgendaFormAction;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    
    form.appendChild(csrfToken);
    form.appendChild(methodField);
    
    document.body.appendChild(form);
    form.submit();
}

// ========== DECISION DELETE FUNCTIONS ==========
function showDeleteDecisionConfirmation(decisionText, formAction) {
    document.getElementById('deleteDecisionText').textContent = decisionText;
    deleteDecisionFormAction = formAction;
    document.getElementById('deleteDecisionModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteDecisionModal() {
    document.getElementById('deleteDecisionModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

function confirmDeleteDecision() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = deleteDecisionFormAction;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    
    form.appendChild(csrfToken);
    form.appendChild(methodField);
    
    document.body.appendChild(form);
    form.submit();
}

// Close modals when clicking outside
document.getElementById('sideModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSideModal();
    }
});

document.getElementById('centerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCenterModal();
    }
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.getElementById('deleteAgendaModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteAgendaModal();
    }
});

document.getElementById('deleteDecisionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteDecisionModal();
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (document.getElementById('deleteAgendaModal')?.classList.contains('active')) {
            closeDeleteAgendaModal();
        } else if (document.getElementById('deleteDecisionModal')?.classList.contains('active')) {
            closeDeleteDecisionModal();
        } else if (document.getElementById('deleteModal').classList.contains('active')) {
            closeDeleteModal();
        } else if (document.getElementById('centerModal').classList.contains('active')) {
            closeCenterModal();
        } else if (document.getElementById('sideModal').classList.contains('active')) {
            closeSideModal();
        }
    }
});
</script>

</x-layout>