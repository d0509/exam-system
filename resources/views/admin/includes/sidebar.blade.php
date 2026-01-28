        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href={{route('admin.dashboard')}}>
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Question Bank <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            @if(auth()->user()->getRoleNames()->first() == 'admin')
            <li class="nav-item active">
                <a class="nav-link" href={{route('admin.dashboard')}}>
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            @endif

            @if (auth()->user()->getRoleNames()->first() == 'student')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('student.dashboard')}}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span> Dashboard</span></a>
                </li>
            @endif

            @if (auth()->user()->getRoleNames()->first() == 'teacher')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('teacher.dashboard')}}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span> Dashboard</span></a>
                </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Question Management
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            @if (auth()->user()->hasRole('admin'))
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.questions.index')}}" >
                    <i class="fas fa-question"></i>
                    <span>Questions</span>
                </a>
            </li>
            @else
            <li class="nav-item">
                <a href="{{route('teacher.questions.index')}}" class="nav-link"><i class="fas fa-question"></i><span>Questions</span></a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Results</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.users.index')}}">
                    <i class="fas fa-user"></i>
                    <span>Users</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
