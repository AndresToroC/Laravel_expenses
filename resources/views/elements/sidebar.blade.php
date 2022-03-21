<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @role('admin')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                    <i class="icon-bar-graph menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="charts">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> 
                            <a class="nav-link" href="{{ route('dashboard.general') }}">General</a>
                        </li>
                        <li class="nav-item"> 
                            <a class="nav-link" href="{{ route('dashboard') }}">Personal</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Usuarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.categories.index') }}">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Categorias</span>
                </a>
            </li>
        @endrole

        @role('client')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
        @endrole

        <li class="nav-item">
            <a class="nav-link" href="{{ route('movements.index') }}">
                <i class="icon-bar-graph menu-icon"></i>
                <span class="menu-title">Gestionar Día a Día</span>
            </a>
        </li>
    </ul>
</nav>