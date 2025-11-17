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
                            <i class="fas fa-rocket me-2" style="font-size: 20px; color: #6f42c1;"></i>
                            <span style="font-size: 20px; font-weight: bold; color: #495057;">NotulenTracker</span>
                        </div>
                    </span>
                </a>
            </div>

            <!-- HAMBURGER -->
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- PASTE INI DI NAVBAR/LAYOUT KAMU -->

            <!-- Search Bar Container -->
            <div class="flex-grow-1 mx-3" style="max-width: 700px; min-width: 300px;">
                <div class="position-relative">
                    <input 
                        type="text" 
                        id="globalSearch" 
                        class="form-control ps-5 pe-3" 
                        placeholder="Search projects, meetings, users..." 
                        style="border-radius: 25px; border: 1px solid rgba(111, 66, 193, 0.15); height: 44px; font-size: 14px; width: 100%;"
                        autocomplete="off"
                    >
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3" style="color: #6f42c1; opacity: 0.6;"></i>
                </div>
                <!-- Results Dropdown -->
                <div id="searchDropdown" class="search-dropdown">
                    <div id="searchLoading" class="text-center py-3" style="display: none;">
                        <div class="spinner-border spinner-border-sm text-primary"></div>
                    </div>
                    <div id="searchResults"></div>
                </div>
            </div>

            <!-- CSS untuk Search -->
            <style>
            .search-dropdown {
                position: absolute;
                top: calc(100% + 10px);
                left: 0;
                right: 0;
                background: white;
                border-radius: 16px;
                box-shadow: 0 8px 32px rgba(111, 66, 193, 0.15), 0 2px 8px rgba(0,0,0,0.08);
                max-height: 480px;
                overflow-y: auto;
                z-index: 9999;
                display: none;
                border: 1px solid rgba(111, 66, 193, 0.1);
                animation: slideDown 0.2s ease;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .search-dropdown.show {
                display: block;
            }

            .search-dropdown::-webkit-scrollbar {
                width: 6px;
            }

            .search-dropdown::-webkit-scrollbar-track {
                background: transparent;
            }

            .search-dropdown::-webkit-scrollbar-thumb {
                background: rgba(111, 66, 193, 0.2);
                border-radius: 10px;
            }

            .search-dropdown::-webkit-scrollbar-thumb:hover {
                background: rgba(111, 66, 193, 0.3);
            }

            .search-category {
                background: #f5f3ff;
                padding: 10px 18px;
                font-weight: 700;
                font-size: 11px;
                color: #6f42c1;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                position: sticky;
                top: 0;
                z-index: 10;
                border-bottom: 1px solid rgba(111, 66, 193, 0.08);
                backdrop-filter: blur(10px);
            }

            .search-item {
                display: flex;
                align-items: center;
                padding: 14px 18px;
                gap: 14px;
                border-bottom: 1px solid #f5f3ff;
                cursor: pointer;
                transition: background 0.2s ease;
                text-decoration: none;
                color: inherit;
            }

            .search-item:hover {
                background: #f8f9fa;
            }

            .search-item:last-child {
                border-bottom: none;
            }

            .search-icon {
                width: 44px;
                height: 44px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                flex-shrink: 0;
            }

            .search-item:hover .search-icon {
                /* Hapus efek scale */
            }

            .search-icon.project {
                background: rgba(111, 66, 193, 0.08);
                color: #6f42c1;
            }

            .search-icon.meeting {
                background: rgba(99, 102, 241, 0.08);
                color: #6366f1;
            }

            .search-icon.user img {
                width: 44px;
                height: 44px;
                border-radius: 12px;
                object-fit: cover;
                border: 2px solid #f3f4f6;
            }

            .search-icon.user.no-image {
                background: #6f42c1;
                color: white;
                font-weight: 600;
                font-size: 16px;
            }

            .search-content {
                flex: 1;
                min-width: 0;
            }

            .search-title {
                font-weight: 600;
                font-size: 14px;
                color: #2d3748;
                margin-bottom: 4px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .search-item:hover .search-title {
                color: #2d3748; /* Tetap sama, ga berubah warna */
            }

            .search-meta {
                font-size: 12px;
                color: #718096;
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: wrap;
            }

            .search-meta i {
                font-size: 11px;
            }

            .search-badge {
                padding: 3px 10px;
                border-radius: 6px;
                font-size: 10px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.3px;
            }

            .search-no-results {
                padding: 48px 24px;
                text-align: center;
                color: #a0aec0;
            }

            .search-no-results i {
                font-size: 3rem;
                margin-bottom: 16px;
                opacity: 0.25;
                color: #6f42c1;
            }

            .search-no-results p {
                margin: 4px 0;
            }

            .search-no-results p:first-of-type {
                color: #4a5568;
                font-weight: 600;
            }

            /* Loading spinner style */
            #searchLoading .spinner-border {
                color: #6f42c1;
            }
            </style>

            <!-- JavaScript untuk Search -->
            <script>
            (function() {
                const searchInput = document.getElementById('globalSearch');
                const searchDropdown = document.getElementById('searchDropdown');
                const searchLoading = document.getElementById('searchLoading');
                const searchResults = document.getElementById('searchResults');
                let searchTimeout;

                if (!searchInput) return;

                // Event: Input search
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    
                    if (query.length < 2) {
                        hideDropdown();
                        return;
                    }

                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                });

                // Fungsi: Perform Search
                function performSearch(query) {
                    console.log('🔍 Searching for:', query);
                    
                    showDropdown();
                    searchLoading.style.display = 'block';
                    searchResults.innerHTML = '';

                    fetch(`/search?q=${encodeURIComponent(query)}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('📡 Response status:', response.status);
                        if (!response.ok) throw new Error('Search failed');
                        return response.json();
                    })
                    .then(data => {
                        console.log('✅ Results:', data);
                        searchLoading.style.display = 'none';
                        displayResults(data, query);
                    })
                    .catch(error => {
                        console.error('❌ Error:', error);
                        searchLoading.style.display = 'none';
                        searchResults.innerHTML = `
                            <div class="search-no-results">
                                <i class="fas fa-exclamation-circle"></i>
                                <p>Search error. Please try again.</p>
                            </div>
                        `;
                    });
                }

                // Fungsi: Display Results
                function displayResults(data, query) {
                    let html = '';
                    let hasResults = false;

                    // PROJECTS
                    if (data.projects && data.projects.length > 0) {
                        hasResults = true;
                        html += '<div class="search-category">Projects</div>';
                        data.projects.forEach(project => {
                            const statusClass = project.status === 'active' ? 'success' : 'secondary';
                            const statusText = project.status === 'active' ? 'Active' : 'Archived';
                            
                            html += `
                                <a href="${project.url}" class="search-item">
                                    <div class="search-icon project">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                    <div class="search-content">
                                        <div class="search-title">${escapeHtml(project.name)}</div>
                                        <div class="search-meta">
                                            <span>Code: ${escapeHtml(project.code)}</span>
                                            <span class="search-badge bg-${statusClass} text-white">${statusText}</span>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                    }

                    // MEETINGS
                    if (data.meetings && data.meetings.length > 0) {
                        hasResults = true;
                        html += '<div class="search-category">Meetings</div>';
                        data.meetings.forEach(meeting => {
                            html += `
                                <a href="${meeting.url}" class="search-item">
                                    <div class="search-icon meeting">
                                        <i class="fas fa-video"></i>
                                    </div>
                                    <div class="search-content">
                                        <div class="search-title">${escapeHtml(meeting.title)}</div>
                                        <div class="search-meta">
                                            <span><i class="far fa-calendar"></i> ${meeting.scheduled_at}</span>
                                            <span>📍 ${escapeHtml(meeting.location)}</span>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                    }

                    // USERS
                    if (data.users && data.users.length > 0) {
                        hasResults = true;
                        html += '<div class="search-category">👥 Users</div>';
                        data.users.forEach(user => {
                            const userIcon = user.profile_picture
                                ? `<div class="search-icon user"><img src="${user.profile_picture}" alt="${escapeHtml(user.name)}"></div>`
                                : `<div class="search-icon user no-image">${user.name.charAt(0).toUpperCase()}</div>`;
                            
                            html += `
                                <a href="${user.url}" class="search-item">
                                    ${userIcon}
                                    <div class="search-content">
                                        <div class="search-title">${escapeHtml(user.name)}</div>
                                        <div class="search-meta">
                                            <span>@${escapeHtml(user.username)}</span>
                                            <span>•</span>
                                            <span>${escapeHtml(user.email)}</span>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                    }

                    // NO RESULTS
                    if (!hasResults) {
                        html = `
                            <div class="search-no-results">
                                <i class="fas fa-search"></i>
                                <p><strong>No results found</strong></p>
                                <p style="font-size: 12px;">Try searching for "${escapeHtml(query)}" with different keywords</p>
                            </div>
                        `;
                    }

                    searchResults.innerHTML = html;
                }

                // Helper: Escape HTML
                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                // Helper: Show/Hide Dropdown
                function showDropdown() {
                    searchDropdown.classList.add('show');
                }

                function hideDropdown() {
                    searchDropdown.classList.remove('show');
                }

                // Close on click outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                        hideDropdown();
                    }
                });

                // Close on Escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        hideDropdown();
                        searchInput.blur();
                    }
                });
            })();
            </script>
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