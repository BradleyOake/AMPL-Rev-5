@extends('layouts.layout_main')
@section('title', 'Your Purchases')
@section('metaDescription', '')
@section('pageHeader')
       <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-download"></i> My Purchases</h1>
        </div>
@stop
@section('content')

<!-- Page Content -->
    <div class="container main-content">
 <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-home"></i> Your Purchases</h1>
    </div>
        @if (count($books) != 0)
            <div class="form-group text-center">
                <p> Purchases over 60 days old cannot cannot be redownloaded, please <a href="[[ URL::to('contact') ]]">contact</a> AMPL to gain access to the book.</p>
            </div>

            <div class="scrollTable">
                <table width="100%"  class="table table-striped ampl-table">
                <tr>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Format</th>
                    <th>Date Purchased</th>

                     <th class="text-center">Expires</th>
                    <th class="text-center">Download</th>
                </tr>

            @foreach ($books as $book)
                   <?php $ex = (strtotime($book->access_until) - strtotime(date('Y-m-d') ) ) ?>
                <tr>
                    <td>
                           @if ($ex >= 0 )
                           <span class="label label-primary">New</span>
                        @endif
                     [[ $book->title]]</td>
                    <td>[[ $book->ISBN ]]</td>
                    <td>[[ $book->description]]</td>
                    <td>[[ date('M d, Y', strtotime($book->sold_on)) ]]</td>


                <td>
                  @if  ($ex == 0 )
                       Today
                     @else
                     [[  date('M d, Y', strtotime($book->access_until)) ]]


                        @endif

<td class="text-center">
                        @if ($ex >= 0 )
                            <a href="[[ URL::to('user/downloadBook', array('id' => $book->book_id)) ]]" class="btn btn-primary"><i class="fa fa-download"></i> Download</a></td>
                        @else
                            Expired
                        @endif
                    </td>

                </tr>

            @endforeach

            </table>
            </div>
        @else
            <h3 class="text-center">You have not made any purchases</h3>
        @endif
    </div>
    <!-- /.container -->

@stop

@section('javascripts')
@stop
