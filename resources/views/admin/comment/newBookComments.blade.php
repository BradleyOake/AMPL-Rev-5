@extends('layouts.layout_main')
@section('title', 'New Book Comments')
@section('metatags')
@stop

@section('content')
<div class="container main-content">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Approve New Book Comments</h1>
        </div>
    </div>

    @if( count($comments) > 0 )
        @foreach($comments as $comment)
            <div class="row">
                <div class="col-sm-center">
                    <p>
                        <strong>Book:</strong> <a href="[[URL::to('bookpage', $comment->book_id)]]">[[ DB::table('book')->where('book_id', $comment->book_id)->pluck('title') ]]</a><br>
                        <strong>Given Name:</strong> [[ $comment->alias ]]<br>
                        <strong>Comment:</strong> [[ $comment->text ]]<br>
                        <strong>Date: </strong>[[ date('F j, Y \a\t g:ia', strtotime($comment->created_on)) ]]<br>
                        <strong>Rating: </strong>[[ $comment->rating ]]
                    </p>

                    <button class="comment_remove btn btn-danger" data-id="[[ $comment->comment_id ]]">
                        <i class="fa fa-trash"></i> Remove
                    </button>
                    &nbsp;
                    <button class="comment_approve btn btn-success" data-id="[[ $comment->comment_id ]]">
                        <i class="fa fa-check"></i> Approve
                    </button>
                </div>
            </div>
            <hr>
        @endforeach
    @else
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center">No New Comments</h2>
            </div>
        </div>
    @endif

    <div class="row col-lg-12 text-center">
        <br><br>
        <a class="btn btn-primary btn-lg" style="margin-left:30px;" href="[[ URL::to('admin') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Admin Panel</a>
    </div>
</div>
@stop

@section('scripts')
<script>
    // this is the id of the submit button
    $(".comment_remove").click(function()
    {
        var sender =$(this);
        var comment_id = sender.data("id");

        BootstrapDialog.confirm(
        {
            title: '<i class="fa fa-trash-o"></i> Confirm Delete',
            message: 'Are you sure you want to delete this comment?',
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
                        url: "[[URL::to('bookComment/delete')]]",
                        data:
                        {
                            comment_id: comment_id,
                        },
                        success: function(data)
                        {
                            location.reload();
                        }
                    });
                }
            }
        });
    
        // return false; // avoid to execute the actual submit of the form.
    });

    // this is the id of the submit button
    $(".comment_approve").click(function()
    {
        var sender =$(this);
        var comment_id = sender.data("id");
        // var comment_id=$(this).attr('data-comment-id');

        $.ajax(
        {
            type: "POST",
            url: "[[URL::to('bookComment/approve')]]",
            data:
            {
                comment_id: comment_id,
            },
            success: function(data)
            {
                location.reload();
            }
        });
    });
</script>
@stop
