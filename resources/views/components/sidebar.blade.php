<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Tasks -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tasks-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-list-task"></i><span>Tasks</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tasks-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('/tasks') }}">
                        <i class="bi bi-circle"></i><span>List of all tasks</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/tasks/create') }}">
                        <i class="bi bi-circle"></i><span>Add task</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Files -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#files-section" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Files</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="files-section" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('files.list') }}">
                        <i class="bi bi-circle"></i><span>List of all files</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/files/create') }}">
                        <i class="bi bi-circle"></i><span>Add file</span>
                    </a>
                </li>
            </ul>
        </li>


            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#accounts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-lines-fill"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="accounts-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('accounts.list') }}">
                            <i class="bi bi-circle"></i><span>List of Roles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('accounts.create') }}">
                            <i class="bi bi-circle"></i><span>Add Roles</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Roles -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#roles-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-shield-lock"></i><span>Roles</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="roles-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('roles.list') }}">
                            <i class="bi bi-circle"></i><span>List of Roles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('roles.create') }}">
                            <i class="bi bi-circle"></i><span>Add Roles</span>
                        </a>
                    </li>
                </ul>
            </li>

        <!-- Permissions -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#permissions-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-shield-lock"></i><span>Permissions</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="permissions-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('permissions.list') }}">
                            <i class="bi bi-circle"></i><span>List of Permissions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('permissions.create') }}">
                            <i class="bi bi-circle"></i><span>Add Permission</span>
                        </a>
                    </li>
                </ul>
            </li>

        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</aside>
