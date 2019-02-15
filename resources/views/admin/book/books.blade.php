<?php use App\Author; ?>

@extends('layouts.layout_main')
@section('title', 'Edit Books')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-book"></i> Edit / View Books</h1>
    </div>

    <div class="row col-lg-12">
        <!-- Pending books -->
        <div class="row col-lg-6 col-lg-center">
            <h1 class="text-center">
                <a href="[[ URL::to('admin/book/pendingbooks') ]]">
                    <i class="fa fa-hourglass-end"></i> Pending Books
                </a>
                <i class="fa fa-question-circle" data-toggle="tooltip" title="Click this title to view more detailed information about pending books"></i>
            </h1>

            <table class="table table-striped ampl-table text-center">
                <tr>
                    <th class="text-center">Title</th>
                    <th class="text-center">Status</th>
                </tr>

                @foreach ($books as $book)
                    @if($book->status_id <= 6)
                        <tr>
                            <td>
                                <a style="margin:10px;" href="[[ URL::to('admin/book/edit', array($book->book_id)) ]]">
                                    [[ $book->title ]]
                                </a>
                            </td>

                            <td>[[ $book->status() ]]</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>

        <!-- Finished Books -->
        <div class="row col-lg-6 col-lg-center">
            <h1 class="text-center">
                <a href="[[ URL::to('admin/book/finishedbooks') ]]">
                    <i class="fa fa-pencil-square-o"></i> Finished Books
                </a>
                <i class="fa fa-question-circle" data-toggle="tooltip" title="Click this title to view more detailed information about finished books"></i>
            </h1>

            <table class="table table-striped ampl-table text-center">
                <tr>
                    <th class="text-center">Title</th>
                    <th class="text-center">Book Page</th>
                </tr>

                @foreach ($books->reverse() as $book)
                    @if($book->status_id == 7)
                        <tr>
                            <td>
                                <a style="margin:10px;" href="[[ URL::to('admin/book/edit', $book->book_id) ]]">
                                    [[ $book->title ]]
                                </a>
                            </td>
                            
                            <td>
                                <a style="margin:10px" href="[[ URL::to('bookpage', $book->book_id) ]]">
                                    Book Page
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>
    
    <div class="row col-lg-12 text-center">
        <br><br>
        <a class="btn btn-primary btn-lg" href="[[ URL::to('admin') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Admin Panel</a>
    </div>
</div>
<br><br>

@stop

@section('javascripts')
@stop