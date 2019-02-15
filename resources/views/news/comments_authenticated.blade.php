     @include('modals.editcommentmodal')
    @include('modals.deletecommentmodal')
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs ampl-tabs" role="tablist">
                <li id="ampl-tab" style="width:50%;" role="presentation" class="active text-center"><a href="#home" class="btn-success" aria-controls="home" role="tab" data-toggle="tab">AMPL</a></li>
                <li style="width:50%;" role="presentation" class="text-center facebook-tab"><a href="#profile" class="btn-facebook" aria-controls="profile" role="tab" data-toggle="tab">Facebook</a></li>
            </ul>
        </div>
    </div>
    <br>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active fade-in" id="home">
            <div id="comments">
                @foreach ($post->comments->reverse() as $comment)
                    <!-- Only set commentID if there is at least 1 comment -->
                    <script>
                        var commentID = "[[ $comment->comment_id ]]";
                    </script>
                
                <div class="row">
                    <div class="col-sm-offset-3 col-sm-6">
                        
                        <strong>
                            @if( isset(Auth::user()->email) && $comment->email ==  Auth::user()->email)
                                <i style="color: green;" class="fa fa-user fa-2x"></i> [[ $comment->alias or 'anonymous' ]]
                            @else
                                <i class="fa fa-user fa-2x"></i>  [[ $comment->alias or 'anonymous' ]]
                            @endif
                        </strong>
                        
                        on [[ date( 'F j, Y', strtotime($comment->created_on)) ]]
                                  
                        @if (isset(Auth::user()->email) && Auth::user()->newsCommentReported($comment) == 1)                      
                            <a data-comment-id="[[$comment->comment_id]]" href="" class="comment-icons report_book_comment" title="Report Comment" data-toggle="tooltip">
                                <i class="fa fa-flag" style="color:red" title="You've reported this comment" data-toggle="tooltip"></i>
                            </a>
                        @elseif($comment->email ==  Auth::user()->email)
                            <!-- Edit button -->
                            <a href="#" data-comment-id="[[ $comment->comment_id ]]" class="edit_news_comment btn btn-sm btn-default" title="Edit Your Comment" data-toggle="modal" data-target="#editComment_modal" data-id="[[ DB::table('news_comment')->where('comment_id', $comment->comment_id)->pluck('text') ]]">
                                <i class="fa fa-pencil-square-o"></i> Edit
                            </a>
                            <!-- Delete button -->
                            <a href="#" data-comment-id="[[ $comment->comment_id ]]" class="delete_news_comment btn btn-sm btn-default" title="Delete" data-toggle="modal" data-target="#deleteComment_modal">
                                <i class="fa fa-pencil-square-o"></i>Delete
                            </a>                       
                        @else
                            <a data-comment-id="[[$comment->comment_id]]" href="" class="comment-icons report_book_comment" title="Report Comment" data-toggle="tooltip">
                                <i class="fa fa-flag"></i>
                            </a>
                        @endif

                        <!-- like/dislike -->
                        <div class="pull-right">

                            @if (isset(Auth::user()->email) && Auth::user()->newsCommentAgreed($comment) == 1)
                                <button id="comment_like[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberLiked()  ]]" class="like_comment btn-sm btn btn-success" title="Vote Up" data-toggle="tooltip"><i class="fa fa-thumbs-o-up"></i> ([[ $comment->numberLiked()  ]])</button>
                                <button id="comment_dislike[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberDisliked()  ]]" class="dislike_comment btn-sm btn btn-default" title="Vote Down" data-toggle="tooltip"><i class="fa fa-thumbs-o-down"></i> ([[ $comment->numberDisliked()  ]])</button>

                            @elseif (isset(Auth::user()->email) && Auth::user()->newsCommentAgreed($comment) == -1)
                                <button id="comment_like[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberLiked()  ]]" class="like_comment btn-sm btn btn-default" title="Vote Up" data-toggle="tooltip"><i class="fa fa-thumbs-o-up"></i> ([[ $comment->numberLiked()  ]])</button>
                                <button id="comment_dislike[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberDisliked()  ]]" class="dislike_comment btn-sm btn btn-danger" title="Vote Down" data-toggle="tooltip"><i class="fa fa-thumbs-o-down"></i> ([[ $comment->numberDisliked()  ]])</button>
                            @else
                                <button id="comment_like[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberLiked()  ]]" class="like_comment btn-sm btn btn-default" title="Vote Up" data-toggle="tooltip"><i class="fa fa-thumbs-o-up"></i> ([[ $comment->numberLiked()  ]])</button>
                                <button id="comment_dislike[[$comment->comment_id]]" type="submit" data-comment-id="[[$comment->comment_id]]" data-count="[[ $comment->numberDisliked()  ]]" class="dislike_comment btn-sm btn btn-default" title="Vote Down" data-toggle="tooltip"><i class="fa fa-thumbs-o-down"></i> ([[ $comment->numberDisliked()  ]])</button>

                            @endif

                        </div>
                        <br>
                        <br>
                    
                        <div class="wrapword">
                
                        <p>[[ $comment->text ]]</p>
                  
                        </div>

                        [[-- Admin/user edit buttons --]]
                        @if(false)
                            <br><br>                        
                            <div class="pull-left">
                                <a href="[[URL::to('user/editComments', $comment->comment_id) ]]" class="btn btn-sm btn-default" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                <button data-comment-id="[[$comment->comment_id]]" type="submit" class="delete_news_comment btn btn-sm btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i> Delete</button>
                            </div>
                        @endif
                    </div>
                </div>
                <hr>
                @endforeach [[-- End of comments --]]
            </div>

            <!--Addmin Comments-->
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4 text-center">
                    <h3 class="text-center">Add a Comment <i class="fa fa-comment"></i></h3>
                </div>
            </div>

            @if(Auth::check())
                <form class="form-horizontal col-sm-offset-2" method="post" id="comment_form">
                    <div class="form-group">
                        <label for="alias" class="col-sm-2 control-label">Alias</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="alias" placeholder="Optional" value="@if(isset(Auth::user()->email)) [[ Auth::user()->first_name.' '.Auth::user()->last_name ]] @endif">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comment_text" class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="5" id="comment_text" name="comment_text"></textarea>
                        </div>
                    </div>
        
                    <div class="form-group">
                        <label for="comment_text" class="col-sm-2 control-label">ReCaptcha</label>
                        <div class="col-sm-6">
                            <div class="g-recaptcha" data-sitekey="6LfayPQSAAAAAJ1wzR3WjtYkKFs-W-rWuEALmZM-"></div>
                        </div>
                    </div>

                    <div class="col-sm-10">
                        <div id="comment_error" name="comment_error" class="alert alert-danger text-center hidden"></div>
                    </div>

                    <div class="form-group text-center">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary btn-md" name="comment"><i class="fa fa-paper-plane"></i> Submit</button>
                        </div>
                    </div>
                </form>
            @else
                <br>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <a  class="btn btn-primary btn-md" data-toggle="modal" data-target="#login_modal" ><i class="fa fa-user"></i> Login</a> to AMPL to add a comment.
                    </div>
                </div>
            @endif
        </div>
        <div role="tabpanel" class="tab-pane fade" id="profile">
             <div class="row">
                <div class="col-sm-offset-3 col-sm-6">
                    <div class="fb-comments" data-href="[[ Request::url() ]]" data-numposts="5"></div>
                 </div>
            </div>
        </div>
    </div>
</div>

<script>
    //Get comment id from delete button
    $(".delete_news_comment").click(function() {
        var sender = $(this);
        window.comments_id = sender.data("comment-id");
        //alert("Comment ID: " + sender.data("comment-id"));
    });

    //Get comment id from edit button
    $(".edit_news_comment").click(function() {
        var sender = $(this);
        window.comments_id = sender.data("comment-id");
        //alert("Comment ID: " + sender.data("comment-id"));
    });

    $(document).ready(function () {
        
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
                            url: "[[URL::to('newsComment/delete')]]",
                            
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
        });    
    });
</script>