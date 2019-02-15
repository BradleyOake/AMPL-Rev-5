@include('modals.editcommentmodal')
@include('modals.deletecommentmodal')
@foreach ($book->validComments->reverse() as $comment)

    <div class="row">
        <div class="col-sm-offset-5 col-sm-6">

            <strong>
                @if($comment->comment_email ==  Auth::user()->email)
                    <i style="background:#00CFAF; padding:0px 5px 0px 5px" class="fa fa-user fa-2x"></i> [[ $comment->alias or 'anonymous' ]]
                @else
                    <i class="fa fa-user fa-2x"></i>  [[ $comment->alias or 'anonymous' ]]
                @endif
            </strong> on [[ date( 'F j, Y', strtotime($comment->created_on)) ]]
            
            <span class="pull-right">
                [!! $book->getUserStars($book,$comment->email) !!]
            </span>

                    
                    @if (isset(Auth::user()->email) && Auth::user()->bookCommentReported($comment) == 1) 
                        <a data-comment-id="[[$comment->comment_id]]" href="" class="comment-icons report_book_comment" title="Report Comment" data-toggle='tooltip'>
                            <i class="fa fa-flag" style="color:red" title="You've reported this comment" data-toggle='tooltip'></i> [[ $comment->numberReported() ]]
                        </a>                                          
                    @else
                        <a data-comment-id="[[$comment->comment_id]]" href="" class="comment-icons report_book_comment" title="Report Comment" data-toggle='tooltip'>
                            <i class="fa fa-flag"></i> [[ $comment->numberReported() ]]
                        </a>
                    @endif
            <br>
            <div class="pull-right" style="display:inline;">                                
                        @if (isset(Auth::user()->email) && Auth::user()->bookCommentAgreed($comment) == 1)
                            <button id="comment_like[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberLiked()  ]]" class="like_comment btn-sm btn btn-success" title="Vote Up" data-toggle="tooltip"><i class="fa fa-thumbs-o-up"></i> ([[ $comment->numberLiked()  ]])</button>
                            <button id="comment_dislike[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberDisliked()  ]]" class="dislike_comment btn-sm btn btn-default" title="Vote Down" data-toggle="tooltip"><i class="fa fa-thumbs-o-down"></i> ([[ $comment->numberDisliked()  ]])</button>

                        @elseif (isset(Auth::user()->email) && Auth::user()->bookCommentAgreed($comment) == -1)
                            <button id="comment_like[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberLiked()  ]]" class="like_comment btn-sm btn btn-default" title="Vote Up" data-toggle="tooltip"><i class="fa fa-thumbs-o-up"></i> ([[ $comment->numberLiked()  ]])</button>
                            <button id="comment_dislike[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberDisliked()  ]]" class="dislike_comment btn-sm btn btn-danger" title="Vote Down" data-toggle="tooltip"><i class="fa fa-thumbs-o-down"></i> ([[ $comment->numberDisliked()  ]])</button>
                        @else
                            <button id="comment_like[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberLiked()  ]]" class="like_comment btn-sm btn btn-default" title="Vote Up" data-toggle="tooltip"><i class="fa fa-thumbs-o-up"></i> ([[ $comment->numberLiked()  ]])</button>
                            <button id="comment_dislike[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberDisliked()  ]]" class="dislike_comment btn-sm btn btn-default" title="Vote Down" data-toggle="tooltip"><i class="fa fa-thumbs-o-down"></i> ([[ $comment->numberDisliked()  ]])</button>
                        @endif
                    </div>
            
            <br>[[ $comment->text ]]<br><br>
                       
            <div class="pull-left">
                <!-- Edit button -->
                <a href="#" class="edit_book_comment btn btn-sm btn-default" title="Edit" data-toggle="modal" data-target="#editComment_modal" data-comment-id="[[ $comment->comment_id ]]" data-id="[[ DB::table('book_comment')->where('comment_id', $comment->comment_id)->where('book_id', $book->book_id)->pluck('text') ]]">
                    <i class="fa fa-pencil-square-o"></i>Edit
                </a>
               <!-- Delete button -->
               <a href="#" class="delete_book_comment btn btn-sm btn-danger" title="Delete" data-toggle="modal" data-target="#deleteComment_modal" data-comment-id="[[ $comment->comment_id ]]">
                    <i class="fa fa-pencil-square-o"></i>Delete
                </a>
                
            </div>

      
        </div>
    </div>
    <br>
  @endforeach
  
  @if(!Auth::user()->bookCommentExists($book,Auth::user()->email))
  
            <div class="row">
                <div class="col-sm-offset-6 col-sm-4 text-center">
                    <hr>
                    <h3 class="text-center">Leave a Comment <i class="fa fa-comment"></i></h3>
                </div>
            </div>

            <form class="form-horizontal col-sm-offset-4" method="post" id="comment_form">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="name" placeholder="Optional" value="[[ Auth::user()->first_name.' '.Auth::user()->last_name ]]" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="comment_rating" class="col-sm-2 control-label">Rating</label>
                    <div class="col-sm-2">
                        <select class="form-control" id="comment_rating" name="comment_rating">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option selected value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="comment_text" class="col-sm-2 control-label">Comment</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="5" id="comment_text" name="comment_text"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="comment_text" class="col-sm-2 control-label">ReCaptcha</label>
                    <div class="col-sm-6">
                         <div class="g-recaptcha" data-sitekey="6LfayPQSAAAAAJ1wzR3WjtYkKFs-W-rWuEALmZM-">
                         </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div id="comment_error" name="comment_error" class="alert alert-danger text-center hidden">
                    </div>
                </div>
                
                <div class="form-group text-center">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-md" name="comment">
                            <i class="fa fa-paper-plane"></i> Submit
                        </button>
                    </div>
                </div>
            </form>
    </div>
       
   @else
            <div class="row">
                <div class="col-sm-offset-5 col-sm-6">       
                    <hr>
                </div>

                <div class="col-sm-offset-6 col-sm-6">              
                    <div class="thanks">
                        Thank you for leaving a comment!
                    </div>
                </div>
            </div>
        @endif



