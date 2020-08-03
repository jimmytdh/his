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
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Diet Census ({{ date('F d, Y') }})</h3>
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
                        <?php
                            $diet = \App\Http\Controllers\DietaryController::getDietList();
                        ?>
                        <table class="table table-bordered table-striped table-hovered">
                            <?php $total = 0 ; ?>
                            @foreach($diet as $c => $v)
                                <?php
                                    $count = \App\Http\Controllers\DietaryController::countDietCensus($c);
                                    $total = $total + $count;
                                ?>
                                <tr>
                                    <th width="40%">{{ $v }}</th>
                                    <th width="40%">{{ $c }}</th>
                                    <th width="20%">{{ $count }}</th>
                                </tr>
                            @endforeach
                            <tr class="bg-gray">
                                <th colspan="2" class="text-right">TOTAL</th>
                                <th>{{ $total }}</th>
                            </tr>
                        </table>
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