<?php
    $user = \Illuminate\Support\Facades\Session::get('user');
?>
<form method="post" action="{{ url('/documents/update/'.$data->id) }}">
    {{ csrf_field() }}
    <div class="modal-body no-padding">
        <table class="table table-hover table-striped" style="margin: 0px;">
            <tbody>
            <tr>
                <td class="text-right">Prepared By :</td>
                <td class="text-bold">{{ $user->fname }} {{ $user->lname }}</td>
            </tr>
            <tr>
                <td class="text-right">Prepared Date :</td>
                <td class="text-bold">{{ date('M d, Y h:i a',strtotime($data->prepared_date)) }}</td>
            </tr>
            <tr>
                <td class="text-right col-lg-4">Document Type :</td>
                <td class="col-lg-8">
                    <select name="doc_type" class="form-control form-select-sm" required @if(!$edit) disabled @endif>
                        <option @if($data->doc_type=='general') selected @endif value="general">General Document</option>
                        <option @if($data->doc_type=='incoming') selected @endif value="incoming">Incoming Mail</option>
                        <option @if($data->doc_type=='outgoing') selected @endif value="outgoing">Outgoing Mail</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-4">Document Flow :</td>
                <td class="col-lg-8">
                    <select name="flow_type" class="form-control form-select-sm" required @if(!$edit) disabled @endif>
                        <option @if($data->flow_type=='single') selected @endif value="single">Single Receiver</option>
                        <option @if($data->flow_type=='multiple') selected @endif value="multiple">Multiple Receiver</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="text-right">Remarks / <br />Additional Information :</td>
                <td>
                    <textarea name="description" class="form-control" rows="7" style="resize: none;" @if(!$edit) disabled @endif>{!! $data->description !!}</textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <div class="pull-left">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#paperSize"><i class="fa fa-file-pdf-o"></i> Barcode v1</button>
            <a href="#" class="btn btn-info"
               onclick="window.open('{{ url('/pdf/track') }}',
                       'Print Barcode',
                       'width=700,height=700');">
                <i class="fa fa-file-pdf-o"></i> Barcode v2
            </a>
        </div>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        @if($edit)
        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Update</button>
        @endif
    </div>
</form>