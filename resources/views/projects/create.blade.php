<x-layout>
<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Projects
        </a>
    </div>

                <!-- Card Body -->
                <div class="card-body p-4">
                    <form action="{{ route('projects.store') }}" method="POST" id="projectForm">
                        @csrf
                        
                        <!-- Project Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                </i>Project Name 
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                placeholder="e.g., Website Redesign, Mobile App Development"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                </i>
                                Project Description
                            </label>
                            <textarea 
                                class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="4"
                                placeholder="Describe your project goals, scope, and key deliverables..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Optional: Help your team understand the project's purpose
                            </small>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">
                                </i>Initial Status
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Choose initial status</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }} selected>
                                    Active - Ready to start working
                                </option>
                                <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>
                                    Archived - Store for later
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary flex-fill" style="background: #6f42c1; border-color: #6f42c1;">
                                </i>Create Project
                            </button>
                            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary flex-fill">
                                </i>Cancel
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
    const nameInput = document.getElementById('name');
    const form = document.getElementById('projectForm');
    
    form.addEventListener('submit', function(e) {
        const name = nameInput.value.trim();
        
        if (name.length < 3) {
            e.preventDefault();
            nameInput.focus();
            nameInput.classList.add('is-invalid');
            return false;
        }
    });
    
    nameInput.addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
});
</script>
</x-layout>