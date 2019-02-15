@extends('layouts.layout_main')
@section('title', 'AMPL Newsroom Admin Page')
@section('description', "Get the latest news updates from AMPL Publishing. Here is where you'll find out about new or upcoming books and their authors.")
@section('keywords', "news, updates, latest news, update, new books, more information, newsroom, blog")
@section('metatags')
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">
@stop

@section('content')

    <!-- Page Content -->
    <div class="container main-content">
        <div class="col-lg-12">
            <h1 class="page-header">AMPL's Newsroom</h1>
        </div>

        @foreach ($newsPosts as $post)
            <div class='row'>
                <div class='col-md-8 col-md-offset-2'>
                    <h2> [!! $post->title !!] </h2>
                    <br>
                    <p>
                        <a class="hidden-xs btn btn-primary pull-right" style="margin:20px" href="[[ URL::to('newspage', $post->news_id) ]]">Read More</a>
                        <a style="color:black" href="[[ URL::to('newspage', $post->news_id) ]]"> [!! $post->subtopic !!]</a>
                    </p>
                    <br>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-8 col-md-offset-2'>
                    <span style='color:grey'>Posted on [[ date("F d, Y",strtotime($post->created_on)) ]]</span>
                    <div class="pull-right">
                        <!-- Edit button -->
                        <a href="#" class="edit_news_post btn btn-sm btn-default" title="Edit" data-toggle="modal" data-target="#editPost_modal" data-post-id="[[ $post->news_id ]]" data-id="[[ DB::table('news_post')->where('news_id', $post->news_id)->pluck('subtopic') ]]">
                            <i class="fa fa-pencil-square-o"></i>Edit
                        </a>
                        <!-- Delete button -->
                        <a href="#" class="delete_news_post btn btn-sm btn-danger" title="Delete" data-toggle="modal" data-target="#deletePost_modal" data-post-id="[[ $post->news_id ]]">
                            <i class="fa fa-pencil-square-o"></i>Delete
                        </a>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    @endforeach

@stop


@section('javascripts')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4&appId=726168714129895";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>
    //Get comment id from delete button
    $(".delete_news_post").click(function() {
        var sender = $(this);
        window.posts_id = sender.data("post-id");
        alert("Post ID: " + sender.data("post-id"));
    });

    //Get comment id from edit button
    $(".edit_news_post").click(function() {
        var sender = $(this);
        window.posts_id = sender.data("post-id");
        alert("Post ID: " + sender.data("post-id"));
    });

    $(document).ready(function () 
    {
        //Pass db query to editCommentModal*/
        $('a[data-toggle=modal], button[data-toggle=modal]').click(function () 
        {
        var data_id = '';

        if (typeof $(this).data('id') !== 'undefined') 
        {
        data_id = $(this).data('id');
        }

        $('#editcomment_text').val(data_id);
        });


        //Delete Comment  
        $("#deletecomment_form").click(function()
        {
            var sender =$(this);
            var comment_id = sender.data("comment-id");

            BootstrapDialog.confirm(
            {
                title: '<i class="fa fa-trash-o"></i> Confirm Delete',
                message: 'Are you sure you want to delete your post?',
                //type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
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
                            url: "[[URL::to('newsPost/delete')]]",

                            data:
                            {
                                comment_id: window.posts_id,
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
    });
</script>
@stop
