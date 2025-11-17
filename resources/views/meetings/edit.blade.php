<x-layout>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('meetings.show', $meeting) }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-dark fw-bold mb-1">Edit Meeting</h2>
            <p class="text-muted mb-0">Update meeting information below</p>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2" style="color: #8b5cf6;"></i>Meeting Information
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('meetings.update', $meeting) }}" method="POST" id="editMeetingForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Project -->
                        <div class="mb-4">
                            <label for="project_id" class="form-label fw-semibold">
                                <i class="fas fa-project-diagram me-1" style="color: #8b5cf6;"></i>
                                Project <span class="text-danger">*</span>
                            </label>
                            <select name="project_id" 
                                    id="project_id"
                                    class="form-select form-select-lg @error('project_id') is-invalid @enderror" 
                                    required>
                                <option value="">-- Select Project --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" 
                                        {{ old('project_id', $meeting->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Meeting Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                <i class="fas fa-heading me-1" style="color: #8b5cf6;"></i>
                                Meeting Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $meeting->title) }}"
                                   placeholder="Enter meeting title"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Date & Time + Location Row -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="scheduled_at" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1" style="color: #8b5cf6;"></i>
                                    Date & Time <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('scheduled_at') is-invalid @enderror" 
                                       id="scheduled_at" 
                                       name="scheduled_at" 
                                       value="{{ old('scheduled_at', $meeting->scheduled_at->format('Y-m-d\TH:i')) }}"
                                       required>
                                @error('scheduled_at')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold">
                                    <i class="fas fa-map-marker-alt me-1" style="color: #8b5cf6;"></i>
                                    Location
                                </label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location', $meeting->location) }}"
                                       placeholder="e.g., Conference Room A, Zoom">
                                @error('location')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Organizer + Status Row -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="organizer_id" class="form-label fw-semibold">
                                    <i class="fas fa-user-tie me-1" style="color: #8b5cf6;"></i>
                                    Organizer <span class="text-danger">*</span>
                                </label>
                                <select name="organizer_id" 
                                        id="organizer_id"
                                        class="form-select form-select-lg @error('organizer_id') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Select Organizer --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" 
                                            {{ old('organizer_id', $meeting->organizer_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('organizer_id')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">
                                    <i class="fas fa-flag me-1" style="color: #8b5cf6;"></i>
                                    Meeting Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="">Choose meeting status</option>
                                    <option value="draft" {{ old('status', $meeting->status) === 'draft' ? 'selected' : '' }}>
                                        Draft - Meeting scheduled
                                    </option>
                                    <option value="done" {{ old('status', $meeting->status) === 'done' ? 'selected' : '' }}>
                                        Done - Meeting completed
                                    </option>
                                    <option value="cancelled" {{ old('status', $meeting->status) === 'cancelled' ? 'selected' : '' }}>
                                        Cancelled - Meeting cancelled
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-info-circle me-2 text-secondary"></i>Additional Information
                            </label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <small class="text-muted d-block">Created</small>
                                        <div class="fw-semibold">{{ $meeting->created_at->format('M d, Y H:i') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <small class="text-muted d-block">Last Updated</small>
                                        <div class="fw-semibold">{{ $meeting->updated_at->format('M d, Y H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-3 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg flex-fill" style="background:#8b5cf6; border-color:#8b5cf6;">
                                <i class="fas fa-save me-2"></i>Update Meeting
                            </button>
                            <a href="{{ route('meetings.show', $meeting) }}" class="btn btn-outline-secondary btn-lg flex-fill">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#status {
    display: block !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editMeetingForm');
    
    form.addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        
        if (title.length < 3) {
            e.preventDefault();
            document.getElementById('title').focus();
            document.getElementById('title').classList.add('is-invalid');
            return false;
        }
    });
    
    // Remove invalid class on input
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
});
</script>
</x-layout>