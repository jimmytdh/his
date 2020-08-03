@if(count($data) > 0)
    <div class="bg-gray" style="padding: 10px 0px;">
        <ul class="timeline" style="margin:0px;">
            @foreach($data as $row)
            <?php
                if($row->flow_type=='single'){
                    $nextDate = \App\Http\Controllers\DocumentController::getNextDate($row->id, $row->track_id);
                    if($nextDate){
                        $duration = \App\Http\Controllers\ParamController::timeDiff($row->date_in,$nextDate);
                    }else{
                        $duration = \App\Http\Controllers\ParamController::timeDiff($row->date_in,$row->date_end);
                        $duration = $duration." (Cycle End)";
                    }
                }else{
                    if($row->date_end != 0){
                        $duration = \App\Http\Controllers\ParamController::timeDiff($row->prepared_date,$row->date_end);
                        $duration = $duration." (End)";
                    }else{
                        $duration = \App\Http\Controllers\ParamController::timeDiff($row->prepared_date,$row->date_in);
                    }

                    if($row->prepared_date == $row->date_in){
                        $duration = "Starting Point";
                    }
                }
            ?>
            <li>
                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> {{ $duration }}</span>

                    <h3 class="timeline-header">
                        <span class="text-success">{{ $row->fname }} {{ $row->lname }}</span>
                        <br />
                        <small class="small-sub text-danger">
                            @if(strlen($row->section)>30)
                                {{ $row->code }}
                            @else
                                {{ $row->section }}
                            @endif
                        </small>
                    </h3>
                    <div class="timeline-body">
                        <table style="width: 100%" class="table-top">
                            <tr>
                                <td width="20%" class="text-right text-primary">Date Received</td>
                                <td width="10px">:</td>
                                <td>{{ date('F d, Y h:i a',strtotime($row->date_in)) }}</td>
                            </tr>
                            <tr>
                                <td width="20%" class="text-right text-primary">Remarks</td>
                                <td width="10px">:</td>
                                <td>{!! nl2br($row->remarks) !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
@else
    <div style="padding:20px 20px 10px">
        <div class="callout callout-danger">
            <p>Something went wrong. Route number can't be found in the database!</p>
        </div>
    </div>
@endif