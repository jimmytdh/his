<?php
$user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('module')

@section('css')
<style>
    .table-header-rotated th.row-header{
        width: 500px;
    }

    .table-header-rotated td{
        width: 40px;
        border-top: 1px solid #dddddd;
        border-left: 1px solid #dddddd;
        border-right: 1px solid #dddddd;
        vertical-align: middle;
        text-align: center;
    }

    .table-header-rotated th.rotate-45{
        height: 80px;
        width: 40px;
        min-width: 40px;
        max-width: 40px;
        position: relative;
        vertical-align: bottom;
        padding: 0;
        font-size: 12px;
        line-height: 0.8;
    }

    .table-header-rotated th.rotate-45 > div{
        position: relative;
        top: 0px;
        left: 40px; /* 80 * tan(45) / 2 = 40 where 80 is the height on the cell and 45 is the transform angle*/
        height: 100%;
        -ms-transform:skew(-45deg,0deg);
        -moz-transform:skew(-45deg,0deg);
        -webkit-transform:skew(-45deg,0deg);
        -o-transform:skew(-45deg,0deg);
        transform:skew(-45deg,0deg);
        overflow: hidden;
        border-left: 1px solid #dddddd;
        border-right: 1px solid #dddddd;
        border-top: 1px solid #dddddd;
    }

    .table-header-rotated th.rotate-45 span {
        -ms-transform:skew(45deg,0deg) rotate(315deg);
        -moz-transform:skew(45deg,0deg) rotate(315deg);
        -webkit-transform:skew(45deg,0deg) rotate(315deg);
        -o-transform:skew(45deg,0deg) rotate(315deg);
        transform:skew(45deg,0deg) rotate(315deg);
        position: absolute;
        bottom: 30px; /* 40 cos(45) = 28 with an additional 2px margin*/
        left: -25px; /*Because it looked good, but there is probably a mathematical link here as well*/
        display: inline-block;
    // width: 100%;
        width: 85px; /* 80 / cos(45) - 40 cos (45) = 85 where 80 is the height of the cell, 40 the width of the cell and 45 the transform angle*/
        text-align: left;
    // white-space: nowrap; /*whether to display in one line or not*/
    }
</style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Diet Per Room</h3>
                        <div class="box-tools">
                            <a href="#" class="btn btn-success"
                               onclick="window.open('{{ url('/dietary/print/room') }}',
                                       'Print Barcode',
                                       'width=700,height=700');">
                                <i class="fa fa-print"></i> Print
                            </a>

                        </div>
                    </div>

                    <div class="box-body">
                        <div class="scrollable-table col-sm-11">
                            <table class="table table-striped table-header-rotated">
                                <thead>
                                <tr>
                                    <!-- First column header is not rotated -->
                                    <th></th>
                                    <th></th>
                                    <!-- Following headers are rotated -->
                                    <?php $header = \App\Http\Controllers\DietaryController::getDietList(); ?>
                                    @foreach($header as $v => $i)
                                    <th class="rotate-45"><div><span>{{ $v }}</span></div></th>
                                    @endforeach
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $tmp = ''; ?>
                                    @foreach($room as $r)
                                    <tr>
                                        <th class="row-header text-primary">
                                            @if($tmp != $r->ward)
                                                {{ $r->ward }}
                                            @endif
                                        </th>
                                        <th class="row-header text-success">{{ $r->room }}</th>
                                        @foreach($header as $v => $i)
                                        <?php $num = \App\Http\Controllers\DietaryController::countDietRoom($v,$r->room_id); ?>
                                        <td class="{{ ($num==0) ? 'bg-danger':'' }}">
                                            {{ ($num>0) ? $num : '' }}
                                        </td>
                                        @endforeach
                                    </tr>
                                    <?php $tmp = $r->ward; ?>
                                    @endforeach
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