<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex align-items-center">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/dashboard" class="logo logo-dark">
                    <span class="logo-sm">
                        <i class="fas fa-rocket" style="font-size: 24px; color: #495057;"></i>
                    </span>
                    <span class="logo-lg">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-rocket me-2" style="font-size: 20px; color: #0d6efd;"></i>
                            <span style="font-size: 20px; font-weight: bold; color: #495057;">NotulenTracker</span>
                        </div>
                    </span>
                </a>
            </div>

            <!-- HAMBURGER -->
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- SEARCH BAR -->
            <div class="ms-3 flex-grow-1" style="max-width: 400px;">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5" placeholder="Search tasks, projects, users..." style="border-radius: 25px;">
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <!-- NOTIFICATIONS -->
            <div class="dropdown d-inline-block me-2">
                <button type="button" class="btn header-item position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell" style="font-size: 18px;"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                        3
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow-lg" style="width: 350px;">
                    <div class="dropdown-header bg-primary text-white py-3">
                        <h6 class="mb-0 text-white">
                            <i class="fas fa-bell me-2"></i>Notifications
                        </h6>
                    </div>
                    <div class="dropdown-divider m-0"></div>
                    
                    <!-- Notification Item -->
                    <div class="dropdown-item-text p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="avatar-sm bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                <i class="fas fa-tasks text-danger"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold">Task Overdue</h6>
                                <p class="mb-1 text-muted small">API Integration task is overdue</p>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dropdown-item-text p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="avatar-sm bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                <i class="fas fa-check text-success"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold">Task Completed</h6>
                                <p class="mb-1 text-muted small">User authentication completed</p>
                                <small class="text-muted">4 hours ago</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dropdown-item-text p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="avatar-sm bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                <i class="fas fa-users text-warning"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold">New Assignment</h6>
                                <p class="mb-1 text-muted small">You've been assigned to a new task</p>
                                <small class="text-muted">1 day ago</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dropdown-divider m-0"></div>
                    <div class="text-center p-3">
                        <a href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye me-1"></i>View All Notifications
                        </a>
                    </div>
                </div>
            </div>

            <!-- ADD NEW BUTTON -->
            <div class="dropdown d-inline-block me-2">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus me-1"></i>New
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow">
                    <h6 class="dropdown-header">Create New</h6>
                    <a class="dropdown-item" href="#" onclick="openNewTaskModal()">
                        <i class="fas fa-tasks text-primary me-2"></i>New Task
                    </a>
                    <a class="dropdown-item" href="{{ route('projects.create') }}">
                        <i class="fas fa-project-diagram text-success me-2"></i>New Project
                    </a>
                    <a class="dropdown-item" href="#" onclick="openScheduleModal()">
                        <i class="fas fa-calendar-plus text-warning me-2"></i>Schedule Meeting
                    </a>
                </div>
            </div>

            <!-- PROFILE DROPDOWN -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ filter_var(Auth::user()->profile_picture, FILTER_VALIDATE_URL) 
                            ? Auth::user()->profile_picture 
                            : asset('storage/' . Auth::user()->profile_picture) }}" 
                            alt="Profile" 
                            class="rounded-circle me-2" 
                            style="width: 32px; height: 32px; object-fit: cover;">
                    @else
                        <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                            <i class="fas fa-user text-primary" style="font-size: 14px;"></i>
                        </div>
                    @endif
                    <span class="d-none d-xl-inline-block fw-semibold">{{ Auth::user()->name ?? 'User' }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block ms-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow">
                    <div class="dropdown-header">
                        <div class="d-flex align-items-center">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ filter_var(Auth::user()->profile_picture, FILTER_VALIDATE_URL) 
                                    ? Auth::user()->profile_picture 
                                    : asset('storage/' . Auth::user()->profile_picture) }}" 
                                    alt="Profile" 
                                    class="rounded-circle me-2" 
                                    style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0">{{ Auth::user()->name ?? 'User' }}</h6>
                                <small class="text-muted">{{ Auth::user()->username ?? 'Username' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/profile">
                        <i class="fas fa-user font-size-16 align-middle me-2"></i>My Profile
                    </a>
                    <a class="dropdown-item" href="/settings">
                        <i class="fas fa-cog font-size-16 align-middle me-2"></i>Settings
                    </a>
                    <a class="dropdown-item" href="/help">
                        <i class="fas fa-question-circle font-size-16 align-middle me-2"></i>Help Center
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="/signout" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt font-size-16 align-middle me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Functions for dropdown actions
    function openNewTaskModal() {
        console.log('Opening new task modal...');
        // Add your modal opening logic here
    }
    
    function openScheduleModal() {
        console.log('Opening schedule modal...');
        // Add your modal opening logic here
    }
    
    function openTeamModal() {
        console.log('Opening team modal...');
        // Add your modal opening logic here
    }
</script>

<!-- Tambahkan ini di akhir file navbar.blade.php -->
@include('livewire.assurance.bot.partials.project-modal')