<?php use App\Author; ?>

@extends('layouts.layout_main')
@section('title', 'Edit Books')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-hourglass-end"></i> Edit / View Pending Books</h1>
    </div>

    <div class="row col-lg-12 col-lg-center">
        <!-- Pending books -->
        <table class="table table-striped ampl-table text-center">
            <tr>
                <th class="text-center">Title</th>
                <th class="text-center">Status</th>
                <th class="text-center">Author(s)</th>
                <th class="text-center">Options</th>
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
                        
                        <td>
                            @foreach ($book->authors as $author)
                                [[ $author->name_on_book ]]<br>
                            @endforeach
                        </td>

                        <td>
                            <a href="[[ URL::to('admin/book/edit', array($book->book_id)) ]]" class="btn-sm btn btn-warning" title="Edit Book" data-toggle="tooltip">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
    
    <div class="row col-lg-12 text-center">
        <br><br>
        <a class="btn btn-primary btn-lg" href="[[ URL::to('admin/book') ]]">
            <i class="fa fa-arrow-circle-left"></i> Back To Books
        </a><br>
        <hr>
        <a class="btn btn-primary btn-lg" href="[[ URL::to('admin') ]]">
            <i class="fa fa-arrow-circle-left"></i> Back To Panel
        </a>
    </div>
</div>
<br><br>

@stop

@section('javascripts')
@stop