<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

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

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#files-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Files</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="files-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
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
            <a class="nav-link collapsed" href="{{ url('/profile') }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" method="POST" action="{{ route('login') }}" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</aside>
