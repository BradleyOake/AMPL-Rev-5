@include('modals.editpostmodal')
@include('modals.deletepostmodal')
@include('modals.addpostmodal')

@extends('layouts.layout_main')
@if(Auth::user() && Auth::user()->role_id == 7)
    @section('title', 'AMPL Newsroom Admin Page')
@else
    @section('title', 'AMPL Newsroom')
@endif
@section('description', "Get the latest news updates from AMPL Publishing. Here is where you'll find out about new or upcoming books and their authors.")
@section('keywords', "news, updates, latest news, update, new books, more information, newsroom, blog")
@section('metatags')
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">
@stop

@section('content')

<!-- Page Content -->
<div class="container main-content">

    <div class="col-lg-12" style="display:inline;">  
        <h1 class="page-header">AMPL's Newsroom</h1>
    </div>
    
    @if(Auth::user() && Auth::user()->role_id == 7)
        <div class="col-lg-12" style="display:inline;">      
            <a href="#" class="hidden-xs btn btn-primary btn-lg pull-right hvr-grow" title="Edit" data-toggle="modal" data-target="#addPost_modal">
                <i class="fa fa-pencil-square-o"></i>Add New Post
            </a>  
        </div>            
    @endif
     


    @foreach ($newsPosts as $post)
        <div class='row'>
            <div class='col-md-8 col-md-offset-2'>
                <h2> <a style="color:black" href="[[ URL::to('newspage', $post->news_id) ]]"> [!! $post->title !!] </a> </h2>

                <p>
                    @if (strlen($post->html) > 500 )
                        <p>
                            [[ substr(strip_tags($post->html), 0, 500) ]]...
                        </p>
                    @else
                        <p>
                            [!! $post->html !!]
                        </p>
                    @endif
                    <br>

                    <div class="col-sm-12">
                        <p style="float:left;">Posted on [[ date("F d, Y",strtotime($post->created_on)) ]]</p>
                        <a style="float:right;" class="hidden-xs btn btn-primary btn-lg pull-right hvr-grow" href="[[ URL::to('newspage', $post->news_id) ]]">
                            Read More
                        </a>
                    </div>

                    @if(Auth::user() && Auth::user()->role_id == 7)
                        <div class="col-sm-12">
                            <!-- Delete button -->
                            <a href="#" class="delete_news_post btn btn-sm btn-danger pull-right" title="Delete" data-toggle="modal" data-target="#deletePost_modal" data-post-id="[[ $post->news_id ]]">
                                <i class="fa fa-pencil-square-o"></i>Delete
                            </a>

                            <!-- Edit button -->
                            <a href="#" class="edit_news_post btn btn-sm btn-default pull-right" title="Edit" data-toggle="modal" data-target="#editPost_modal" data-post-id="[[ $post->news_id ]]" data-key="[[ DB::table('news_post')->where('news_id', $post->news_id)->pluck('m_keywords') ]]" data-html="[[ DB::table('news_post')->where('news_id', $post->news_id)->pluck('html') ]]" data-desc="[[ DB::table('news_post')->where('news_id', $post->news_id)->pluck('m_description') ]]" data-sub="[[ DB::table('news_post')->where('news_id', $post->news_id)->pluck('subtopic') ]]" data-title="[[ DB::table('news_post')->where('news_id', $post->news_id)->pluck('title') ]]">
                                <i class="fa fa-pencil-square-o"></i>Edit
                            </a>
                        </div>
                    @endif
                </p>
                <br>
            </div>
        </div>
        <hr>
        <br>
    @endforeach
</div>
<!-- /.container -->

@stop
 
