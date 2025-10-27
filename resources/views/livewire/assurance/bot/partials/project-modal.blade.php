<!-- Modern Project Modal -->
<div class="modal fade" id="newProjectModal" tabindex="-1" aria-labelledby="newProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-20 rounded-3 p-2 me-3">
                        <i class="fas fa-rocket fs-5 text-white"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0 fw-bold" id="newProjectModalLabel">Create New Project</h5>
                        <small class="text-white-50">Setup your project with meetings and tasks</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <!-- Modern Tab Navigation -->
                <ul class="nav nav-pills nav-fill mb-4" id="projectTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-3" id="basic-tab" data-bs-toggle="pill" data-bs-target="#basic" type="button" role="tab">
                            <i class="fas fa-info-circle me-2"></i>Basic Info
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-3" id="meetings-tab" data-bs-toggle="pill" data-bs-target="#meetings" type="button" role="tab">
                            <i class="fas fa-calendar-alt me-2"></i>Meetings
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-3" id="tasks-tab" data-bs-toggle="pill" data-bs-target="#tasks" type="button" role="tab">
                            <i class="fas fa-tasks me-2"></i>Tasks
                        </button>
                    </li>
                </ul>

                <form id="quickProjectForm" action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <div class="tab-content" id="projectTabsContent">
                        <!-- Basic Info Tab -->
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Project Name -->
                                    <div class="mb-3">
                                        <label for="projectName" class="form-label fw-semibold">Project Name *</label>
                                        <input type="text" name="name" class="form-control rounded-3" id="projectName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label for="projectStatus" class="form-label fw-semibold">Status</label>
                                        <select name="status" class="form-select rounded-3" id="projectStatus">
                                            <option value="active" selected>Active</option>
                                            <option value="archived">Archived</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="projectDesc" class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control rounded-3" id="projectDesc" rows="4"></textarea>
                            </div>
                        </div>

                        <!-- Meetings Tab -->
                        <div class="tab-pane fade" id="meetings" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-semibold">Project Meetings</h6>
                                <button type="button" class="btn btn-primary rounded-3" onclick="addMeeting()">
                                    <i class="fas fa-plus me-1"></i>Add Meeting
                                </button>
                            </div>
                            <div id="meetingsContainer">
                                <div class="text-center text-muted py-5">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                        <i class="fas fa-calendar-plus fa-2x text-primary"></i>
                                    </div>
                                    <h6>No meetings scheduled</h6>
                                    <p class="mb-0">Add your first meeting to get started</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Tab -->
                        <div class="tab-pane fade" id="tasks" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-semibold">Project Tasks</h6>
                                <button type="button" class="btn btn-primary rounded-3" onclick="addTask()">
                                    <i class="fas fa-plus me-1"></i>Add Task
                                </button>
                            </div>
                            <div id="tasksContainer">
                                <div class="text-center text-muted py-5">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                        <i class="fas fa-tasks fa-2x text-warning"></i>
                                    </div>
                                    <h6>No tasks created</h6>
                                    <p class="mb-0">Add your first task to get started</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="errorAlert" class="alert alert-danger d-none mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Something went wrong, please try again.
                    </div>
                </form>
            </div>
            
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                    </i>Cancel
                </button>
                <button type="submit" form="quickProjectForm" class="btn btn-primary rounded-3">
                    </i>Create Project
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Meeting Modal -->
<div class="modal fade" id="quickMeetingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-20 rounded-3 p-2 me-3">
                        <i class="fas fa-calendar-plus text-white"></i>
                    </div>
                    <h6 class="modal-title mb-0 fw-bold">Add Meeting</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Meeting Title *</label>
                    <input type="text" class="form-control rounded-3" id="meetingTitle" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Date *</label>
                            <input type="date" class="form-control rounded-3" id="meetingDate" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Time *</label>
                            <input type="time" class="form-control rounded-3" id="meetingTime" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Location</label>
                            <input type="text" class="form-control rounded-3" id="meetingLocation" placeholder="Meeting room or online">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Organizer *</label>
                            <select class="form-select rounded-3" id="meetingOrganizer" required>
                                <option value="">Select Organizer</option>
                                <option value="1">John Doe</option>
                                <option value="2">Jane Smith</option>
                                <option value="3">Mike Johnson</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success rounded-3" onclick="saveMeeting()">
                    <i class="fas fa-save me-1"></i>Save Meeting
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Task Modal -->
<div class="modal fade" id="quickTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-white border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-20 rounded-3 p-2 me-3">
                        <i class="fas fa-plus-circle text-white"></i>
                    </div>
                    <h6 class="modal-title mb-0 fw-bold">Add Task</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Task Title *</label>
                    <input type="text" class="form-control rounded-3" id="taskTitle" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Assignee *</label>
                            <select class="form-select rounded-3" id="taskAssignee" required>
                                <option value="">Select Assignee</option>
                                <option value="1">John Doe</option>
                                <option value="2">Jane Smith</option>
                                <option value="3">Mike Johnson</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Due Date</label>
                            <input type="date" class="form-control rounded-3" id="taskDueDate">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Priority</label>
                            <select class="form-select rounded-3" id="taskPriority">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="critical">Critical</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select rounded-3" id="taskStatus">
                                <option value="todo">To Do</option>
                                <option value="in-progress">In Progress</option>
                                <option value="review">In Review</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning rounded-3" onclick="saveTask()">
                    <i class="fas fa-save me-1"></i>Save Task
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern touches tanpa berlebihan */
.modal-content {
    border-radius: 1rem !important;
}

