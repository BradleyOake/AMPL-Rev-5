@extends('layouts.layout_main')
@section('title', 'Purchases')
@section('metaDescription', '')

@section('content')

<!-- Page Content -->
    <div class="container main-content">
        <div class="col-lg-12">
            <h1 class="page-header">[[ $email ]]'s Purchases</h1>
        </div>
       @if (count($invoices) != 0)
                <table width="100%"  class="table table-striped ampl-table">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Format</th>
                    <th>Date Purchased</th>
                    <th class="text-center">Expires</th>
                </tr>
                @foreach ($invoices as $invoice)

                    <?php $ex = (strtotime($invoice->access_until) - strtotime(date('Y-m-d') ) ) ?>
                <tr>
                        <td>[[ $invoice->book_id ]]</td>
                        <td>[[ $invoice->title]]</td>
                        <td>[[ $invoice->description]]</td>
                        <td>[[ date('M d, Y', strtotime($invoice->sold_on)) ]]</td>
                        <td>
                            @if  ($ex == 0 )
                                Today
                            @elseif ($ex > 0 )
                                [[  date('M d, Y', strtotime($invoice->access_until)) ]]
                            @else
                                [[  date('M d, Y', strtotime($invoice->access_until)) ]] (Expired)
                            @endif
                        </td>
                        <td class="text-center">      <a href="[[ URL::to('admin/resetPurchase', array('id' => $invoice->sale_id)) ]]" class="btn btn-primary"> Reset</a></td>
                    </tr>

                @endforeach

            </table>

        @else
            <h3 class="text-center">[[ $email ]] as not made any purchases</h3>
        @endif

    </div>
    <!-- /.container -->

@stop
