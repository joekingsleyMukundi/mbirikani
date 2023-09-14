<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- Brand Logo -->
    <a href="{{ route('member.dashboard.index') }}" class="justify-content-center align-content-center d-flex mx-2 text-center text-white">

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


                <li class="nav-item">
                    <a href="{{ route('member.dashboard.allocations.index') }}" class="nav-link {{ request()->is('member/dashboard/allocations') || request()->is('member/dashboard/allocations/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-rectangle-history-circle-user"></i>
                        <p>
                            My Allotment
                        </p>
                    </a>
                </li>




            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
