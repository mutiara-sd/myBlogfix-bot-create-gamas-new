<x-layout>
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-dark fw-bold mb-1">Edit Task</h1>
                    <p class="text-muted mb-0">Update task details</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-tasks me-2" style="color: #6f42c1;"></i>Task Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                Task Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $task->title) }}"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Project & Assignee Row -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="project_id" class="form-label fw-semibold">
                                    Project <span class="text-danger"></span>
                                </label>
                                <select class="form-select @error('project_id') is-invalid @enderror" 
                                        id="project_id" 
                                        name="project_id" 
                                        required>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" 
                                                {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }} ({{ $project->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="assignee_id" class="form-label fw-semibold">Assignee</label>
                                <select class="form-select @error('assignee_id') is-invalid @enderror" 
                                        id="assignee_id" 
                                        name="assignee_id">
                                    <option value="">Unassigned</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assignee_id', $task->assignee_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('assignee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Priority, Status & Due Date Row -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="priority" class="form-label fw-semibold">
                                    Priority <span class="text-danger"></span>
                                </label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" 
                                        name="priority" 
                                        required>
                                    <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="med" {{ old('priority', $task->priority) == 'med' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ old('priority', $task->priority) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold">
                                    Status <span class="text-danger"></span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="todo" {{ old('status', $task->status) == 'todo' ? 'selected' : '' }}>To Do</option>
                                    <option value="doing" {{ old('status', $task->status) == 'doing' ? 'selected' : '' }}>Doing</option>
                                    <option value="review" {{ old('status', $task->status) == 'review' ? 'selected' : '' }}>Review</option>
                                    <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Done</option>
                                    <option value="blocked" {{ old('status', $task->status) == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="due_date" class="form-label fw-semibold">Due Date</label>
                                <input type="date" 
                                       class="form-control @error('due_date') is-invalid @enderror" 
                                       id="due_date" 
                                       name="due_date"
                                       value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Progress & Weight Row -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="progress_percent" class="form-label fw-semibold">Progress (%)</label>
                                <input type="number" 
                                       class="form-control @error('progress_percent') is-invalid @enderror" 
                                       id="progress_percent" 
                                       name="progress_percent" 
                                       min="0" 
                                       max="100"
                                       value="{{ old('progress_percent', $task->progress_percent) }}">
                                @error('progress_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="weight" class="form-label fw-semibold">
                                    Task Weight/Complexity (1-5)
                                </label>
                                <input type="number" 
                                       class="form-control @error('weight') is-invalid @enderror" 
                                       id="weight" 
                                       name="weight" 
                                       min="1" 
                                       max="5"
                                       value="{{ old('weight', $task->weight) }}">
                                <small class="text-muted">Rate the complexity from 1 (simple) to 5 (very complex)</small>
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Labels -->
                        @if($labels->count() > 0)
                            <div class="mb-0">
                                <label class="form-label fw-semibold d-block mb-3">Labels</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($labels as $label)
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="labels[]" 
                                                   value="{{ $label->id }}" 
                                                   id="label{{ $label->id }}"
                                                   {{ in_array($label->id, old('labels', $task->labels->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="label{{ $label->id }}">
                                                <span class="badge" style="background-color: {{ $label->color }};">
                                                    {{ $label->name }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Current Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2 text-info"></i>Current Info
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small">Created</label>
                            <div class="fw-semibold">{{ $task->created_at->format('M d, Y H:i') }}</div>
                            <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Last Updated</label>
                            <div class="fw-semibold">{{ $task->updated_at->format('M d, Y H:i') }}</div>
                            <small class="text-muted">{{ $task->updated_at->diffForHumans() }}</small>
                        </div>
                        <div class="mb-0">
                            <label class="text-muted small">Project</label>
                            <div class="fw-semibold">{{ $task->project->name }}</div>
                            <small class="text-muted">{{ $task->project->code }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" style="background: #6f42c1; border-color: #6f42c1;">
                                <i class="fas fa-save me-2"></i>Update Task
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.card {
    transition: all 0.2s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: #6f42c1;
    box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
}

.form-check-input:checked {
    background-color: #6f42c1;
    border-color: #6f42c1;
}
</style>

<style>
#status {
    display: block !important;
}
</style>
</x-layout>