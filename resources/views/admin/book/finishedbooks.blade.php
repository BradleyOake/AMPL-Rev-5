<?php use App\Author; ?>

@extends('layouts.layout_main')
@section('title', 'Edit Books')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-pencil-square-o"></i> Edit / View Finished Books</h1>
    </div>

    <div class="row col-lg-12 col-lg-center">
        <!-- Finished Books -->
        <table class="table table-striped ampl-table text-center">
            <tr>
                <th class="text-center">Title</th>
                <th class="text-center">Book Page</th>
                <th class="text-center">Cover</th>
                <th class="text-center">Formats</th>
                <th class="text-center">Author(s)</th>
                <th class="text-center">Options</th>
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

                        <td>
                            [!! $book->coverExists()? '<i class="fa fa-check"></i>' : '-' !!]
                        </td>

                        <td>
                            [!! $book->epubFinalExists()? '<img height="25" src="/images/filetypes/epub.gif" alt="epub" />' : '' !!]
                            [!! $book->pdfFinalExists()? '<img height="25" src="/images/filetypes/pdf.gif" alt="pdf" />' : '' !!]
                            [!! $book->txtFinalExists()? '<img height="25" src="/images/filetypes/txt.gif" alt="txt" />' : '' !!]
                            [!! $book->mp3FinalExists()? '<img height="25" src="/images/filetypes/mp3.gif" alt="mp3" />' : '' !!]
                        </td>

                        <td>
                            @foreach ($book->authors as $author)
                                [[ $author->name_on_book ]]<br>
                            @endforeach
                        </td>

                        <td>
                            <a href="[[ URL::to('admin/book/edit', array($book->book_id)) ]]" class="btn-sm btn btn-warning" title="Edit Book" data-toggle="tooltip">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                            
                            <a href="[[ URL::to('user/downloadBook', array($book->book_id)) ]]" class="btn-sm btn btn-success" title="Download Page" data-toggle="tooltip">
                                <i class="fa fa-download"></i>
                            </a>
                            
                            <a href="[[ URL::to('user/downloadBook', array($book->book_id)) ]]" class="btn-sm btn btn-primary" title="View Comments" data-toggle="tooltip">
                                <i class="fa fa-comment"></i> [[ $book->getNumberComments() ]]
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