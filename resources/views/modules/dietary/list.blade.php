<?php
$user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('module')

@section('css')
<style>
    .table tr { cursor: pointer; }
</style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">List of Patients
                    <br />
                    <small class="text-danger">Result: {{ number_format($data->total()) }}</small>
                    </h3>
                    <div class="pull-right">
                        <form class="form-inline" method="post" action="{{ url('dietary/patients') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <?php
                                    $ward = Session::get('search_dietary_ward');
                                    $with = Session::get('search_dietary_with');
                                ?>
                                <input type="text" value="{{ Session::get('search_dietary_keyword') }}" class="form-control" name="keyword"  placeholder="Search Keyword..."/>
                                <select name="ward" class="form-control">
                                    <option value="">All</option>
                                    @foreach($wards as $w)
                                    <option {{ ($w->wardcode==$ward) ? 'selected':'' }} value="{{ $w->wardcode }}">{{ $w->wardname}}</option>
                                    @endforeach
                                </select>
                                <select name="with" class="form-control">
                                    <option value="">All</option>
                                    <option {{ ($with=='with') ? 'selected':'' }} value="with">With Diet</option>
                                    <option {{ ($with=='without') ? 'selected':'' }} value="without">Without Diet</option>
                                </select>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-aqua">
                            <tr>
                                <th>Hospital #</th>
                                <th>Patient Name</th>
                                <th class="text-center">Gender</th>
                                <th class="text-right">Age</th>
                                <th>Height (m)</th>
                                <th>Weight (kg)</th>
                                <th>Date Admitted</th>
                                <th>Room</th>
                                <th>Diet Code</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $row)
                                <?php
                                $patroom = \App\Http\Controllers\HomisParam::getPatRoom($row->code);
                                $done = \App\Diet::where('code',$row->code)
                                    ->where('date_added',date('Y-m-d'))
                                    ->first();
                                $done_class = '';
                                $diet_code = '';
                                if($done){
                                    $done_class = 'bg-yellow';
                                    $diet_code = $done->diet_code;
                                }
                                ?>
                                <tr class="click {{ $done_class }}" data-code="{{ $row->code }}" data-fullname="{{ $row->lname }}, {{ $row->fname }}">
                                    <td class="text-bold text-success">{{ $row->code }}</td>
                                    <td>{{ $row->lname }}, {{ $row->fname }} @if($row->mname!='N/A') {{ $row->mname[0] }}. @endif</td>
                                    <td class="text-bold text-center">
                                        @if($row->sex=='F')
                                            <i class="fa fa-female text-danger"></i> F
                                        @else
                                            <i class="fa fa-male text-primary"></i> M
                                        @endif
                                    </td>
                                    <td class="text-warning text-right">{{ number_format($row->age) }}</td>
                                    <td>{{ \App\Http\Controllers\DietaryController::getHeightWeight('height',$row->code) }}</td>
                                    <td>{{ \App\Http\Controllers\DietaryController::getHeightWeight('weight',$row->code) }}</td>
                                    <td>{{ date('M d, Y h:i a',strtotime($row->date_admitted)) }}</td>
                                    <td>
                                        <font class="text-success">{{ \App\Http\Controllers\HomisParam::getWard($patroom->wardcode) }}</font>,
                                        <font class="text-danger">{{ \App\Http\Controllers\HomisParam::getRoom($patroom->rmintkey) }}</font>,
                                        <font class="text-warning">{{ \App\Http\Controllers\HomisParam::getBed($patroom->bdintkey) }}</font>
                                    </td>
                                    <td>
                                        {{ $diet_code }}
                                    </td>
                                </tr>
                            @endforeach

                            @if(count($data)<=0)
                            <tr>
                                <td colspan="9" class="text-center bg-warning">
                                    -- No Data Found --
                                </td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                {{ $data->links() }}
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection


@section('modal')
    <div class="modal fade" id="dietModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-green text-success">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="fullname">Select Diet</h4>
                </div>
                <div id="diet-content">
                    <div class="modal-body" id="diet-content">
                        <div class="text-center" style="padding:20px">
                            <img src="{{ url('img/loading.gif') }}" /><br />
                            <small class="text-muted">Loading...Please wait...</small>
                        </div>

                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('js')
<script>
    $("tr.click").click(function(){
        var code = $(this).data('code');
        $("tr").removeClass('bg-gray');
        $(this).addClass('bg-gray');

        $("#dietModal").modal('show');
        $("#fullname").html($(this).data('fullname'));

        $("#diet-content").load("{{ url('/loading') }}");
        setTimeout(function () {
            $("#diet-content").load("{{ url('/dietary/diet') }}/"+code);
        },1000);
    });
</script>
@endsection