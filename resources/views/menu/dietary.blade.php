<?php
$user = \Illuminate\Support\Facades\Session::get('user');
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">DIETARY SECTION</li>
            <li class="{{ ($menu=='home') ? 'active':'' }}">
                <a href="{{ url('/dietary') }}/">
                    <i class="fa fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ ($menu=='patients') ? 'active':'' }}">
                <a href="{{ url('/dietary/patients') }}/">
                    <i class="fa fa-users"></i> <span>Admitted Patients</span>
                </a>
            </li>
            <li class="{{ ($menu=='discharged') ? 'active':'' }}">
                <a href="{{ url('/dietary/discharged') }}/">
                    <i class="fa fa-ambulance"></i> <span>Discharged Patients</span>
                </a>
            </li>
            <li class="treeview @if($menu=='report') menu-open @endif ">
                <a href="#">
                    <i class="fa fa-print"></i> <span>Generate Report</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu" @if($menu=='report' || $menu=='report.chart' || $menu=='report.room' || $menu=='report.patient') style="display:block;" @endif >
                    <li class="{{ ($menu=='report.chart') ? 'active':'' }}"><a href="{{ url('/dietary/report/chart') }}"><i class="fa fa-area-chart"></i> Diet Census</a></li>
                    <li class="{{ ($menu=='report.room') ? 'active':'' }}"><a href="{{ url('/dietary/report/room') }}"><i class="fa fa-bed"></i> Diet Per Room</a></li>
                    <li class="{{ ($menu=='report.patient') ? 'active':'' }}"><a href="{{ url('/dietary/report/patient') }}"><i class="fa fa-wheelchair"></i> Patient per Room</a></li>
                </ul>
            </li>
            <li class="header">BACK TO MAIN MENU</li>
            <li>
                <a href="{{ url('/') }}">
                    <i class="fa fa-sign-out"></i> <span>Close Form</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>