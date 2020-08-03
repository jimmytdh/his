<?php
    $user = \Illuminate\Support\Facades\Session::get('user');
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ ($menu=='home') ? 'active':'' }}">
                <a href="{{ url('/') }}/">
                    <i class="fa fa-home"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ ($menu=='modules') ? 'active':'' }}">
                <a href="{{ url('/modules') }}">
                    <i class="fa fa-th"></i> <span>Modules</span>
                </a>
            </li>
            @if($user->level=='admin')
            <li class="treeview @if($menu=='patientLog') menu-open @endif ">
                <a href="#">
                    <i class="fa fa-bar-chart"></i> <span>Generate Report</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu" @if($menu=='patientLog') style="display:block;" @endif >
                    <li class="{{ ($menu=='patientLog') ? 'active':'' }}"><a href="{{ url('/patient/logs') }}"><i class="fa fa-print"></i> Patient Logs</a></li>
                </ul>
            </li>
            @endif

            @if($user->level=='admin')
                <li class="header">SYSTEM PARAMETERS</li>
                <li class="{{ ($menu=='users') ? 'active':'' }}">
                    <a href="{{ url('/admin/users') }}">
                        <i class="fa fa-users"></i> <span>Users</span>
                    </a>
                </li>
                <li class="{{ ($menu=='import') ? 'active':'' }}">
                    <a href="{{ url('/admin/users/import') }}">
                        <i class="fa fa-user-plus"></i> <span>Import Users</span>
                    </a>
                </li>
                <li class="{{ ($menu=='designation') ? 'active':'' }}">
                    <a href="{{ url('/admin/designation') }}">
                        <i class="fa fa-user-md"></i> <span>Designation</span>
                    </a>
                </li>
                <li class="{{ ($menu=='section') ? 'active':'' }}">
                    <a href="{{ url('/admin/section') }}">
                        <i class="fa fa-building"></i> <span>Section/Unit</span>
                    </a>
                </li>
                <li class="{{ ($menu=='division') ? 'active':'' }}">
                    <a href="{{ url('/admin/division') }}">
                        <i class="fa fa-building-o"></i> <span>Division</span>
                    </a>
                </li>
            @endif
            <li class="header">ACCOUNT SETTINGS</li>
            <li class="{{ ($menu=='profile') ? 'active':'' }}">
                <a href="{{ url('/user/profile') }}">
                    <i class="fa fa-user"></i> <span>Update Profile</span>
                </a>
            </li>
            <li class="{{ ($menu=='calendar') ? 'active':'' }}">
                <a href="{{ url('/user/calendar') }}">
                    <i class="fa fa-calendar"></i> <span>My Calendar</span>
                </a>
            </li>
            <li>
                <a href="#changePassword" data-toggle="modal">
                    <i class="fa fa-unlock-alt"></i> <span>Change Password</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/logout') }}">
                    <i class="fa fa-sign-out"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>