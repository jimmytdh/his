<?php
    $user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/morris.js/morris.css">
    <style>
        .tooltip {
            z-index: 9999 !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-home"></i> Dashboard
                    </h3>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ number_format(0) }}</h3>

                                    <p>All Documents</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-file-pdf-o"></i>
                                </div>
                                <a href="{{ url('/documents') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>{{ number_format(0) }}</h3>

                                    <p>Created Docs (APR)</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-file-o"></i>
                                </div>
                                <a href="{{ url('/documents') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>{{ number_format(0) }}</h3>

                                    <p>Accepted Docs (APR)</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar-plus-o"></i>
                                </div>
                                <a href="{{ url('/documents/pending') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            @if($user->level!='admin')
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{ number_format(0) }}</h3>

                                    <p>Pending Documents</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <a href="{{ url('/documents/pending') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                            @else
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{ number_format(0) }}</h3>

                                    <p>Number of Users</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <a href="{{ url('/admin/users') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                            @endif
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Last 7 Days Activity</h3>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="chart" id="line-chart" style="height: 300px;"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-body no-padding">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{ url('/back') }}/bower_components/moment/moment.js"></script>
<script src="{{ url('/back') }}/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="{{ url('/back') }}/bower_components/raphael/raphael.min.js"></script>
<script src="{{ url('/back') }}/bower_components/morris.js/morris.min.js"></script>
<script>
    $(function () {
        "use strict";

        // LINE CHART

    });
</script>


<script>
    $.ajax({
        url: "{{ url('/user/events') }}",
        type: "GET",
        success: function(data){
            console.log(data);
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: false,
                eventSources: [data],
                eventMouseover: function(calEvent, jsEvent) {
                    if(calEvent.title){
                        var tooltip = '<div class="tooltipevent" style="max-width:200px;color:#fff;padding:5px;background:#000;position:absolute;z-index:10001;">' + calEvent.description + '</div>';
                        $("body").append(tooltip);
                        $(this).mouseover(function(e) {
                            $(this).css('z-index', 10000);
                            $('.tooltipevent').fadeIn('500');
                            $('.tooltipevent').fadeTo('10', 1.9);
                        }).mousemove(function(e) {
                            $('.tooltipevent').css('top', e.pageY + 10);
                            $('.tooltipevent').css('left', e.pageX + 20);
                        });
                    }
                },

                eventMouseout: function(calEvent, jsEvent) {
                    $(this).css('z-index', 8);
                    $('.tooltipevent').remove();
                },
                validRange: {
                    start: "{{ date('Y') }}-01-01",
                    end: "{{ date('Y') }}-12-31"
                }
            });
        }
    });
</script>
@endsection