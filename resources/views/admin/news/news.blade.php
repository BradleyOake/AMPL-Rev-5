@extends('layouts.layout_main')
@section('title', 'Edit News')
@section('metatags')
@stop

@section('content')
<!-- main-container -->
<div class="container main-content">
    <table width="100%" class="table table-striped table-bordered ampl-table">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit News Post</h1>
            </div>
        </div>
        <hr>
       
        <tr>
            <th style="width:5%;">ID</th>
            <th style="width:25%;">Title</th>
            <th style="width:35%;">Subtopic</th>
            <th style="width:15%;">Date</th>
            <th style="width:15%;"># of Comments</th>
            <th style="width:5%;">Edit</th>
        </tr>
        
        @foreach ($news as $post)
            <tr>
                <td>[[ $post->news_id ]]</td>
                <td>[!! $post->title !!]</td>
                <td>[!! $post->subtopic !!]</td>
                <td>[[ $post->created_on ]]</td>
                <td>[[ $post->numberComments() ]]</td>
                <td><a href="[[URL::to('admin/news/editNews', $post->news_id) ]]" class="btn btn-sm btn-primary" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil-square-o"></i></a></td>
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
    $(".delete_author").click(function()
    {
        var sender =$(this);
        var book_id = sender.data("book-id");
        var email = sender.data("email");
        var title = sender.data("book-title");

        BootstrapDialog.confirm(
        {
            title: 'Confirm Remove',
            message: 'Are you sure you want to remove ' + email+ ' from ' + title + '?',
            // type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
            btnOKLabel: 'Delete', // <-- Default value is 'OK',
            btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
            callback: function(result)
            {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if(result)
                {
                    //var comment_id=$(this).attr('data-comment-id');
                    $.ajax(
                    {
                       type: "POST",
                       url: "[[URL::to('admin/authorremove')]]",
                       data:
                       {
                            book_id: book_id,
                            email: email,
                        },
                        success: function(data)
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
