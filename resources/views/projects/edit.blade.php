<x-layout>
<div class="container-fluid">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('projects.index', $project) }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left me-1"></i>Back
                </a>
                <div>
                    <h2 class="text-dark fw-bold mb-1">Edit Project</h2>
                    <p class="text-muted mb-0">Update project information below</p>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        </i>Project Information
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('projects.update', $project) }}" method="POST" id="editProjectForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Project Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                </i>Project Name 
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $project->name) }}"
                                   placeholder="Enter project name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Project Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                </i>Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5"
                                      placeholder="Describe your project goals, scope, and key deliverables...">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Project Status -->
                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">
                                </i>Project Status 
                            </label>
                            <select class="form-select form-select-lg @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">Choose project status</option>
                                <option value="active" {{ old('status', $project->status) === 'active' ? 'selected' : '' }}>
                                    Active - Project is currently active
                                </option>
                                <option value="archived" {{ old('status', $project->status) === 'archived' ? 'selected' : '' }}>
                                    Archived - Project is archived
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Project Code (Read-only) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                </i>Project Code
                            </label>
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex align-items-center">
                                    <code class="fw-bold" style="color: #6f42c1; font-size: 1.1em;">{{ $project->code }}</code>
                                    <span class="ms-2 text-muted">This code cannot be changed</span>
                                </div>
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
                                        <div class="fw-semibold">{{ $project->created_at->format('M d, Y H:i') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <small class="text-muted d-block">Last Updated</small>
                                        <div class="fw-semibold">{{ $project->updated_at->format('M d, Y H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-3 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg flex-fill" style="background:#6f42c1; border-color:#6f42c1;">
                                </i>Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>

</x-layout>



