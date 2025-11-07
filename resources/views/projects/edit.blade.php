<x-layout>
@section('title', 'Edit Project - ' . $project->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-secondary me-3">
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
                        <i class="fas fa-edit me-2" style="color: #6f42c1;"></i>Project Information
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('projects.update', $project) }}" method="POST" id="editProjectForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Project Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-project-diagram me-2 text-primary"></i>Project Name *
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
                                <i class="fas fa-align-left me-2 text-info"></i>Description
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
                                <i class="fas fa-toggle-on me-2 text-success"></i>Project Status *
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
                                <i class="fas fa-code me-2 text-warning"></i>Project Code
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
                                <i class="fas fa-save me-2"></i>Update Project
                            </button>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Project Stats -->
            <div class="mt-4">
                <div class="card border-0" style="background: linear-gradient(135deg, #f8f9ff 0%, #e3f2fd 100%);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: #6f42c1;">
                            <i class="fas fa-chart-bar me-2"></i>Current Project Statistics
                        </h6>
                        <div class="row text-center">
                            <div class="col-3">
                                <div class="fw-bold h5 mb-1">{{ $project->tasks()->count() }}</div>
                                <small class="text-muted">Total Tasks</small>
                            </div>
                            <div class="col-3">
                                <div class="fw-bold h5 mb-1">{{ $project->meetings()->count() }}</div>
                                <small class="text-muted">Meetings</small>
                            </div>
                            <div class="col-3">
                                <div class="fw-bold h5 mb-1">{{ $project->progress }}%</div>
                                <small class="text-muted">Progress</small>
                            </div>
                            <div class="col-3">
                                <div class="fw-bold h5 mb-1">{{ $project->created_at->diffInDays() }}</div>
                                <small class="text-muted">Days Old</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</x-layout>



