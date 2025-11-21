<x-layout>
<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('meetings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Meetings
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="row justify-content-center">
        <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i style="color: #8b5cf6;"></i>Create New Meeting
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('meetings.store') }}" method="POST" id="meetingForm">
                        @csrf
                        
                        <!-- Project -->
                        <div class="mb-4">
                            <label for="project_id" class="form-label fw-semibold">
                                <i style="color: #8b5cf6;"></i>
                                Project <span class="text-danger"></span>
                            </label>
                            <select name="project_id" 
                                    id="project_id"
                                    class="form-select @error('project_id') is-invalid @enderror" 
                                    required>
                                <option value="">-- Select Project --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
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
                                <i style="color: #8b5cf6;"></i>
                                Meeting Title <span class="text-danger"></span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="e.g., Sprint Planning, Client Review, Team Standup"
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
                                    <i style="color: #8b5cf6;"></i>
                                    Date & Time <span class="text-danger"></span>
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('scheduled_at') is-invalid @enderror" 
                                       id="scheduled_at" 
                                       name="scheduled_at" 
                                       value="{{ old('scheduled_at') }}"
                                       required>
                                @error('scheduled_at')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold">
                                    <i style="color: #8b5cf6;"></i>
                                    Location
                                </label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location') }}"
                                       placeholder="e.g., Conference Room A, Zoom, Google Meet">
                                @error('location')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Optional: Specify where the meeting will take place
                                </small>
                            </div>
                        </div>

                        <!-- Organizer + Status Row -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="organizer_id" class="form-label fw-semibold">
                                    <i style="color: #8b5cf6;"></i>
                                    Organizer <span class="text-danger"></span>
                                </label>
                                <select name="organizer_id" 
                                        id="organizer_id"
                                        class="form-select @error('organizer_id') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Select Organizer --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('organizer_id') == $user->id ? 'selected' : '' }}>
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
                                    <i style="color: #8b5cf6;"></i>
                                    Initial Status
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status">
                                    <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                                        Draft - Meeting scheduled
                                    </option>
                                    <option value="done" {{ old('status') === 'done' ? 'selected' : '' }}>
                                        Done - Meeting completed
                                    </option>
                                    <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>
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

                        <!-- Form Actions -->
                        <div class="d-flex gap-2 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary flex-fill" style="background: #8b5cf6; border-color: #8b5cf6;">
                                Create Meeting
                            </button>
                            <a href="{{ route('meetings.index') }}" class="btn btn-outline-secondary flex-fill">
                                Cancel
                            </a>
                        </div>
                    </form>
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
    const form = document.getElementById('meetingForm');
    
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