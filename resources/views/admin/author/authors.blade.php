@extends('layouts.layout_main')
@section('title', 'View/Edit Authors')

@section('content')
<!-- main-container -->
<div class="container main-content">
    <table width="100%" class="table table-striped table-bordered ampl-table">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">View/Edit Authors</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <p>
                    Here you can view all books with their respective authors.
                </p>
            </div>
        </div>
        <hr>

        <tr>
            <th style="text-align:right;">ID</th>
            <th>Title</th>
            <th>Author Email</th>
            <th>Name</th>
            <th style="text-align:right;">Electronic Rate</th>
            <th style="text-align:right;">Audio Rate</th>
            <th>Edit Author</th>
            <th>Add Author</th>
        </tr>

        @foreach ($books as $book)
            <tr>
                <td style="text-align:right;">[[ $book->book_id ]]</td>
                <td>[[ $book->title ]]</td>
                <!-- <td>
                    <a href="[[ URL::to('admin/editBook', array($book->book_id)) ]]" style="padding:0px 5px 0px 5px" class="btn-sm btn btn-warning" title="Edit Book" data-toggle="tooltip">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                    <a href="[[ URL::to('user/downloadBook', array($book->book_id)) ]]" style="padding:0px 5px 0px 5px" class="btn-sm btn btn-primary" title="Download Page" data-toggle="tooltip">
                        <i class="fa fa-download"></i>
                    </a>
                </td>-->
                
                <td>
                    @foreach ($book->authors as $author)
                        [[ $author->email ]]<br>
                    @endforeach
                </td>
    
                <td>
                    @foreach ($book->authors as $author)
                        [[ $author->name_on_book ]]<br>
                    @endforeach
                </td>
    
                <td style="text-align:right;">
                    @foreach ($book->authors as $author)
                        [[ $author->electronic_rate ]]%<br>
                    @endforeach
                </td>
    
                <td style="text-align:right;">
                    @foreach ($book->authors as $author)
                        [[ $author->audio_rate ]]%<br>
                    @endforeach
                </td>
    
                <td style="text-align:center;">
                    @foreach ($book->authors as $author)
                        <button data-book-id="[[$book->book_id ]]" data-book-title="[[$book->title ]]" data-email="[[$author->email ]]" type="submit" style="padding:0px 5px 0px 5px" class="delete_author btn-sm btn btn-danger" title="Remove Author" data-toggle="tooltip">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        
                        <a href="[[ URL::to('admin/editAuthor', array($book->book_id,$author->email)) ]]" style="padding:0px 5px 0px 5px" class="btn-sm btn btn-warning" title="Change Author Details" data-toggle="tooltip">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
        
                        <a href="[[ URL::to('admin/editUser', array($author->email)) ]]" style="padding:0px 5px 0px 5px" class="btn-sm btn btn-primary" title="View User Account" data-toggle="tooltip">
                            <i class="fa fa-user"></i>
                        </a>
                        <br>
                    @endforeach
                </td>

                <td class="text-center" style=" vertical-align: middle;">
                    <a href="[[ URL::to('admin/addAuthor', array($book->book_id)) ]]" title="Add an Author" data-toggle="tooltip" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="row col-lg-12 text-center">
        <br><br>
        <a class="btn btn-primary btn-lg" style="margin-left:30px;" href="[[ URL::to('admin') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Admin Panel</a>
    </div>
</div>
@stop

@section('scripts')
<script>
    // this is the id of the submit button
    $(".delete_author").click(function ()
    {
        var sender = $(this);
        var book_id = sender.data("book-id");
        var email = sender.data("email");
        var title = sender.data("book-title");

        BootstrapDialog.confirm(
        {
            title: 'Confirm Remove',
            message: 'Are you sure you want to remove ' + email + ' from ' + title + '?',
            // type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
            btnOKLabel: 'Delete', // <-- Default value is 'OK',
            btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
            callback: function (result)
            {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if (result)
                {
                    //var comment_id=$(this).attr('data-comment-id');
                    $.ajax(
                    {
                        type: "POST",
                        url: "[[URL::to('admin/authorRemove')]]",
                        data:
                        {
                            book_id: book_id,
                            email: email,
                        },
                        success: function (data)
                        {
                            location.reload();
                        }
                    });
                }
            }
        });
    });
</script>
@stop
