<?php
$user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('app')

@section('css')
    <style>
        .modules a {
            margin:5px;
            letter-spacing: 0.1em;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">List of Modules</h3>
                </div>

                <div class="box-body">
                    <div class="text-center modules">
                        <a href="{{ url('dietary') }}" class="btn btn-success">
                            <img src="{{ url('icons/dietary.png') }}" width="100" />
                            <hr style="margin: 10px 0px 5px 0px;" />
                            DIETARY
                        </a>
                        <a href="#" class="btn btn-danger">
                            <img src="{{ url('icons/er.png') }}" width="100" />
                            <hr style="margin: 10px 0px 5px 0px;" />
                            ER
                        </a>
                        <a href="#" class="btn btn-info">
                            <img src="{{ url('icons/opd.png') }}" width="100" />
                            <hr style="margin: 10px 0px 5px 0px;" />
                            OPD
                        </a>
                        <a href="#" class="btn btn-primary">
                            <img src="{{ url('icons/cashier.png') }}" width="100" />
                            <hr style="margin: 10px 0px 5px 0px;" />
                            CASHIER
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')

@endsection