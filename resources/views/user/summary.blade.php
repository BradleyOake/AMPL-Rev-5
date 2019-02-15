<?php use App\Author; ?>

@extends('layouts.layout_main')
@section('title', 'Account Summary')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-home"></i> Your Homepage</h1>
    </div>

    <div class="row">
        <div class="col-sm-5 text-center">
            <h2><i class="fa fa-user"></i> Personal Info</h2>
            <hr>
            <br>

            <p>
                <strong>Name:</strong> [[ Auth::user()->first_name ]] [[ Auth::user()->last_name ]]
            </p>

            <p>
                <strong>Email:</strong> [[ Auth::user()->email ]]
            </p>
            <br>

            <a href="[[ URL::to('user/profile') ]]" class="btn btn-primary btn-md"> <!--class="btn btn-default btn-lg">-->
                <i class="fa fa-pencil-square-o"></i> Edit
            </a>
        </div>

        <div class="col-sm-offset-1 col-sm-5 text-center">
            <h2><i class="fa fa-university"></i> Account Balance</h2>
            <hr>
            <table class="table ampl-table table-striped">
                <tr class="text-left">
                    <td>Account Balance</td>
                    @if(Auth::user()->accountBalance() != 0)
                    <td>$[[ number_format(Auth::user()->accountBalance(), 2, '.', ',') ]] </td>
                    @else
                    <td>-</td>
                    @endif
                </tr>

                <tr class="text-left">
                    <td>Accrued Earnings</td>
                    @if(Auth::user()->accruedEarnings() != 0)
                    <td>$[[ number_format(Auth::user()->accruedEarnings(), 2, '.', ',') ]] </td>
                    @else
                    <td>-</td>
                    @endif
                </tr>

                <tr class="text-left">
                    <th>Net Receivable</th>
                    @if(Auth::user()->accountBalance() != 0)
                    <th>$[[ number_format((Auth::user()->accountBalance() + Auth::user()->accruedEarnings()), 2, '.', ',') ]] </th>
                    @else
                    <th>-</td>
                    @endif
                </tr>
            </table>

            <a class="btn btn-primary btn-md" href="[[ URL::to('user/transactions') ]]">
                <i class="fa fa-exchange"></i> Transactions Details
            </a>
        </div>
    </div>
    <br><br>

    <!--<div class="row">
        <div class="col-sm-12">
            <h2><i class="fa fa-book"></i> My Books</h2>
            <hr style="text-align:left;margin-left:0;">

            @if(count(Auth::user()->books(Auth::user()->email)->get()) > 0)
                <table class="table table-striped ampl-table">
                    <tr>
                        <th class="text-center">Title</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Copies Sold</th>
                        <th class="text-center">Author(s)</th>
                    </tr>

                    @foreach (Auth::user()->books(Auth::user()->email)->get() as $book)
                        <tr>
                            <td class="text-center">[[ $book->title ]]</td>
                            <td class="text-center">[[ $book->status() ]]</td>

                            <td class="text-center"><a class="btn btn-default " href="[[ URL::to('user/monthlysales', array('id' => $book->book_id)) ]]">View Sales</a></td>

                            <td class="text-center">
                                @foreach ($book->authors as $author)
                                    <a data-toggle="tooltip" title="About [[ $author->name_on_book ]]" href="[[ URL::to('author/about', $author->name_on_book) ]]">
                                        [[ $author->name_on_book ]]
                                    </a>
                                    <br>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3>You haven't submitted any books yet</h3>
                    </div>
                </div>
            @endif
        </div>
    </div>-->
    <hr>
    <br>

    <div class="row text-center">
        <div class="col-sm-3">
            <a href="[[ URL::to('user/submission') ]]" class="btn btn-primary btn-lg">
                <i class="fa fa-pencil"></i> Submit a Book
            </a>
        </div>

        <div class="col-sm-3">
            <a href="[[ URL::to('user/myPurchases') ]]" class="btn btn-primary btn-lg">
                <i class="fa fa-cloud-download"></i> My Purchases
            </a>
        </div>

        <div class="col-sm-3">
            <a href="[[ URL::to('user/mybooks') ]]" class="btn btn-primary btn-lg">
                <i class="fa fa-book fa-fw"></i> My Written Works
            </a>
        </div>

        <div class="col-sm-3">
            <?php $year = date("Y") ?>
            <a href="[[ URL::to('user/sales') ]]" class="btn btn-primary btn-lg">
                <i class="fa fa-usd fa-fw"></i> My Sales
            </a>
        </div>
    </div>
</div>
<br><br>

@stop

@section('javascripts')
@stop
