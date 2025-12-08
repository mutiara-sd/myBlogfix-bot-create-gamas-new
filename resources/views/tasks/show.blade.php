<x-layout>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('projects.show', $task->project) }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="flex-grow-1">
                    <h1 class="text-dark fw-bold mb-2">{{ $task->title }}</h1>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <a href="{{ route('projects.show', $task->project) }}" class="text-decoration-none">
                            <span class="text-muted">
                                <i class="fas fa-folder me-1"></i>
                                {{ $task->project->name }} ({{ $task->project->code }})
                            </span>
                        </a>
                        
                        @php
                            $statusColors = [
                                'todo' => 'secondary',
                                'in_progress' => 'warning',
                                'review' => 'info',
                                'completed' => 'success',
                                'done' => 'success',
                                'blocked' => 'danger'
                            ];
                            $priorityColors = [
                                'urgent' => 'danger',
                                'high' => 'warning',
                                'med' => 'info',
                                'low' => 'secondary'
                            ];
                        @endphp
                        
                        <span class="badge bg-{{ $statusColors[$task->status] ?? 'secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                        
                        <span class="badge bg-{{ $priorityColors[$task->priority] ?? 'secondary' }}">
                            {{ ucfirst($task->priority) }} Priority
                        </span>

                        @foreach($task->labels as $label)
                            <span class="badge" style="background-color: {{ $label->color }};">
                                {{ $label->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="btn-group" role="group">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary border-2">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-primary dropdown-toggle border-0" 
                        data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button class="dropdown-item text-danger" 
                                    type="button"
                                    onclick="openDeleteModal({{ $task->id }}, '{{ $task->title }}')">
                                <i class="fas fa-trash me-2"></i>Delete Task
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

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8 mb-4">
            <!-- Task Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-align-left me-2 text-info"></i>Description
                    </h5>
                </div>
                <div class="card-body">
                    @if($task->description)
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $task->description }}</p>
                    @else
                        <p class="text-muted fst-italic mb-0">No description provided for this task.</p>
                    @endif
                </div>
            </div>

            <!-- Progress Updates -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2 text-primary"></i>Progress Updates
                        </h5>
                        <button class="btn btn-sm btn-outline-primary" onclick="document.getElementById('addProgressModal').style.display='flex'">
                            <i class="fas fa-plus me-1"></i>Add Update
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($task->progressUpdates->count() > 0)
                        <div class="timeline">
                            @foreach($task->progressUpdates as $update)
                                <div class="timeline-item">
                                    <div class="timeline-marker" style="background: #6f42c1;"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <strong>{{ $update->creator->name }}</strong>
                                                <span class="badge bg-primary ms-2">{{ $update->percent }}%</span>
                                            </div>
                                            <small class="text-muted">{{ $update->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if($update->note)
                                            <p class="mb-2">{{ $update->note }}</p>
                                        @endif
                                        @if($update->is_blocked)
                                            <span class="badge bg-danger">
                                                <i class="fas fa-exclamation-circle me-1"></i>Blocked
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-chart-line fa-2x mb-3"></i>
                            <p class="mb-0">No progress updates yet. Add the first update!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-comments me-2" style="color: #8b5cf6;"></i>Comments
                        </h5>
                        <span class="badge rounded-pill" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6; font-size: 0.85rem; padding: 6px 12px;">
                            {{ $task->comments->count() }} {{ Str::plural('comment', $task->comments->count()) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Comment Form -->
                    <form action="{{ route('tasks.comments.store', $task) }}" method="POST" enctype="multipart/form-data" class="mb-4" id="commentForm">
                        @csrf
                
                        <div class="d-flex gap-2 align-items-start p-3 rounded" style="background: white; border: 2px solid #e5e7eb;">
                            <!-- User Avatar -->
                            <div class="flex-shrink-0">
                                @if(Auth::user()->profile_picture)
                                    <img src="{{ filter_var(Auth::user()->profile_picture, FILTER_VALIDATE_URL) ? Auth::user()->profile_picture : asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e2e8f0;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(139, 92, 246, 0.1); color: #8b5cf6; font-weight: 600;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Input Area -->
                            <div class="flex-grow-1">
                                <textarea name="body" rows="2" placeholder="Add a comment..." required class="form-control border-0 p-0 mb-2" style="resize: none; font-size: 0.95rem; line-height: 1.5;" oninput="this.style.height = 'auto'; this.style.height = this.scrollHeight + 'px'"></textarea>
                                
                                <!-- File Preview Area -->
                                <div id="filePreview" style="display: none;" class="mb-2 p-2 rounded" style="background: #f9fafb; border: 1px dashed #d1d5db;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-paperclip text-muted"></i>
                                        <span id="fileName" class="text-muted small"></span>
                                        <span id="fileSize" class="badge bg-light text-dark"></span>
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-auto" onclick="removeFile()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <input type="file" name="attachment" id="commentAttachment" style="display: none;" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.gif,.zip,.rar" onchange="handleFileSelect(this)">
                                        <button type="button" class="btn btn-sm btn-link text-muted p-0" onclick="document.getElementById('commentAttachment').click()">
                                            <i class="fas fa-paperclip me-1"></i>Attach file
                                        </button>
                                        <small class="text-muted ms-2">(Max: 5MB)</small>
                                    </div>
                                    <button type="submit" class="btn btn-sm" style="background: #8b5cf6; color: white; padding: 6px 20px; border-radius: 20px; font-weight: 600;">
                                        <i class="fas fa-paper-plane me-1"></i>Post Comment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Comments List -->
                    @forelse ($task->comments as $comment)
                        <div class="comment-item d-flex gap-3 p-3 mb-3 rounded" style="background: white; border-left: 3px solid #8b5cf6; transition: all 0.2s;" onmouseover="this.style.boxShadow='0 2px 8px rgba(139, 92, 246, 0.15)'" onmouseout="this.style.boxShadow='none'">
                            
                            <!-- User Avatar -->
                            <div class="flex-shrink-0">
                                @if($comment->user->profile_picture)
                                    <img src="{{ filter_var($comment->user->profile_picture, FILTER_VALIDATE_URL) ? $comment->user->profile_picture : asset('storage/' . $comment->user->profile_picture) }}" alt="{{ $comment->user->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e2e8f0;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(139, 92, 246, 0.1); color: #8b5cf6; font-weight: 600;">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Comment Content -->
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong style="color: #2d3748; font-size: 0.95rem;">{{ $comment->user->name }}</strong>
                                        <small class="text-muted ms-2">
                                            <i class="fas fa-clock me-1"></i>{{ $comment->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    
                                    @if($comment->user_id === Auth::id())
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this comment?')" class="btn btn-sm rounded-circle" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; width: 28px; height: 28px; padding: 0; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'" title="Delete comment">
                                                <i class="fas fa-trash-alt" style="font-size: 11px;"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                
                                <!-- Comment Text -->
                                <p class="mb-2" style="color: #4b5563; line-height: 1.6; word-wrap: break-word; word-break: break-word; white-space: pre-wrap;">{{ $comment->body }}</p>
                                
                                <!-- Comment Attachment (if exists) -->
                                @if(isset($comment->attachment_path) && $comment->attachment_path)
                                    <div class="mt-2 p-2 rounded d-inline-flex align-items-center gap-2" style="background: rgba(99, 102, 241, 0.05); border: 1px solid rgba(99, 102, 241, 0.2);">
                                        <i class="fas fa-paperclip"></i>
                                        <a href="{{ route('comments.download', $comment) }}" class="text-decoration-none" style="color: #4b5563;">
                                            <span class="fw-semibold">{{ basename($comment->attachment_path) }}</span>
                                        </a>
                                        <a href="{{ route('comments.download', $comment) }}" class="btn btn-sm btn-link p-0 ms-1" title="Download">
                                            <i class="fas fa-download" style="font-size: 12px;"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 rounded" style="background: white; border: 2px dashed #e5e7eb;">
                            <i class="fas fa-comment-dots mb-3" style="font-size: 2.5rem; color: #d1d5db;"></i>
                            <p class="text-muted mb-0">No comments yet. Be the first to comment!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <script>
            function handleFileSelect(input) {
                const file = input.files[0];
                if (file) {
                    const maxSize = 5 * 1024 * 1024; // 5MB
                    if (file.size > maxSize) {
                        alert('File size must be less than 5MB');
                        input.value = '';
                        return;
                    }
                    
                    document.getElementById('filePreview').style.display = 'block';
                    document.getElementById('fileName').textContent = file.name;
                    document.getElementById('fileSize').textContent = formatFileSize(file.size);
                }
            }

            function removeFile() {
                document.getElementById('commentAttachment').value = '';
                document.getElementById('filePreview').style.display = 'none';
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            }
            </script>
            <!-- Attachments Section -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-paperclip me-2 text-warning"></i>Attachments ({{ $task->attachments->count() }})
                        </h5>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAttachmentModal">
                            <i class="fas fa-plus me-1"></i>Add File
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($task->attachments->count() > 0)
                        <div class="row g-3">
                            @foreach($task->attachments as $attachment)
                                <div class="col-md-6">
                                    <div class="attachment-item p-3 border rounded d-flex align-items-center hover-attachment">
                                        <div class="flex-shrink-0 me-3">
                                            @php
                                                $extension = strtolower(pathinfo($attachment->name, PATHINFO_EXTENSION));
                                                $iconData = match($extension) {
                                                    'pdf' => ['icon' => 'fa-file-pdf', 'color' => 'text-danger', 'bg' => 'rgba(220, 38, 38, 0.1)'],
                                                    'doc', 'docx' => ['icon' => 'fa-file-word', 'color' => 'text-primary', 'bg' => 'rgba(37, 99, 235, 0.1)'],
                                                    'xls', 'xlsx' => ['icon' => 'fa-file-excel', 'color' => 'text-success', 'bg' => 'rgba(34, 197, 94, 0.1)'],
                                                    'ppt', 'pptx' => ['icon' => 'fa-file-powerpoint', 'color' => 'text-warning', 'bg' => 'rgba(245, 158, 11, 0.1)'],
                                                    'jpg', 'jpeg', 'png', 'gif', 'svg' => ['icon' => 'fa-file-image', 'color' => 'text-info', 'bg' => 'rgba(14, 165, 233, 0.1)'],
                                                    'zip', 'rar', '7z' => ['icon' => 'fa-file-archive', 'color' => 'text-secondary', 'bg' => 'rgba(107, 114, 128, 0.1)'],
                                                    default => ['icon' => 'fa-file', 'color' => 'text-muted', 'bg' => 'rgba(156, 163, 175, 0.1)'],
                                                };
                                            @endphp
                                            <div class="rounded d-inline-flex align-items-center justify-content-center" 
                                                 style="width: 48px; height: 48px; background: {{ $iconData['bg'] }};">
                                                <i class="fas {{ $iconData['icon'] }} {{ $iconData['color'] }} fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <h6 class="mb-1" style="word-break: break-word; line-height: 1.3;">
                                                {{ $attachment->name }}
                                            </h6>
                                            <div class="d-flex align-items-center gap-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i>{{ $attachment->user->name ?? 'Unknown' }}
                                                </small>
                                                <small class="text-muted">•</small>
                                                <small class="text-muted">{{ $attachment->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('tasks.attachments.download', $attachment) }}">
                                                            <i class="fas fa-download me-2"></i>Download
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('tasks.attachments.destroy', $attachment) }}" method="POST" 
                                                              onsubmit="return confirm('Delete this attachment?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-paperclip fa-2x mb-3"></i>
                            <p class="mb-0">No attachments yet. Add files to this task!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reminders Section -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bell me-2 text-danger"></i>Reminders
                        </h5>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addReminderModal">
                            <i class="fas fa-plus me-1"></i>Add Reminder
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($task->reminders) && $task->reminders->count() > 0)
                        @foreach($task->reminders as $reminder)
                            <div class="reminder-item p-3 border rounded mb-3 {{ !$loop->last ? '' : 'mb-0' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <strong>{{ $reminder->remind_at->format('M d, Y H:i') }}</strong>
                                        </div>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @if($reminder->notify_telegram)
                                                <span class="badge bg-info">
                                                    <i class="fab fa-telegram me-1"></i>Telegram
                                                </span>
                                            @endif
                                            @if($reminder->notify_email)
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-envelope me-1"></i>Email
                                                </span>
                                            @endif
                                        </div>
                                        @if($reminder->note)
                                            <p class="text-muted mb-0 mt-2 small">{{ $reminder->note }}</p>
                                        @endif
                                    </div>
                                    <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" 
                                          onsubmit="return confirm('Delete this reminder?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-bell-slash fa-2x mb-3"></i>
                            <p class="mb-0">No reminders set</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Task Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-secondary"></i>Task Details
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Assignee -->
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Assignee</label>
                        @if($task->assignee)
                            <div class="d-flex align-items-center">
                                @if($task->assignee->profile_picture)
                                    <img src="{{ filter_var($task->assignee->profile_picture, FILTER_VALIDATE_URL)
                                            ? $task->assignee->profile_picture
                                            : asset('storage/' . $task->assignee->profile_picture) }}"
                                        alt="{{ $task->assignee->name }}"
                                        class="rounded-circle me-2"
                                        style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #e2e8f0;">
                                @else
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center me-2" 
                                        style="width: 32px; height: 32px; background: #6f42c1;">
                                        <small class="text-white fw-bold">{{ strtoupper(substr($task->assignee->name, 0, 1)) }}</small>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ $task->assignee->name }}</div>
                                    <small class="text-muted">{{ $task->assignee->email }}</small>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">Unassigned</p>
                        @endif
                    </div>

                    <!-- Due Date -->
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Due Date</label>
                        @if($task->due_date)
                            @php
                                $isOverdue = $task->due_date->isPast() && !in_array($task->status, ['completed', 'done']);
                            @endphp
                            <div class="{{ $isOverdue ? 'text-danger fw-semibold' : 'fw-semibold' }}">
                                {{ $task->due_date->format('M d, Y') }}
                                @if($isOverdue)
                                    <i class="fas fa-exclamation-circle ms-1"></i>
                                    <div class="small">Overdue by {{ $task->due_date->diffForHumans(null, true) }}</div>
                                @endif
                            </div>
                        @else
                            <p class="text-muted mb-0">No due date set</p>
                        @endif
                    </div>

                    <!-- Progress -->
                    <div class="mb-3">
                        <label class="text-muted small mb-2 d-flex justify-content-between">
                            <span>Progress</span>
                            <span class="fw-semibold">{{ $task->progress_percent }}%</span>
                        </label>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" 
                                 role="progressbar" 
                                 style="width: {{ $task->progress_percent }}%; background: #6f42c1;"
                                 aria-valuenow="{{ $task->progress_percent }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    <!-- Created -->
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Created</label>
                        <div class="fw-semibold">{{ $task->created_at->format('M d, Y H:i') }}</div>
                        <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                    </div>

                    <!-- Last Updated -->
                    <div class="mb-0">
                        <label class="text-muted small mb-1">Last Updated</label>
                        <div class="fw-semibold">{{ $task->updated_at->format('M d, Y H:i') }}</div>
                        <small class="text-muted">{{ $task->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>

            <!-- Quick Status Update -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Update Status</label>
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="review" {{ $task->status == 'review' ? 'selected' : '' }}>Review</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="blocked" {{ $task->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                            </select>
                        </div>
                    </form>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Edit Task
                        </a>
                        <a href="{{ route('projects.show', $task->project) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-folder me-2"></i>View Project
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Progress Modal -->
<div id="addProgressModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div class="card border-0 shadow-lg" style="width: 500px; max-width: 90%;">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">Add Progress Update</h5>
        </div>
        <form action="{{ route('progress.store', $task) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Progress (%)</label>
                    <input type="number" name="percent" class="form-control" min="0" max="100" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Note</label>
                    <textarea name="note" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_blocked" value="1" id="isBlocked">
                    <label class="form-check-label" for="isBlocked">
                        Task is blocked
                    </label>
                </div>
            </div>
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('addProgressModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #6f42c1; border-color: #6f42c1;">Save Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Attachment Modal -->
<div class="modal fade" id="addAttachmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-paperclip me-2"></i>Add Attachment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tasks.attachments.store', $task) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select File</label>
                        <input type="file" name="file" class="form-control" required>
                        <small class="text-muted">Max file size: 10MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #6f42c1; border-color: #6f42c1;">
                        <i class="fas fa-upload me-2"></i>Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Reminder Modal -->
<div class="modal fade" id="addReminderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('reminders.store') }}" method="POST">
                @csrf
                
                <!-- Hidden fields untuk polymorphic relationship -->
                <input type="hidden" name="remindable_type" value="App\Models\Task">
                <input type="hidden" name="remindable_id" value="{{ $task->id }}">
                
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-bell me-2"></i>Add Reminder
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <!-- Remind At -->
                    <div class="mb-3">
                        <label for="remind_at" class="form-label fw-semibold">
                            Remind Me At <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" 
                               class="form-control @error('remind_at') is-invalid @enderror" 
                               id="remind_at" 
                               name="remind_at" 
                               value="{{ old('remind_at') }}"
                               min="{{ now()->format('Y-m-d\TH:i') }}"
                               required>
                        @error('remind_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Set when you want to be reminded</small>
                    </div>

                    <!-- Notification Channels -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Notification Channel <span class="text-danger">*</span>
                        </label>
                        
                        @if(auth()->user()->telegram_id)
                            <div class="form-check">
                                <input class="form-check-input @error('notify_telegram') is-invalid @enderror" 
                                       type="checkbox" 
                                       name="notify_telegram" 
                                       id="notifyTelegram"
                                       value="1"
                                       {{ old('notify_telegram') ? 'checked' : '' }}>
                                <label class="form-check-label" for="notifyTelegram">
                                    <i class="fab fa-telegram text-info me-1"></i>
                                    Telegram
                                    <span class="badge bg-success ms-2">Connected</span>
                                </label>
                            </div>
                        @else
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="notifyTelegramDisabled"
                                       disabled>
                                <label class="form-check-label text-muted" for="notifyTelegramDisabled">
                                    <i class="fab fa-telegram me-1"></i>
                                    Telegram
                                    <span class="badge bg-warning ms-2">Not Connected</span>
                                </label>
                                <small class="d-block text-muted">
                                    Please add your Telegram ID in 
                                    <a href="{{ route('profile') }}" target="_blank">profile settings</a>
                                </small>
                            </div>
                        @endif

                        @if(auth()->user()->email)
                            <div class="form-check mt-2">
                                <input class="form-check-input @error('notify_email') is-invalid @enderror" 
                                       type="checkbox" 
                                       name="notify_email" 
                                       id="notifyEmail"
                                       value="1"
                                       {{ old('notify_email', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="notifyEmail">
                                    <i class="fas fa-envelope text-secondary me-1"></i>
                                    Email ({{ auth()->user()->email }})
                                    <span class="badge bg-success ms-2">Connected</span>
                                </label>
                            </div>
                        @else
                            <div class="form-check mt-2">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="notifyEmailDisabled"
                                       disabled>
                                <label class="form-check-label text-muted" for="notifyEmailDisabled">
                                    <i class="fas fa-envelope me-1"></i>
                                    Email
                                    <span class="badge bg-warning ms-2">Not Connected</span>
                                </label>
                                <small class="d-block text-muted">
                                    Please add your email in 
                                    <a href="{{ route('profile') }}" target="_blank">profile settings</a>
                                </small>
                            </div>
                        @endif

                        @error('notification')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('notify_telegram')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('notify_email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Note (Optional) -->
                    <div class="mb-3">
                        <label for="note" class="form-label fw-semibold">Note (Optional)</label>
                        <textarea class="form-control @error('note') is-invalid @enderror" 
                                  id="note" 
                                  name="note" 
                                  rows="3"
                                  maxlength="500"
                                  placeholder="Add a custom message for this reminder...">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max 500 characters</small>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #6f42c1; border-color: #6f42c1;">
                        <i class="fas fa-bell me-2"></i>Set Reminder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk auto-show modal kalau ada validation error -->
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah error dari reminder form
        @if($errors->has('remind_at') || $errors->has('notify_telegram') || $errors->has('notify_email') || $errors->has('notification') || $errors->has('note'))
            var reminderModal = new bootstrap.Modal(document.getElementById('addReminderModal'));
            reminderModal.show();
        @endif
    });
</script>
@endif

<!-- Delete Modal -->
<div class="delete-modal" id="deleteModal">
    <div class="delete-modal-content">
        <div class="delete-modal-header">
            <div class="delete-icon">
                <i class="fas fa-trash" style="color: white; font-size: 24px;"></i>
            </div>
            <h3 class="delete-modal-title">Delete Task?</h3>
            <p class="delete-modal-text">
                Are you sure you want to delete "<span id="deleteModalTaskName"></span>"? 
                This action cannot be undone.
            </p>
        </div>
        <div class="delete-modal-body">
            <button type="button" class="btn-delete-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-delete-confirm" onclick="confirmDelete()">Yes, Delete</button>
        </div>
    </div>
</div>

<form id="deleteTaskForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #6f42c1;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -25px;
    top: 17px;
    bottom: -20px;
    width: 2px;
    background: #e5e7eb;
}

.timeline-content {
    background: #f9fafb;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #6f42c1;
}

.comment-item {
    padding: 15px;
    background: #f9fafb;
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Delete Modal Styles */
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

.hover-attachment {
    transition: all 0.2s ease;
}

.hover-attachment:hover {
    background-color: #f9fafb;
    border-color: #6f42c1 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.reminder-item {
    background: #f9fafb;
    transition: all 0.2s ease;
}

.reminder-item:hover {
    background: #f3f4f6;
    border-color: #6f42c1 !important;
}
</style>

<script>
let deleteTaskId = null;
let deleteFormAction = '';

function openDeleteModal(taskId, taskName) {
    deleteTaskId = taskId;
    deleteFormAction = /tasks/${taskId};
    
    document.getElementById('deleteModalTaskName').textContent = taskName;
    document.getElementById('deleteModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
    document.body.style.overflow = 'auto';
    deleteTaskId = null;
}

function confirmDelete() {
    if (deleteFormAction) {
        const form = document.getElementById('deleteTaskForm');
        form.action = deleteFormAction;
        form.submit();
    }
}

document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (document.getElementById('deleteModal')?.classList.contains('active')) {
            closeDeleteModal();
        }
        if (document.getElementById('addProgressModal').style.display === 'flex') {
            document.getElementById('addProgressModal').style.display = 'none';
        }
    }
});
</script>
</x-layout>