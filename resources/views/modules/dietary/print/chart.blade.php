<html>
<title>Diet Census</title>
<style>
    .table { border: 3px solid #737373; }
    .table th, .table td {
        padding: 5px;
        font-size: 33px;
        border: 1px solid #737373;
    }
    tr:last-child, tr:first-child {
        background: #2a2a2a;
        color: #fff;
    }
    tr:nth-child(even) {
        background: #ececec;
    }
</style>
<body>
    <table class="table" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <th style="width: 50%;">DIET CENSUS</th>
            <th style="width: 50%;text-align: right;">{{ date('F d, Y') }}</th>
        </tr>
        <?php $total = 0 ; ?>
        @foreach($diet_list as $code => $value)
        <?php
            $count = \App\Http\Controllers\DietaryController::countDietCensus($code);
            $total = $total + $count;
        ?>
        <tr>
            <td>{{ $code }}</td>
            <td style="text-align: center;">{{ $count }}</td>
        </tr>
        @endforeach
        <tr>
            <th>TOTAL</th>
            <th style="text-align: center;">{{ $total }}</th>
        </tr>
    </table>
</body>
</html>