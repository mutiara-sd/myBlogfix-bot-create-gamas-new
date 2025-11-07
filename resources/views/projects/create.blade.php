<x-layout>
<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Projects
        </a>
    </div>

    <!-- Header Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <!-- Card Header -->
                <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #6f42c1 0%, #8a2be2 100%);">
                    <i class="fas fa-plus-circle fa-3x mb-3"></i>
                    <h2 class="mb-2">Create New Project</h2>
                    <p class="mb-0 opacity-75">Turn your ideas into organized, trackable projects</p>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">
                    <form action="{{ route('projects.store') }}" method="POST" id="projectForm">
                        @csrf
                        
                        <!-- Project Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-project-diagram me-2" style="color: #6f42c1;"></i>
                                Project Name <span class="text-danger">*</span>
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
                                <i class="fas fa-align-left me-2" style="color: #6f42c1;"></i>
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
                                <i class="fas fa-toggle-on me-2" style="color: #6f42c1;"></i>
                                Initial Status <span class="text-danger">*</span>
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

                        <!-- Project Code Preview -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-code me-2" style="color: #6f42c1;"></i>
                                Project Code (Auto-generated)
                            </label>
                            <div class="alert alert-info border-0" style="background-color: #f0f4ff;">
                                <p class="text-muted mb-2 small">Your project code will be:</p>
                                <p id="codePreview" class="fw-bold text-center mb-2" style="font-family: monospace; font-size: 1.5rem; color: #6f42c1;">
                                    PROJ001
                                </p>
                                <small class="text-muted d-block text-center">Generated automatically from your project name</small>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary flex-fill" style="background: #6f42c1; border-color: #6f42c1;">
                                <i class="fas fa-rocket me-2"></i>Create Project
                            </button>
                            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary flex-fill">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card border-success mt-4" style="background-color: #f0fff4;">
                <div class="card-body">
                    <h6 class="text-success fw-bold mb-3">
                        <i class="fas fa-lightbulb me-2"></i>Tips for Success
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Use clear, descriptive names
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Define specific goals
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Start with "Active" status
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    You can edit later
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const codePreview = document.getElementById('codePreview');
    const form = document.getElementById('projectForm');
    
    function generateCodePreview(name) {
        if (!name) {
            codePreview.textContent = 'PROJ001';
            return;
        }
        
        const baseCode = name.replace(/[^A-Za-z0-9]/g, '').toUpperCase().substring(0, 6);
        const code = baseCode.length >= 3 ? baseCode : 'PROJ';
        codePreview.textContent = code + '001';
    }
    
    nameInput.addEventListener('input', function() {
        generateCodePreview(this.value);
    });
    
    generateCodePreview(nameInput.value);
    
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