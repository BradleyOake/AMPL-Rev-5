@extends('layouts.layout_main')
@section('title', 'My Sales')

@section('content')
<div class="container main-content">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Sales Yearly Summary</h1>
        </div>
    </div>

    <table class="table ampl-table table-striped">
        <tr>
            <th>Date</th>
            <th>Description</th>

            <th>Credit</th>
            <th>Debit</th>
        </tr>

        <?php $totalPaid= 0; ?>
        @foreach($payments as $payment)
            <?php $totalPaid += $payment->amount; ?>
            <tr>
                <td>[[ date('F j, Y \a\t g:ia', strtotime($payment->created_on)) ]]</td>
                <td>[[ $payment->description]]</td>
                <td>@if($payment->amount < 0)$ [[ number_format($payment->amount, 2, '.', ',') ]] @endif</td>
                <td>@if($payment->amount >= 0)$ [[ number_format($payment->amount, 2, '.', ',') ]] @endif</td>
            </tr>
        @endforeach

        <tr>
            <td></td>
            <th>Total</th>
            <td>$[[ number_format($totalPaid, 2, '.', ',') ]]</td>
            <td></td>
        </tr>
    </table>
</div>

@stop

@section('scripts')
<script>
    function change()
    {
        alert("changed date");
    }
</script>
@stop
