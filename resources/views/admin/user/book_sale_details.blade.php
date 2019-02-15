@extends('layouts.layout_main')
@section('title', 'Purchases')
@section('metaDescription', '')

@section('content')

<!-- Page Content -->
    <div class="container main-content">



<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">[[ $email ]]'s Earning on [[ $book->title ]]</h1>
        </div>
</div>


        <div class="row">
        <div class="col-lg-12">
            <h2>Account Details</h2>
        </div>
</div>

         <div class="row">
        <div class="col-lg-12">
            <h2>Sales Details</h2>
        </div>
</div>

    <table width="100%"  class="table table-bordered">


        <tr>

            <th rowspan="2">ID</th>
            <th rowspan="2">Title</th>
            <th rowspan="2">Status</th>
            <th colspan="3">Electronic</th>
            <th colspan="3">Audio</th>
            <th colspan="2">Total</th>



        </tr>

        @foreach( $book->invoices as $invoice)

        [[ var_dump($invoice) ]]
        @endforeach
        <tr>



            <th>Current Rate</th>
            <th># Sold</th>
            <th>Earned</th>

               <th>Current Rate</th>
            <th># Sold</th>
            <th>Earned</th>

            <th># Sold</th>
            <th>Earned</th>


        </tr>
        <tr>

        </tr>
    </table>




    </div>
    <!-- /.container -->

@stop
