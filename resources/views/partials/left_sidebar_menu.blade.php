<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="justify-content-center align-content-center d-flex mx-2 text-center text-white">

        @if(isset($settings->business_name))
            <h3>{{ $settings->business_name }}</h3>
        @else
            <h3>{{ Config::get('app.name') }}</h3>
        @endif
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
            <div class="image">
                @if(isset(Auth::user()->pic))
                    <img height="50" src="{{ Auth::user()->pic }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <i class="fa fa-user fa-2x text-white"></i>
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->first_name .' '. Auth::user()->last_name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                @can('dashboards:main')
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @endcan
                @can('users:list')
                <li class="nav-item {{ request()->is('dashboard/users') || request()->is('dashboard/users/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard.users.index') }}" class="nav-link {{ request()->is('dashboard/users') || request()->is('dashboard/users/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-crown"></i>
                        <p>
                            Staff
                        </p>
                    </a>
                </li>
                @endcan
                @can('members:list')
                <li class="nav-item {{ request()->is('dashboard/members') || request()->is('dashboard/members/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard.members.index') }}" class="nav-link {{ request()->is('dashboard/members') || request()->is('dashboard/members/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Members
                        </p>
                    </a>
                </li>
                @endcan
                @can('assets:list')
                <li class="nav-item {{ request()->is('dashboard/assets') || request()->is('dashboard/assets/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard.assets.index') }}" class="nav-link {{ request()->is('dashboard/assets') || request()->is('dashboard/assets/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-rectangle-wide"></i>
                        <p>
                            Group Ranch
                        </p>
                    </a>
                </li>
                @endcan
                @can('allocations:list')
                <li class="nav-item {{ request()->is('dashboard/allocations') || request()->is('dashboard/allocations/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard.allocations.index') }}" class="nav-link {{ request()->is('dashboard/allocations') || request()->is('dashboard/allocations/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-rectangle-history-circle-user"></i>
                        <p>
                            Allotments
                        </p>
                    </a>
                </li>
                @endcan
                @can('subassets:list')
                <li class="nav-item {{ request()->is('dashboard/subassets') || request()->is('dashboard/subassets/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard.subassets.index') }}" class="nav-link {{ request()->is('dashboard/subassets') || request()->is('dashboard/subassets/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-rectangles-mixed"></i>
                        <p>
                            Parcels
                        </p>
                    </a>
                </li>
                @endcan
                @can('reports:read')
                    <li class="nav-item {{ request()->is('dashboard/reports') || request()->is('dashboard/reports/*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('dashboard/reports') || request()->is('dashboard/reports/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-rectangle-history-circle-user"></i>
                            <p>
                                Reports

                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.reports.index') }}" class="nav-link {{ request()->is('dashboard/reports') ? 'active' : '' }}">
                                    <i class="fas fa-list-alt nav-icon"></i>
                                    <p>Chart Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.reports.summary.index') }}" class="nav-link {{ request()->is('dashboard/reports/summary') ? 'active' : '' }}">
                                    <i class="fas fa-list-alt nav-icon"></i>
                                    <p>Summary Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.reports.members.show') }}" class="nav-link {{ request()->is('dashboard/reports/members/*') ? 'active' : '' }}">
                                    <i class="fas fa-list-alt nav-icon"></i>
                                    <p>Members Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.reports.subassets.show') }}" class="nav-link {{ request()->is('dashboard/reports/subassets/*') ? 'active' : '' }}">
                                    <i class="fas fa-list-alt nav-icon"></i>
                                    <p>Parcel Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('audits:list')
                <li class="nav-item {{ request()->is('dashboard/logs') || request()->is('dashboard/logs/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard.logs.index') }}" class="nav-link {{ request()->is('dashboard/logs') || request()->is('dashboard/logs/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                            Audit Trail
                        </p>
                    </a>
                </li>
                @endcan
                @can('settings:list')
                <li class="nav-item {{ request()->is('dashboard/settings') || request()->is('dashboard/settings/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard.settings.general.index') }}" class="nav-link {{ request()->is('dashboard/settings') || request()->is('dashboard/settings/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