.form-control, .form-select {
    border: 1px solid #e0e6ed;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

.nav-pills .nav-link {
    color: #6c757d;
    font-weight: 500;
    border: 1px solid transparent;
    transition: all 0.2s ease;
}

.nav-pills .nav-link:hover {
    color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.1);
}

.nav-pills .nav-link.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.meeting-item, .task-item {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-left: 4px solid #0d6efd;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 0.75rem;
    transition: all 0.2s ease;
}

.meeting-item:hover, .task-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.priority-low { 
    background-color: #d4edda; 
    color: #155724; 
    border: 1px solid #c3e6cb;
}
.priority-medium { 
    background-color: #fff3cd; 
    color: #856404; 
    border: 1px solid #ffeaa7;
}
.priority-high { 
    background-color: #f8d7da; 
    color: #721c24; 
    border: 1px solid #f5c6cb;
}
.priority-critical { 
    background-color: #f5c6cb; 
    color: #721c24; 
    font-weight: 600;
    border: 1px solid #e74c3c;
}

.btn {
    border-radius: 0.75rem !important;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}
</style>

<script>
let meetings = [];
let tasks = [];

function addMeeting() {
    const modal = new bootstrap.Modal(document.getElementById('quickMeetingModal'));
    modal.show();
}

function addTask() {
    const modal = new bootstrap.Modal(document.getElementById('quickTaskModal'));
    modal.show();
}

function saveMeeting() {
    const title = document.getElementById('meetingTitle').value;
    const date = document.getElementById('meetingDate').value;
    const time = document.getElementById('meetingTime').value;
    const location = document.getElementById('meetingLocation').value;
    const organizer = document.getElementById('meetingOrganizer').value;
    
    if (!title || !date || !time || !organizer) {
        alert('Please fill required fields');
        return;
    }
    
    const meeting = {
        id: Date.now(),
        title,
        scheduled_at: `${date} ${time}`,
        location: location || 'TBD',
        organizer_id: organizer,
        status: 'scheduled'
    };
    
    meetings.push(meeting);
    renderMeetings();
    
    // Close modal and reset
    bootstrap.Modal.getInstance(document.getElementById('quickMeetingModal')).hide();
    resetMeetingForm();
}

