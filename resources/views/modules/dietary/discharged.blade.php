
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
                                <input type="text" value="{{ Session::get('search_dietary_discharged_keyword') }}" class="form-control" name="keyword"  placeholder="Search Keyword..."/>
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
                                <th>Date Admitted</th>
                                <th>Date Discharged</th>
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
                                    <td>{{ date('M d, Y h:i a',strtotime($row->date_admitted)) }}</td>
                                    <td>{{ date('M d, Y h:i a',strtotime($row->date_discharged)) }}</td>
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

@endsection
@section('js')

@endsection