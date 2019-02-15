@extends('layouts.layout_main')
@section('title', 'My Books')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <!--<div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-check"></i> Published Books</h1>
    </div>-->

    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-home"></i> Your Books</h1>
    </div>

    @if(Auth::user()->books()->where('status_id', 7)->count() > 0)
        <table class="table table-striped ampl-table text-center">
            <tr>
                <th class="text-center">Title</th>
                <th class="text-center">Electronic Price</th>
                <th class="text-center">Electronic Sales</th>
                <th class="text-center">Audio Price</th>
                <th class="text-center">Audio Sales</th>
                <th class="text-center">Download</th>
            </tr>

            @foreach (Auth::user()->books()->where('status_id', 7)->get()  as $book)
                <tr>
                    <td>[[ $book->title ]]</td>
                    @if($book->electronic_price != NULL)
                        <td>$[[ $book->electronic_price ]]</td>
                    @else
                        <td>-</td>
                    @endif
                        <td>[[ $book->electronicSales()->count() ]]</td>
                    @if($book->audio_price != NULL)
                        <td>$[[ $book->audio_price ]]</td>
                    @else
                        <td>-</td>
                    @endif
                    <td>[[ $book->audioSales()->count() ]]</td>
                    <td><a href="[[ URL::to('user/downloadBook', array('id' => $book->book_id)) ]]" class="btn btn-default"><i class="fa fa-download"></i> Download</a></td>
                </tr>
            @endforeach
        </table>
    @else
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>You have no published books</h3>
            </div>
        </div>
    @endif

    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-exchange"></i> Pending Books</h1>
    </div>

    @if( Auth::user()->books()->where('status_id', '<', 6)->count() > 0)
        <table class="table table-striped ampl-table text-center">
            <tr>
                <th class="text-center">Title</th>
                <th class="text-center">Status</th>
                <th class="text-center">Downloads</th>
            </tr>

            @foreach (Auth::user()->books()->where('status_id', '<', 6)->get() as $book)
                <tr>
                    <td>[[ $book->title ]]</td>
                    <td>
                        @if($book->notes != NULL)
                            <p style="color:red;" data-toggle="tooltip" title="[[ $book->notes ]]">
                                [[ $book->status() ]]
                            </a>
                        @else
                            [[ $book->status() ]]
                        @endif
                    </td>
                    <td><a href ="[[ URL::to('download/submission', array('id' => $book->book_id, 'type' =>'chapters')) ]]" class="btn btn-default"><i class="fa fa-download"></i> Chapters</a> <a href ="[[ URL::to('download/submission', array('id' => $book->book_id, 'type' =>'synopsis')) ]]" class="btn btn-default"><i class="fa fa-download"></i> Synopsis</a></td>
                </tr>
            @endforeach
        </table>
    @else
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>You have no pending book submissions</h3>
            </div>
        </div>
    @endif
</div>
<!-- /.container -->

@stop
