<x-layout>
    <!-- PAGE TITLE WITH DYNAMIC GREETING -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1" id="dynamic-greeting">
                        <script>
                            // Get current time
                            const now = new Date();
                            const hour = now.getHours();
                            const userName = "{{ Auth::user()->name ?? 'User' }}";
                            let greeting = "";
                            
                            // Dynamic greeting based on time
                            if (hour >= 5 && hour < 10) {
                                greeting = "Selamat Pagi";
                            } else if (hour >= 10 && hour < 15) {
                                greeting = "Selamat Siang";
                            } else if (hour >= 15 && hour < 18) {
                                greeting = "Selamat Sore";
                            } else {
                                greeting = "Selamat Malam";
                            }
                            
                            // Display greeting
                            document.write(greeting + ", " + userName + "!");
                        </script>
                    </h4>
                    <p class="text-muted mb-0" id="current-time">
                        <script>
                            const options = {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                            };
                            document.write(new Date().toLocaleDateString('id-ID', options));
                        </script>
                    </p>
                </div>
                
            </div>
        </div>
    </div>

    <!-- FILTERS SECTION -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Project</label>
                            <select class="form-select" id="projectFilter">
                                <option value="">All Projects</option>
                                <option value="website-redesign">Website Redesign</option>
                                <option value="mobile-app">Mobile App Development</option>
                                <option value="dashboard">Dashboard System</option>
                                <option value="api-integration">API Integration</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Assignee</label>
                            <select class="form-select" id="assigneeFilter">
                                <option value="">All Assignees</option>
                                <option value="me">Me</option>
                                <option value="john">John Doe</option>
                                <option value="jane">Jane Smith</option>
                                <option value="alex">Alex Johnson</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="todo">To Do</option>
                                <option value="in-progress">In Progress</option>
                                <option value="review">In Review</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                <i class="fas fa-filter me-1"></i>Apply Filter
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                <i class="fas fa-times me-1"></i>Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI CARDS -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium">On-time</p>
                            <h2 class="mb-0 text-success fw-bold">85%</h2>
                        </div>
                        <div class="avatar-lg bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-clock text-success fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium">Overdue</p>
                            <h2 class="mb-0 text-danger fw-bold">12</h2>
                        </div>
                        <div class="avatar-lg bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-exclamation-triangle text-danger fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium">In Review</p>
                            <h2 class="mb-0 text-warning fw-bold">18</h2>
                        </div>
                        <div class="avatar-lg bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-eye text-warning fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium">Blocked</p>
                            <h2 class="mb-0 text-secondary fw-bold">5</h2>
                        </div>
                        <div class="avatar-lg bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-ban text-secondary fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TASKS TABLE -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="fas fa-tasks text-primary me-2"></i>
                        <span class="fw-semibold">Tasks</span>
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Add Task
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4" style="width: 5%">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th scope="col" class="fw-semibold text-muted" style="width: 35%">TITLE</th>
                                    <th scope="col" class="fw-semibold text-muted" style="width: 20%">PROJECT</th>
                                    <th scope="col" class="fw-semibold text-muted" style="width: 15%">ASSIGNEE</th>
                                    <th scope="col" class="fw-semibold text-muted" style="width: 12%">DUE</th>
                                    <th scope="col" class="fw-semibold text-muted" style="width: 8%">STATUS</th>
                                    <th scope="col" class="fw-semibold text-muted" style="width: 5%">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="fas fa-circle text-success" style="font-size: 8px;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">Implement user authentication</h6>
                                                <small class="text-muted">Login & registration system</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                            Website Redesign
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-success fw-bold small">JD</span>
                                            </div>
                                            <span class="fw-medium">John Doe</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-success fw-medium">Dec 25, 2024</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">
                                            Done
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 50px; height: 6px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                            </div>
                                            <small class="text-muted fw-medium">100%</small>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="2">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="fas fa-circle text-warning" style="font-size: 8px;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">Design dashboard UI</h6>
                                                <small class="text-muted">Create responsive dashboard layout</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                            Dashboard System
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-info fw-bold small">JS</span>
                                            </div>
                                            <span class="fw-medium">Jane Smith</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-warning fw-medium">Dec 28, 2024</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill">
                                            In Progress
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 50px; height: 6px;">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 65%"></div>
                                            </div>
                                            <small class="text-muted fw-medium">65%</small>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="3">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="fas fa-circle text-danger" style="font-size: 8px;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">API Integration</h6>
                                                <small class="text-muted">Connect with external services</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                                            Mobile App
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-warning fw-bold small">AJ</span>
                                            </div>
                                            <span class="fw-medium">Alex Johnson</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-danger fw-medium">Dec 20, 2024</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill">
                                            Overdue
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 50px; height: 6px;">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 30%"></div>
                                            </div>
                                            <small class="text-muted fw-medium">30%</small>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="4">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="fas fa-circle text-info" style="font-size: 8px;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">Code review and testing</h6>
                                                <small class="text-muted">Quality assurance phase</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                            API Integration
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-secondary fw-bold small">ME</span>
                                            </div>
                                            <span class="fw-medium">{{ Auth::user()->name ?? 'Me' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted fw-medium">Dec 30, 2024</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-1 rounded-pill">
                                            In Review
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 50px; height: 6px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 90%"></div>
                                            </div>
                                            <small class="text-muted fw-medium">90%</small>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center p-4 border-top">
                        <div>
                            <small class="text-muted">
                                Showing <span class="fw-semibold">1</span> to <span class="fw-semibold">4</span> of <span class="fw-semibold">156</span> entries
                            </small>
                        </div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                                <li class="page-item active">
                                    <span class="page-link">1</span>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<!-- Auto-refresh time every minute -->
<script>
    function updateTime() {
        const now = new Date();
        const hour = now.getHours();
        const userName = "{{ Auth::user()->name ?? 'User' }}";
        let greeting = "";
        
        if (hour >= 5 && hour < 10) {
            greeting = "Selamat Pagi";
        } else if (hour >= 10 && hour < 15) {
            greeting = "Selamat Siang"; 
        } else if (hour >= 15 && hour < 18) {
            greeting = "Selamat Sore";
        } else {
            greeting = "Selamat Malam";
        }
        
        // Update greeting
        document.getElementById('dynamic-greeting').innerHTML = greeting + ", " + userName + "!";
        
        // Update time
        const options = {
            weekday: 'long',
            year: 'numeric', 
            month: 'long',
            day: 'numeric',
        };
        document.getElementById('current-time').innerHTML = now.toLocaleDateString('id-ID', options);
    }
    
    // Update every minute
    setInterval(updateTime, 60000);
    
    // Filter functions
    function applyFilters() {
        const project = document.getElementById('projectFilter').value;
        const assignee = document.getElementById('assigneeFilter').value;
        const status = document.getElementById('statusFilter').value;
        
        console.log('Applying filters:', { project, assignee, status });
        // Add your filter logic here
    }
    
    function clearFilters() {
        document.getElementById('projectFilter').value = '';
        document.getElementById('assigneeFilter').value = '';
        document.getElementById('statusFilter').value = '';
        console.log('Filters cleared');
        // Add your clear filter logic here
    }
    
    // Select all checkbox functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>