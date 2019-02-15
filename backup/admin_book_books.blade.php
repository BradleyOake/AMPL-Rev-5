@extends('layouts.layout_main')
@section('title', 'View/Edit Books')

@section('content')

<!-- main-container -->
<div class="container main-content">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">View/Edit Books</h1>
        </div>
    </div>

    <table width="100%" class="table table-striped table-bordered ampl-table" style="text-align: center">

        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Cover</th>
            <th>Status</th>
            <th>Text</th>
            <th>Epub</th>
            <th>Pdf</th>
            <th>Mp3</th>
            <th>Author(s)</th>

        </tr>
        @foreach ($books as $book)
        <tr>
            <td style=" vertical-align: middle;">[[ $book->book_id ]]</td>
            <td style=" vertical-align: middle;">[[ $book->title ]]</td>
            <td style=" vertical-align: middle;">[!! $book->coverExists()? '<i class="fa fa-check"></i>' : '-' !!]</td>
            <td style=" vertical-align: middle;">[!! $book->status()? $book->status() : '-' !!] </td>
            <td style=" vertical-align: middle;">[!! $book->txtFinalExists()? '<i class="fa fa-check"></i>' : '-' !!]</td>
            <td style=" vertical-align: middle;">[!! $book->epubFinalExists()? '<i class="fa fa-check"></i>' : '-' !!]</td>
            <td style=" vertical-align: middle;">[!! $book->pdfFinalExists()? '<i class="fa fa-check"></i>' : '-' !!]</td>
            <td style=" vertical-align: middle;">[!! $book->mp3FinalExists()? '<i class="fa fa-check"></i>' : '-' !!]</td>

            <td>
                @foreach ($book->authors as $author) [[ $author->email ]] ([[ $author->name_on_book ]])
                <!--  <div class="pull-right">
   <button data-book-id="[[$book->book_id ]]" data-book-title="[[$book->title ]]" data-email="[[$author->email ]]" type="submit"  style="padding:0px 5px 0px 5px" class="delete_author btn-sm btn btn-danger" title="Remove Author" data-toggle="tooltip"><i class="fa fa-trash-o"></i></button>
 <a href="[[ URL::to('admin/editAuthor', array($book->book_id,$author->email)) ]]" style="padding:0px 5px 0px 5px" class="btn-sm btn btn-warning" title="Change Author Details" data-toggle="tooltip"><i class="fa fa-pencil-square-o"></i></a>
 <a href="[[ URL::to('admin/editUser', array($author->email)) ]]" style="padding:0px 5px 0px 5px" class="btn-sm btn btn-primary" title="View User Account" data-toggle="tooltip"><i class="fa fa-user"></i></a>

            </div>-->
                <br>@endforeach

            </td>

            <td style=" vertical-align: middle;">
               <a href="[[ URL::to('admin/books/edit', array($book->book_id)) ]]" class="btn-sm btn btn-warning" title="Edit Book" data-toggle="tooltip"><i class="fa fa-pencil-square-o"></i> </a>
                <a href="[[ URL::to('user/downloadBook', array($book->book_id)) ]]" class="btn-sm btn btn-success" title="Download Page" data-toggle="tooltip"><i class="fa fa-download"></i> </a>
                <a href="[[ URL::to('user/downloadBook', array($book->book_id)) ]]" class="btn-sm btn btn-primary" title="View Comments" data-toggle="tooltip"> <i class="fa fa-comment"></i> [[ $book->getNumberComments() ]]</a>

            </td>

        </tr>

        @endforeach
    </table>

</div>
<!-- /.container -->

@stop
