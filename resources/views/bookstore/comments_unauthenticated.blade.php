@foreach ($book->validComments->reverse() as $comment)

<div class="row">
    <div class="col-sm-offset-5 col-sm-6">
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-sm-offset-5 col-sm-6">
        <strong>
            <i class="fa fa-user fa-2x"></i>  [[ $comment->alias or 'anonymous' ]]
        </strong> on [[ date( 'F j, Y', strtotime($comment->created_on)) ]]
        
        <span class="pull-right" style="display:inline;">
            [!! $book->getUserStars($book,$comment->email) !!]
        </span>
        
        <a data-toggle="modal" data-target="#login_modal" href="#" class="comment-icons" title="Report Comment" data-toggle='tooltip'><i class="fa fa-flag"></i></a>

        <!--like/dislike-->
        <br>
        <div class="pull-right">
            <button type="submit" data-toggle="modal" href="#" data-target="#login_modal" class="like_comment btn-sm btn btn-default"  title="Like" data-toggle="tooltip"><i class="fa fa-thumbs-o-up"></i> ([[ $comment->numberLiked() ]])</button>
            <button type="submit" data-toggle="modal" href="#" data-target="#login_modal" class="dislike_comment btn-sm btn btn-default" title="Dislike" data-toggle="tooltip"><i class="fa fa-thumbs-o-down"></i> ([[ $comment->numberDisliked() ]])</button>
        </div>
       
 
        <br>[[ $comment->text ]]

        <br>
        <br>

        
    </div>
</div>

@endforeach

<div class="col-sm-offset-5 col-sm-6 text-center" id="comment_form">
    <hr>
    <h3 class="text-center">Leave a Comment <i class="fa fa-comment"></i></h3>
    <hr>
    <p><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#login_modal">Log in </a> to post a comment.</p>
</div>