@section('scripts')
<script type="text/javascript">
    //Get comment id from delete button
    $(".delete_news_post").click(function() {
        var sender = $(this);
        window.posts_id = sender.data("post-id");
        //alert("Post ID: " + sender.data("post-id"));
    });

    //Get comment id from edit button
    $(".edit_news_post").click(function() {
        var sender = $(this);
        window.posts_id = sender.data("post-id");
        //alert("Post ID: " + sender.data("post-id"));
    });

    $(document).ready(function () 
    {
        //Pass db query to editPostModal*/
        $('a[data-toggle=modal], button[data-toggle=modal]').click(function () 
        {
        var data_title = '';
        var data_desc = '';
        var data_sub = '';
        var data_html = '';
        var data_key = '';

        if (typeof $(this).data('title') !== 'undefined') 
        {
        data_title = $(this).data('title');
        }      
        if (typeof $(this).data('desc') !== 'undefined') 
        {
        data_desc = $(this).data('desc');
        }
        if (typeof $(this).data('sub') !== 'undefined') 
        {
        data_sub = $(this).data('sub');
        }
        if (typeof $(this).data('html') !== 'undefined') 
        {
        data_html = $(this).data('html');
        }
        if (typeof $(this).data('key') !== 'undefined') 
        {
        data_key = $(this).data('key');
        }
        
        $('#editpost_key').val(data_key);
        $('#editpost_html').val(data_html);
        $('#editpost_sub').val(data_sub);
        $('#editpost_title').val(data_title);
        $('#editpost_description').val(data_desc);
        });


        //DELETE POST=====================================================================================  
        $("#deletepost_form").click(function()
        {

            BootstrapDialog.confirm(
            {
                title: '<i class="fa fa-trash-o"></i> Confirm Delete',
                message: 'Are you sure you want to delete this post?',
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
                                news_id: window.posts_id,
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

        //UPDATE POST=========================================================================
        $('#updatepost_form').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
        })

        .on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
            
            editpost_title = $("#editpost_title").val();
            $.ajax({
                type: "post",
                url: location.origin + "/newsPost/update",
                dataType: 'json', // expected returned data format.

                data: {
                                news_id: window.posts_id,
                                post_title: $("#editpost_title").val(),
                                post_keywords: $("#editpost_key").val(),
                                post_description: $("#editpost_description").val(),
                                post_subtopic: $("#editpost_sub").val(),
                                post_html: $("#editpost_html").val(),
                     
                },
                
                success: function (data) {
                    console.log("DATA: " + data);
                    closeAllDialogs();

                    if (data.valid == true) {
                        location.reload();
                        displaySuccessfulEditPost();

                    } else {

                        $(":submit").removeAttr("disabled");
                        $("#editpost_error").removeClass("hidden").addClass("visible");
                        $('#editpost_error').html('<i class="fa fa-exclamation-triangle"></i> ' + data.message);
                    }
                },
                error: function (xhr, status, error) {
                    closeAllDialogs();
                    console.log("ERROR: " + error);
                    $("#editpost_error").removeClass("hidden").addClass("visible");
                    $('#editpost_error').html('<i class="fa fa-exclamation-triangle"></i> ' + error);
                },
                 beforeSend: function () {
                    displayEditingPost();
                }
            });
  
            return false;
        });
        
        
        //ADD POST=========================================================================
        $('#addpost_form').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
             fields: {
                addpost_title: {
                    validators: {
                        notEmpty: {
                            message: 'A title is required'
                        }
                    }
                },
                addpost_key: {
                    validators: {
                        notEmpty: {
                            message: 'Keywords are required'
                        }
                    }
                },
                addpost_description: {
                    validators: {
                        notEmpty: {
                            message: 'A description is required'
                        }
                    }
                },
                addpost_sub: {
                    validators: {
                        notEmpty: {
                            message: 'A subtopic is required'
                        }
                    }
                },
                addpost_html: {
                    validators: {
                        notEmpty: {
                            message: 'HTML is required'
                        }
                    }
                }
            },
        })

        .on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
            
            addpost_title = $("#addpost_title").val();
            addpost_key = $("#addpost_key").val();
            addpost_description = $("#addpost_description").val();
            addpost_sub = $("#addpost_sub").val();
            addpost_html = $("#addpost_html").val();
            
            $.ajax({
                type: "post",
                url: location.origin + "/newsPost/add",
                dataType: 'json', // expected returned data format.

                data: {
                                addpost_title: $("#addpost_title").val(),
                                addpost_keywords: $("#addpost_key").val(),
                                addpost_description: $("#addpost_description").val(),
                                addpost_subtopic: $("#addpost_sub").val(),
                                addpost_html: $("#addpost_html").val(),
                     
                },
                
                success: function (data) {
                    console.log("DATA: " + data);
                    closeAllDialogs();

                    if (data.valid == true) {
                        location.reload();
                        displaySuccessfulAddPost();                       

                    } else {

                        $(":submit").removeAttr("disabled");
                        $("#addpost_error").removeClass("hidden").addClass("visible");
                        $('#addpost_error').html('<i class="fa fa-exclamation-triangle"></i> ' + data.message);
                    }
                },
                error: function (xhr, status, error) {
                    closeAllDialogs();
                    console.log("ERROR: " + error);
                    $("#editpost_error").removeClass("hidden").addClass("visible");
                    $('#editpost_error').html('<i class="fa fa-exclamation-triangle"></i> ' + error);
                },
                 beforeSend: function () {
                    displayAddingPost();
                }
            });
  
            return false;
        });
        
    });
</script>
@stop
