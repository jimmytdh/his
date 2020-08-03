<?php
$user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('module')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Patient Per Room</h3>
                        <div class="box-tools">
                            <a href="#" class="btn btn-success"
                               onclick="window.open('{{ url('dietary/print/chart#') }}',
                                       'Print Barcode',
                                       'width=700,height=700');">
                                <i class="fa fa-print"></i> Print
                            </a>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="scrollable-table">
                            <table class="table table-striped table-header-rotated">
                                <thead>
                                <tr>
                                    <!-- First column header is not rotated -->
                                    <th>Ward</th>
                                    <th>Room</th>
                                    <th>Patient Name</th>
                                    <th>Code</th>
                                    <th>Remarks</th>
                                    <!-- Following headers are rotated -->
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($data)>0)
                                    @foreach($data as $row)
                                    <tr>
                                        <th class="text-primary">{{ \App\Homis\Ward::where('wardcode',$row->ward_code)->first()->wardname }}</th>
                                        <th class="text-success">{{ \App\Homis\Room::where('rmintkey',$row->room_code)->first()->rmname }}</th>
                                        <td class="text-warning">
                                            <?php $person = \App\Homis\Person::where('hpercode',$row->code)->first(); ?>
                                            {{ $person->patlast }}, {{ $person->patfirst }} {{ $person->patmiddle }}
                                        </td>
                                        <td>{{ $row->diet_code }}</td>
                                        <td>{!! $row->remarks !!}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <th class="bg-warning text-center" colspan="5">
                                            --- No data found ---
                                        </th>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')

@endsection