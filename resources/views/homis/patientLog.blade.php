<?php
$user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('app')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filter Result</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" action="{{ url('patient/logs') }}">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="month">Month</label>
                                    <select name="month" class="form-control" id="month">
                                        <option value="01" @if(\Illuminate\Support\Facades\Session::get('log_month')=='01') selected @endif>January</option>
                                        <option value="02" @if(\Illuminate\Support\Facades\Session::get('log_month')=='02') selected @endif>February</option>
                                        <option value="03" @if(\Illuminate\Support\Facades\Session::get('log_month')=='03') selected @endif>March</option>
                                        <option value="04" @if(\Illuminate\Support\Facades\Session::get('log_month')=='04') selected @endif>April</option>
                                        <option value="05" @if(\Illuminate\Support\Facades\Session::get('log_month')=='05') selected @endif>May</option>
                                        <option value="06" @if(\Illuminate\Support\Facades\Session::get('log_month')=='06') selected @endif>June</option>
                                        <option value="07" @if(\Illuminate\Support\Facades\Session::get('log_month')=='07') selected @endif>July</option>
                                        <option value="08" @if(\Illuminate\Support\Facades\Session::get('log_month')=='08') selected @endif>August</option>
                                        <option value="09" @if(\Illuminate\Support\Facades\Session::get('log_month')=='09') selected @endif>September</option>
                                        <option value="10" @if(\Illuminate\Support\Facades\Session::get('log_month')=='10') selected @endif>October</option>
                                        <option value="11" @if(\Illuminate\Support\Facades\Session::get('log_month')=='11') selected @endif>November</option>
                                        <option value="12" @if(\Illuminate\Support\Facades\Session::get('log_month')=='12') selected @endif>December</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="year">Month</label>
                                    <select name="year" class="form-control" id="year">
                                        <?php $y = date('Y'); ?>
                                        @for($i=0; $i<10; $i++)
                                        <option @if(\Illuminate\Support\Facades\Session::get('log_year')==$y) selected @endif>{{ $y-- }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="shift">Shift</label>
                                    <select name="shift" class="form-control" id="shift">
                                        <option value="4" @if(\Illuminate\Support\Facades\Session::get('log_shift')==4) selected @endif>All</option>
                                        <option value="1" @if(\Illuminate\Support\Facades\Session::get('log_shift')==1) selected @endif>6am to 2pm</option>
                                        <option value="2" @if(\Illuminate\Support\Facades\Session::get('log_shift')==2) selected @endif>2pm to 10pm</option>
                                        <option value="3" @if(\Illuminate\Support\Facades\Session::get('log_shift')==3) selected @endif>10pm to 6am</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="pull-right btn-block btn btn-primary">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Patient Logs
                        <br />
                        <small class="text-danger">Date: {{ $month }} {{ $year }}</small>
                        </h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body table-responsive">
                        @if(count($data)>0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Shift</th>
                                    <th class="text-center">ER Logs</th>
                                    <th class="text-center">OPD Logs</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $row)
                                <tr>
                                    <td class="text-center">{{ date('d',strtotime($row)) }}</td>
                                    <td class="text-success text-center">
                                        @if($shift==1)
                                            6am - 2pm
                                        @elseif($shift==2)
                                            2pm - 10pm
                                        @elseif($shift==3)
                                            10pm - 6am
                                        @else
                                            All
                                        @endif
                                    </td>
                                    <td class="text-danger text-center">{{ \App\Http\Controllers\HomisController::getErLog($row,$shift) }}</td>
                                    <td class="text-danger text-center">{{ \App\Http\Controllers\HomisController::getOpdLog($row,$shift) }}</td>
                                </tr>
                                @endforeach
                                </tbody>

                            </table>
                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="clearfix"></div>
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('modal')

@endsection

@section('js')

@endsection