<x-layout>
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-dark fw-bold mb-1">Create New Task</h1>
                    <p class="text-muted mb-0">Fill in the details to create a new task</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        @if(isset($selectedProjectId))
            <input type="hidden" name="from_project" value="1">
        @endif

        <div class="row">
            <!-- Main Form -->
            <div class="row justify-content-center">
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
                                Task Title <span class="text-danger"></span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Enter task title"
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
                                      rows="5"
                                      placeholder="Describe the task in detail...">{{ old('description') }}</textarea>
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
                                    <option value="">Select a project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" 
                                                {{ old('project_id', $selectedProjectId ?? '') == $project->id ? 'selected' : '' }}>
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
                                        <option value="{{ $user->id }}" {{ old('assignee_id') == $user->id ? 'selected' : '' }}>
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
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="med" {{ old('priority', 'med') == 'med' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
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
                                    <option value="todo" {{ old('status', 'todo') == 'todo' ? 'selected' : '' }}>To Do</option>
                                    <option value="doing" {{ old('status') == 'doing' ? 'selected' : '' }}>Doing</option>
                                    <option value="review" {{ old('status') == 'review' ? 'selected' : '' }}>Review</option>
                                    <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Done</option>
                                    <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
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
                                       value="{{ old('due_date') }}">
                                @error('due_date')
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
                                                   {{ in_array($label->id, old('labels', [])) ? 'checked' : '' }}>
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

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ isset($selectedProjectId) ? route('projects.show', $selectedProjectId) : route('tasks.index') }}" 
                               class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" style="background: #6f42c1; border-color: #6f42c1;">
                                Create Task
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
#status {
    display: block !important;
}
</style>

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
</x-layout>