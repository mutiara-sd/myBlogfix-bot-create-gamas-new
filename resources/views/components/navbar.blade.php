<header id="page-topbar">
    <style>
        :root {
            --telkom-red: #E30613;
            --telkom-red-dark: #C8161D;
            --telkom-red-light: #ffebee;
        }
        
        /* Logo Icon Color */
        .navbar-brand-box .logo-sm i {
            color: var(--telkom-red) !important;
        }
        
        .navbar-brand-box .logo-lg i {
            color: var(--telkom-red) !important;
        }
        
        /* Search Bar */
        #globalSearch {
            border: 1px solid rgba(227, 6, 19, 0.15) !important;
        }
        
        #globalSearch:focus {
            border-color: var(--telkom-red) !important;
            box-shadow: 0 0 0 0.2rem rgba(227, 6, 19, 0.15) !important;
        }
        
        .fa-search {
            color: var(--telkom-red) !important;
        }
        
        /* Search Dropdown */
        .search-dropdown {
            box-shadow: 0 8px 32px rgba(227, 6, 19, 0.15), 0 2px 8px rgba(0,0,0,0.08);
            border: 1px solid rgba(227, 6, 19, 0.1);
        }
        
        .search-category {
            background: var(--telkom-red-light);
            color: var(--telkom-red);
        }
        
        .search-icon.project {
            background: rgba(227, 6, 19, 0.08);
            color: var(--telkom-red);
        }
        
        .search-no-results i {
            color: var(--telkom-red) !important;
        }
        
        #searchLoading .spinner-border {
            color: var(--telkom-red);
        }
        
        /* Primary Button */
        .btn-primary {
            background-color: var(--telkom-red) !important;
            border-color: var(--telkom-red) !important;
        }
        
        .btn-primary:hover {
            background-color: var(--telkom-red-dark) !important;
            border-color: var(--telkom-red-dark) !important;
        }
        
        /* Profile Avatar Background */
        .avatar-sm.bg-primary {
            background-color: rgba(227, 6, 19, 0.1) !important;
        }
        
        .avatar-sm.bg-primary i {
            color: var(--telkom-red) !important;
        }
        
        /* Dropdown Icons */
        .dropdown-item i.text-primary {
            color: var(--telkom-red) !important;
        }
    </style>
    
    <div class="navbar-header">
        <div class="d-flex align-items-center">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/dashboard" class="logo logo-dark">
                    <span class="logo-sm">
                        <i class="fas fa-rocket" style="font-size: 24px;"></i>
                    </span>
                    <span class="logo-lg">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-rocket me-2" style="font-size: 20px;"></i>
                            <span style="font-size: 20px; font-weight: bold; color: #495057;">NotulenTracker</span>
                        </div>
                    </span>
                </a>
            </div>

            <!-- HAMBURGER -->
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- Search Bar Container -->
            <div class="flex-grow-1 mx-3" style="max-width: 700px; min-width: 300px;">
                <div class="position-relative">
                    <input 
                        type="text" 
                        id="globalSearch" 
                        class="form-control ps-5 pe-3" 
                        placeholder="Search projects, meetings, or tasks..." 
                        style="border-radius: 25px; height: 44px; font-size: 14px; width: 100%;"
                        autocomplete="off"
                    >
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3" style="opacity: 0.6;"></i>
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
                max-height: 480px;
                overflow-y: auto;
                z-index: 9999;
                display: none;
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
                background: rgba(227, 6, 19, 0.2);
                border-radius: 10px;
            }

            .search-dropdown::-webkit-scrollbar-thumb:hover {
                background: rgba(227, 6, 19, 0.3);
            }

            .search-category {
                padding: 10px 18px;
                font-weight: 700;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                position: sticky;
                top: 0;
                z-index: 10;
                border-bottom: 1px solid rgba(227, 6, 19, 0.08);
                backdrop-filter: blur(10px);
            }

            .search-item {
                display: flex;
                align-items: flex-start;
                padding: 14px 18px;
                gap: 14px;
                border-bottom: 1px solid var(--telkom-red-light);
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

            .search-icon.meeting {
                background: rgba(99, 102, 241, 0.08);
                color: #6366f1;
            }

            .search-icon.task {
                background: rgba(16, 185, 129, 0.08);
                color: #10b981;
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

            .search-description {
                font-size: 12px;
                color: #718096;
                margin-bottom: 6px;
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
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
            }

            .search-no-results p {
                margin: 4px 0;
            }

            .search-no-results p:first-of-type {
                color: #4a5568;
                font-weight: 600;
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

                function displayResults(data, query) {
                    let html = '';
                    let hasResults = false;

                    // PROJECTS
                    if (data.projects && data.projects.length > 0) {
                        hasResults = true;
                        html += '<div class="search-category">📁 Projects</div>';
                        data.projects.forEach(project => {
                            const statusClass = project.status === 'active' ? 'success' : 'secondary';
                            const statusText = project.status === 'active' ? 'Active' : project.status;
                            
                            html += `
                                <a href="${project.url}" class="search-item">
                                    <div class="search-icon project">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                    <div class="search-content">
                                        <div class="search-title">${escapeHtml(project.name)}</div>
                                        <div class="search-description">${escapeHtml(project.description || 'No description')}</div>
                                        <div class="search-meta">
                                            <span>📋 ${escapeHtml(project.code)}</span>
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
                                        <div class="search-description">📁 ${escapeHtml(meeting.project_name)}</div>
                                        <div class="search-meta">
                                            <span><i class="far fa-calendar"></i> ${meeting.scheduled_at}</span>
                                            <span>📍 ${escapeHtml(meeting.location)}</span>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                    }

                    // TASKS 
                    if (data.tasks && data.tasks.length > 0) {
                        hasResults = true;
                        html += '<div class="search-category">✓ Tasks</div>';
                        data.tasks.forEach(task => {
                            const priorityColors = {
                                'urgent': 'danger',
                                'high': 'warning', 
                                'medium': 'info',
                                'low': 'secondary'
                            };
                            const statusColors = {
                                'todo': 'secondary',
                                'doing': 'warning',
                                'progress': 'warning',
                                'review': 'info',
                                'done': 'success',
                                'completed': 'success',
                                'blocked': 'danger'
                            };
                            
                            html += `
                                <a href="${task.url}" class="search-item">
                                    <div class="search-icon task">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div class="search-content">
                                        <div class="search-title">${escapeHtml(task.title)}</div>
                                        <div class="search-description">${escapeHtml(task.description || 'No description')}</div>
                                        <div class="search-meta">
                                            <span>📁 ${escapeHtml(task.project_name)}</span>
                                            <span class="search-badge bg-${priorityColors[task.priority.toLowerCase()] || 'secondary'} text-white">${task.priority}</span>
                                            <span class="search-badge bg-${statusColors[task.status.toLowerCase()] || 'secondary'} text-white">${task.status}</span>
                                            <span>📅 ${task.due_date}</span>
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

                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                function showDropdown() {
                    searchDropdown.classList.add('show');
                }

                function hideDropdown() {
                    searchDropdown.classList.remove('show');
                }

                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                        hideDropdown();
                    }
                });

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
    function openNewTaskModal() {
        console.log('Opening new task modal...');
    }
    
    function openScheduleModal() {
        console.log('Opening schedule modal...');
    }
    
    function openTeamModal() {
        console.log('Opening team modal...');
    }
</script>

@include('livewire.assurance.bot.partials.project-modal')