<script>
    //Get comment id from delete button
    $(".delete_book_comment").click(function() {
        var sender = $(this);
        window.comments_id = sender.data("comment-id");
        //alert("Comment ID: " + sender.data("comment-id"));
    });
    
    //Get comment id from edit button
    $(".edit_book_comment").click(function() {
        var sender = $(this);
        window.comments_id = sender.data("comment-id");
        //alert("Comment ID: " + sender.data("comment-id"));
    });

    $(document).ready(function ()
    {
        var bookID = "[[ $book->book_id ]]"; // used to ste the var to be passed through ajax call
       

        /*Pass db query to editCommentModal*/
        $('a[data-toggle=modal], button[data-toggle=modal]').click(function ()
        {
            data_id = '';
            if (typeof $(this).data('id') !== 'undefined')
            {
                data_id = $(this).data('id');
            }

            $('#editcomment_text').val(data_id);
        });
        
        
        //SUBMIT COMMENT====================================================================================
        $('#comment_form').bootstrapValidator(
        {
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                email:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Email is required'
                        },
                        regexp:
                        {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'Not a valid email address'
                        }
                    }
                },
                comment_text:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'A comment is required'
                        }
                    }
                }
            },
        })
        .on('success.form.bv', function (e)
        {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            $.ajax(
            {
                type: "post",
                url: location.origin + "/bookComment/submit",
                dataType: 'json', // expected returned data format.
                data:
                {
                    book_id: bookID,
                    email: $("#email").val(),
                    name: $("#name").val(),
                    comment_text: $("#comment_text").val(),
                    comment_rating: $("#comment_rating").val(),
                    comment_recaptcha: $("#g-recaptcha-response").val()
                },
                success: function (data)
                {
                    console.log(data);
                    closeAllDialogs();

                    if (data.valid == true)
                    {
                        location.reload();
                        displaySuccessfulComment();
                    }
                    else
                    {
                        $(":submit").removeAttr("disabled");
                        $("#comment_error").removeClass("hidden").addClass("visible");
                        $('#comment_error').html('<i class="fa fa-exclamation-triangle"></i> ' + data.message);
                    }
                },
                error: function (xhr, status, error)
                {
                    closeAllDialogs();
                    console.log(error);
                    $("#comment_error").removeClass("hidden").addClass("visible");
                    $('#comment_error').html('<i class="fa fa-exclamation-triangle"></i> ' + error);

                },
                beforeSend: function ()
                {
                    displaySendingComment();
                }
            });

            return false;
        });
        
         //DELETE COMMENT======================================================================================   
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
                                url: "[[URL::to('bookComment/delete')]]",
                                data:
                                {
                                    comment_id: window.comments_id,
                                },
                                success: function(data)
                                {
                                    location.reload();               
                                }
                            });
                        }
                    }
                });

            //return false; // avoid to execute the actual submit of the form.
        });
        
        
        
        //EDIT COMMENT=========================================================================================
        $('#editcomment_form').bootstrapValidator(
        {
            /*feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },*/
            fields:
            {
                editcomment_text:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'A comment is required'
                        }
                    }
                }
            },
        })
        .on('success.form.bv', function (e)
        {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            editcomment_text = $("#editcomment_text").val();

            $.ajax(
            {
                type: "post",
                url: location.origin + "/bookComment/update",
                dataType: 'json', // expected returned data format.
                data:
                {
                    editcomment_text: $("#editcomment_text").val(),
                    book_id: bookID,
                    comment_id: window.comments_id,
                    editcomment_rating: $("#editcomment_rating").val(),
                },
                success: function (data)
                {
                    console.log("DATA: " + data);
                    closeAllDialogs();

                    if (data.valid == true)
                    {
                        location.reload();
                        displaySuccessfulEdit();
                    }
                    else
                    {
                        /*document.getElementById("editcomment_form").style.display = "block";
                        $('#editcomment_form').data('bootstrapValidator').resetForm();
                        $('#editcomment_form')[0].reset();
                        $("#editform_message").html("");*/

                        $(":submit").removeAttr("disabled");
                        $("#editcomment_error").removeClass("hidden").addClass("visible");
                        $('#editcomment_error').html('<i class="fa fa-exclamation-triangle"></i> ' + data.message);
                    }
                },
                error: function (xhr, status, error)
                {
                    closeAllDialogs();
                    console.log("ERROR: " + error);
                    $("#editcomment_error").removeClass("hidden").addClass("visible");
                    $('#editcomment_error').html('<i class="fa fa-exclamation-triangle"></i> ' + error);
                },
                beforeSend: function ()
                {
                    displayEditingComment();
                }
            });

            return false;
        });
        
        
        //LIKE COMMENT===========================================================================================
        $(".like_comment").click(function ()
        {
            var sender = $(this);

            $.ajax(
            {
                type: "POST",
                url: "[[URL::to('bookComment/agree')]]",
                data:
                {
                    comment_id: sender.data("comment-id"),
                },
                success: function (data)
                {
                    var like_id = "#comment_like" + sender.data("comment-id"); // the like button id
                    var dislike_id = "#comment_dislike" + sender.data("comment-id");  // the dislike button id

                    if ($(dislike_id).hasClass("btn-danger"))
                    { // changing
                        console.log("Changing to like");
                        $(like_id).html('<i class="fa fa-thumbs-o-up"> (' + (parseInt($(like_id).data("count")) + 1) + ')');
                        $(dislike_id).html('<i class="fa fa-thumbs-o-down"> (' + (parseInt($(dislike_id).data("count")) - 1) + ')');

                        $(like_id).data('count', (parseInt($(like_id).data("count")) + 1));
                        $(dislike_id).data('count', (parseInt($(dislike_id).data("count")) - 1));
                    }
                    else if ($(like_id).hasClass("btn-default"))
                    { // new
                        console.log("New like");
                        $(like_id).html('<i class="fa fa-thumbs-o-up"> (' + (parseInt($(like_id).data("count")) + 1) + ')');
                        $(like_id).data('count', (parseInt($(dislike_id).data("count")) + 1));
                    }

                    $(like_id).removeClass().addClass('btn btn-sm btn-success');
                    $(dislike_id).removeClass().addClass('btn btn-sm btn-default');
                }
            });
        });
        
        
        //DISLIKE COMMENT==========================================================================================
        $(".dislike_comment").click(function ()
        {
            var sender = $(this);
            console.log('Dislike comment id: ' + sender.data("comment-id"));

            $.ajax(
            {
                type: "POST",
                url: "[[URL::to('bookComment/disagree')]]",
                data:
                {
                    comment_id: sender.data("comment-id"),
                },
                success: function (data)
                {

                    var like_id = "#comment_like" + sender.data("comment-id");
                    var dislike_id = "#comment_dislike" + sender.data("comment-id");

                    if ($(like_id).hasClass("btn-success"))
                    { // changing
                        console.log("Changing to dislike");
                        $(dislike_id).html('<i class="fa fa-thumbs-o-down"> (' + (parseInt($(dislike_id).data("count")) + 1) + ')');
                        $(like_id).html('<i class="fa fa-thumbs-o-up"> (' + (parseInt($(like_id).data("count")) - 1) + ')');

                        $(dislike_id).data('count', (parseInt($(dislike_id).data("count")) + 1));
                        $(like_id).data('count', (parseInt($(like_id).data("count")) - 1));

                    }
                    else if ($(dislike_id).hasClass("btn-default"))
                    { // new
                        console.log("New dislike");
                        $(dislike_id).html('<i class="fa fa-thumbs-o-down"> (' + (parseInt($(dislike_id).data("count")) + 1) + ')');
                        $(dislike_id).data('count', (parseInt($(dislike_id).data("count")) + 1));

                    }

                    $("#comment_like" + sender.data("comment-id")).removeClass().addClass('btn btn-sm btn-default');
                    $("#comment_dislike" + sender.data("comment-id")).removeClass().addClass('btn btn-sm btn-danger');
                }
            });
        });
        
        
        //REPORT COMMENT===================================================================================================
        $(".report_book_comment").click(function()
        {
            var sender =$(this);
            var comment_id = sender.data("comment-id");

            BootstrapDialog.confirm(
            {
                title: '<i class="fa fa-flag"></i> Report Comment',
                message: 'Are you sure you want to report this comment?',
                type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                closable: true, // <-- Default value is false
                draggable: true, // <-- Default value is false
                btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
                btnOKLabel: 'Report', // <-- Default value is 'OK',
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
                            url: "[[URL::to('bookComment/report')]]",
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

            //return false; // avoid to execute the actual submit of the form.
        });
        
        
    });
</script>
