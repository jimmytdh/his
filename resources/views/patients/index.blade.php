<?php
    $user =  \Illuminate\Support\Facades\Session::get('user');
    $keyword = \Illuminate\Support\Facades\Session::get('search_document');
?>
@extends('app')

@section('css')
    <style>
        .table td {
            vertical-align: top;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $title }}</h3>
                    @if($keyword)
                    <br />
                    <small class="text-danger">
                        Keyword: {{ $keyword }}
                    </small>
                    @endif
                    <div class="box-tools pull-right">
                        <form class="form-inline" method="post" action="{{ url('/documents/search') }}">
                            {{ csrf_field() }}
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addDocument">
                                <i class="fa fa-file-o"></i> Create Document
                            </button>
                            <div class="input-group input-group-sm">
                                <input type="text" name="keyword" value="{{ $keyword }}" class="form-control pull-right" placeholder="Search">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    @if(count($data) > 0)
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr class="bg-black-active">
                                    <th width="15%">Route No.</th>
                                    <th width="15%">Creator</th>
                                    <th width="15%">Document Type</th>
                                    <th width="30%">Description</th>
                                    <th width="15%">Current Holder</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                <?php $current = \App\Http\Controllers\DocumentController::currentHolder($row->id);?>

                                <tr>
                                    <td class="text-bold text-success normal">
                                        <a href="#updateDocument" data-toggle="modal" data-id="{{ $row->id }}" class="editable">
                                        {{ $row->route_no }}
                                        </a>
                                        <br />
                                        <small class="text-muted small-sub">
                                            {{ \Carbon\Carbon::parse($row->prepared_date)->format('M d, Y h:i a') }}
                                        </small>
                                    </td>
                                    <td class="text-bold text-warning normal">
                                        {{ $user->lname }}, {{ $user->fname }}
                                        <br />
                                        <small class="text-muted small-sub">
                                            {{ \App\Section::find($user->section)->code }}
                                        </small>
                                    </td>
                                    <td>{{ \App\Http\Controllers\DocumentController::documentType($row->doc_type) }}</td>
                                    <td>{!! nl2br($row->description) !!}</td>
                                    <td class="text-bold text-warning normal">
                                        {{ $current->lname }}, {{ $current->fname }}
                                        <br />
                                        <small class="text-muted small-sub">
                                            @if(strlen($current->section)>30)
                                                {{ $current->code }}
                                            @else
                                                {{ $current->section }}
                                            @endif
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <a href="#trackDocument" data-toggle="modal" class="btn btn-block btn-info btn-xs btn-track" data-route_no="{{ $row->route_no }}">
                                            <i class="fa fa-line-chart"></i> Track
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="box-footer">
                    @if(count($data)>0)
                        {{ $data->links() }}
                    @else
                        <div class="callout callout-warning">
                            <p>Opps. No documents in this query!</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('modal')
    @include('modal.document')
@endsection

@section('js')
<script>
    $('.btn-track').on('click',function(){
        var route_no = $(this).data('route_no');
        $('span#route_no').html(route_no);
        var url = "{{ url('track') }}/"+route_no;
        var loading = "{{ url('loading') }}";
        $('.track_content').load(loading);
        setTimeout(function(){
            $('.track_content').load(url);
        },1000);
    });

    $('a[href="#updateDocument"]').on('click',function(){
        var id = $(this).data('id');
        var url = "{{ url('documents/edit') }}/"+id;
        var loading = "{{ url('loading') }}";
        $('.document_content').load(loading);
        setTimeout(function(){
            $('.document_content').load(url);
        },1000);
    });
</script>
@endsection