function saveTask() {
    const title = document.getElementById('taskTitle').value;
    const assignee = document.getElementById('taskAssignee').value;
    const dueDate = document.getElementById('taskDueDate').value;
    const priority = document.getElementById('taskPriority').value;
    const status = document.getElementById('taskStatus').value;
    
    if (!title || !assignee) {
        alert('Please fill required fields');
        return;
    }
    
    const task = {
        id: Date.now(),
        title,
        assignee_id: assignee,
        due_date: dueDate,
        priority,
        status
    };
    
    tasks.push(task);
    renderTasks();
    
    // Close modal and reset
    bootstrap.Modal.getInstance(document.getElementById('quickTaskModal')).hide();
    resetTaskForm();
}

function renderMeetings() {
    const container = document.getElementById('meetingsContainer');
    if (meetings.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                    <i class="fas fa-calendar-plus fa-2x text-primary"></i>
                </div>
                <h6>No meetings scheduled</h6>
                <p class="mb-0">Add your first meeting to get started</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = meetings.map((meeting, index) => `
        <div class="meeting-item">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <h6 class="mb-2 fw-semibold">
                        <i class="fas fa-calendar me-2 text-primary"></i>${meeting.title}
                    </h6>
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <i class="fas fa-clock me-1"></i>
                            ${new Date(meeting.scheduled_at).toLocaleString()}
                        </div>
                        <div class="col-md-6">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            ${meeting.location}
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-outline-danger rounded-3" onclick="removeMeeting(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `).join('');
}

function renderTasks() {
    const container = document.getElementById('tasksContainer');
    if (tasks.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                    <i class="fas fa-tasks fa-2x text-warning"></i>
                </div>
                <h6>No tasks created</h6>
                <p class="mb-0">Add your first task to get started</p>
            </div>
        `;
        return;
    }
    
    const getUserName = (id) => {
        const users = { '1': 'John Doe', '2': 'Jane Smith', '3': 'Mike Johnson' };
        return users[id] || 'Unknown';
    };
    
    container.innerHTML = tasks.map((task, index) => `
        <div class="task-item">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <h6 class="mb-2 fw-semibold">
                        <i class="fas fa-check-square me-2 text-warning"></i>${task.title}
                    </h6>
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <span class="badge priority-${task.priority} rounded-3">${task.priority.toUpperCase()}</span>
                        <span class="badge bg-secondary rounded-3">${task.status.toUpperCase()}</span>
                    </div>
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <i class="fas fa-user me-1"></i>
                            ${getUserName(task.assignee_id)}
                        </div>
                        <div class="col-md-6">
                            ${task.due_date ? `<i class="fas fa-calendar me-1"></i>${task.due_date}` : '<i class="fas fa-calendar-times me-1"></i>No due date'}
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-outline-danger rounded-3" onclick="removeTask(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `).join('');
}

function removeMeeting(index) {
    meetings.splice(index, 1);
    renderMeetings();
}

function removeTask(index) {
    tasks.splice(index, 1);
    renderTasks();
}

function resetMeetingForm() {
    document.getElementById('meetingTitle').value = '';
    document.getElementById('meetingDate').value = '';
    document.getElementById('meetingTime').value = '';
    document.getElementById('meetingLocation').value = '';
    document.getElementById('meetingOrganizer').value = '';
}

function resetTaskForm() {
    document.getElementById('taskTitle').value = '';
    document.getElementById('taskAssignee').value = '';
    document.getElementById('taskDueDate').value = '';
    document.getElementById('taskPriority').value = 'medium';
    document.getElementById('taskStatus').value = 'todo';
}

// Reset when main modal closes
document.getElementById('newProjectModal').addEventListener('hidden.bs.modal', function() {
    meetings = [];
    tasks = [];
    renderMeetings();
    renderTasks();
    document.getElementById('quickProjectForm').reset();
    document.getElementById('errorAlert').classList.add('d-none');
    
    // Reset to first tab
    const firstTab = document.querySelector('#basic-tab');
    const pill = new bootstrap.Tab(firstTab);
    pill.show();
});
</script>