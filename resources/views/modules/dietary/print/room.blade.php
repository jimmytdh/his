<html>
<title>Diet Census</title>
<style>
    table {
        font-weight: normal;
        font-size: 9px;
    }
    td, th { padding:1px 2px; }
    .num { text-align: center; }
    .bg-danger { background: #c5c5c5; }
</style>
<body>
<div class="scrollable-table">
    <h3 class="box-title">Diet Per Room ({{ date('F d, Y') }})</h3>
    <table cellpadding="0" cellspacing="0" border="1">
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
                    <td class="num {{ ($num==0) ? 'bg-danger':'' }}">
                        {{ ($num>0) ? $num : '' }}
                    </td>
                @endforeach
            </tr>
            <?php $tmp = $r->ward; ?>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>