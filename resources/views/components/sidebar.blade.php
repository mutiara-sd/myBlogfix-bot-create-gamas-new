<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <!-- MAIN SECTION -->
                <li class="menu-title">Main Menu</li>

                <li>
                    <a href="/dashboard" class="waves-effect">
                        <i class="fas fa-tachometer-alt" style="font-size: 16px; width: 20px;"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="/projects" class="waves-effect">
                        <i class="fas fa-project-diagram" style="font-size: 16px; width: 20px;"></i>
                        <span>Projects</span>
                    </a>
                </li>

                <li>
                    <a href="/meetings" class="waves-effect">
                        <i class="fas fa-users" style="font-size: 16px; width: 20px;"></i>
                        <span>Meetings & Notulen</span>
                    </a>
                </li>

                <li>
                    <a href="/tasks" class="waves-effect">
                        <i class="fas fa-tasks" style="font-size: 16px; width: 20px;"></i>
                        <span>Tasks</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- CSS UNTUK MEMPERCANTIK SIDEBAR DENGAN BRANDING TELKOM -->
<style>
:root {
    --telkom-red: #E30613;
    --telkom-red-dark: #C8161D;
    --telkom-red-light: #ffebee;
}

/* Sidebar Styling */
.vertical-menu {
    background: #ffffff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
}

.vertical-menu .metismenu li a {
    padding: 12px 20px;
    color: #495057;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    border-radius: 6px;
    margin: 2px 8px;
}

.vertical-menu .metismenu li a:hover {
    background: var(--telkom-red-light);
    color: var(--telkom-red);
    transform: translateX(2px);
}

.vertical-menu .metismenu li a.active,
.vertical-menu .metismenu li a[aria-expanded="true"] {
    background: var(--telkom-red);
    color: #ffffff;
}

.vertical-menu .metismenu li a i {
    margin-right: 12px;
    text-align: center;
    opacity: 0.8;
}

.vertical-menu .metismenu li a:hover i {
    opacity: 1;
    transform: scale(1.1);
}

.menu-title {
    color: #adb5bd;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 15px 20px 8px;
    margin: 0;
}

/* Hover effect untuk logout */
.vertical-menu button:hover {
    background: var(--telkom-red-light) !important;
}

.vertical-menu button:hover i,
.vertical-menu button:hover span {
    color: var(--telkom-red) !important;
}

/* Collapsed sidebar state */
body.sidebar-collapsed .vertical-menu .metismenu li a span {
    display: none;
}

body.sidebar-collapsed .menu-title {
    display: none;
}

body.sidebar-collapsed .vertical-menu .metismenu li a {
    justify-content: center;
    padding: 12px;
}

body.sidebar-collapsed .vertical-menu .metismenu li a i {
    margin-right: 0;
}

/* Active page highlighting */
.vertical-menu .metismenu li.mm-active > a {
    background: var(--telkom-red);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(227, 6, 19, 0.3);
}

/* Active state hover */
.vertical-menu .metismenu li.mm-active > a:hover {
    background: var(--telkom-red-dark);
    color: #ffffff;
    transform: translateX(2px);
}

/* Responsive */
@media (max-width: 768px) {
    .vertical-menu .metismenu li a {
        padding: 15px 20px;
    }
}
</style>