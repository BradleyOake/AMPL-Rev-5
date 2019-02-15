@extends('layouts.layout_main')
@section('title')[[ $post->title ]]@stop
@section('description')[[ $post->m_description]] @stop
@section('keywords') [[ $post->m_keywords ]]@stop

@section('content')
<div class="container main-content">

    <div class="col-lg-12">
        <h1 class="page-header">[!! $post->title !!]</h1>
    </div>

    <div class="row" style="margin-top:20px">
        <div class="col-xs-10 col-sm-offset-1">
            <p>
                @if ($post->image == true)
                    <img width="200" align="[[$post->image_align]]" src="[[URL::asset('images/news/'.$post->news_id.'/image-'.$post->news_id.'.gif')]]" />
                @endif

                [!! $post->html !!]
            </p>
        </div>
    </div>
    
[!! $comments !!]


@stop [[-- End of content --]]

@section('scripts')
<script>
    var newsID = [[$post->news_id]]
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5&appId=726168714129895";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<script>
$(document).ready(function () {
    
    /*Pass db query to editCommentModal*/
  $('a[data-toggle=modal], button[data-toggle=modal]').click(function () {

    var data_id = '';

    if (typeof $(this).data('id') !== 'undefined') {

      data_id = $(this).data('id');
    }

    $('#editcomment_text').val(data_id);
  })

    /*
     *  Sends the news comment to be liked by the user
     */
    $(".like_comment").click(function () {
        var sender = $(this);

        $.ajax({
            type: "POST",
            url: "[[URL::to('newsComment/agree')]]",
            data: {
                comment_id: sender.data("comment-id"),
            },
            success: function (data) {
               
               var like_id = "#comment_like" + sender.data("comment-id"); // the like button id
                var dislike_id = "#comment_dislike" + sender.data("comment-id");  // the dislike button id

                if ($(dislike_id).hasClass("btn-danger")) { // changing
                    console.log("Changing to like");
                    $(like_id).html('<i class="fa fa-thumbs-o-up"> (' + (parseInt($(like_id).data("count")) + 1) + ')');
                    $(dislike_id).html('<i class="fa fa-thumbs-o-down"> (' + (parseInt($(dislike_id).data("count"))-1) + ')');

                    $(like_id).data('count', (parseInt($(like_id).data("count")) + 1));
                    $(dislike_id).data('count', (parseInt($(dislike_id).data("count")) - 1));
                } else if ($(like_id).hasClass("btn-default")) { // new
                    console.log("New like");
                    $(like_id).html('<i class="fa fa-thumbs-o-up"> (' + (parseInt($(like_id).data("count")) + 1) + ')');
                    $(like_id).data('count', (parseInt($(dislike_id).data("count")) + 1));
                }

                $(like_id).removeClass().addClass('btn btn-sm btn-success');
                $(dislike_id).removeClass().addClass('btn btn-sm btn-default');
            }
        });
    });

    /*
     *  Sends the news comment to be disliked by the user
     */
    $(".dislike_comment").click(function () {
        var sender = $(this);

        console.log('Dislike comment id: ' + sender.data("comment-id"));

        $.ajax({
            type: "POST",
            url: "[[URL::to('newsComment/disagree')]]",
            data: {
                comment_id: sender.data("comment-id"),
            },
            success: function (data) {

                var like_id = "#comment_like" + sender.data("comment-id");
                var dislike_id = "#comment_dislike" + sender.data("comment-id");

                if ($(like_id).hasClass("btn-success")) { // changing
                    console.log("Changing to dislike");
                    $(dislike_id).html('<i class="fa fa-thumbs-o-down"> (' + (parseInt($(dislike_id).data("count")) + 1) + ')');
                    $(like_id).html('<i class="fa fa-thumbs-o-up"> (' + (parseInt($(like_id).data("count"))-1) + ')');

                    $(dislike_id).data('count', (parseInt($(dislike_id).data("count")) + 1));
                    $(like_id).data('count', (parseInt($(like_id).data("count")) - 1));

                } else if ($(dislike_id).hasClass("btn-default")) { // new
                    console.log("New dislike");
                    $(dislike_id).html('<i class="fa fa-thumbs-o-down"> (' + (parseInt($(dislike_id).data("count")) + 1) + ')');
                    $(dislike_id).data('count', (parseInt($(dislike_id).data("count")) + 1));

                }
                $("#comment_like" + sender.data("comment-id")).removeClass().addClass('btn btn-sm btn-default');
                $("#comment_dislike" + sender.data("comment-id")).removeClass().addClass('btn btn-sm btn-danger');

            }
        });
    });


    /*
     *  Sends the news post to be reported by the user
     */
    $(".report_news_comment").click(function () {

     var sender = $(this);
     console.log('Report comment id: ' + sender.data("comment-id"));
     var report_id = "#comment_report" + sender.data("comment-id");

     if ($(report_id).hasClass("text-danger")) {
         $(report_id).removeClass().addClass('text-default');
         $(report_id).attr('title', "Report this comment");
     } else {
         BootstrapDialog.confirm({
             title: '<i class="fa fa-flag"></i> Report Comment',
             message: 'Are you sure you want to report this comment?',
             type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
             closable: true, // <-- Default value is false
             draggable: true, // <-- Default value is false
             btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
             btnOKLabel: 'Report', // <-- Default value is 'OK',
             btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
             callback: function (result) {
                 // result will be true if button was click, while it will be false if users close the dialog directly.
                 if (result) {
                     console.log('Confirmed');
                     //var comment_id=$(this).attr('data-comment-id');
                     $.ajax({
                         type: "POST",
                         url: "[[URL::to('newsComment/report')]]",
                         data: {
                             comment_id: sender.data("comment-id"),
                         },
                         success: function (data) {

                            closeAllDialogs();
                            
                            BootstrapDialog.show({
                                size: BootstrapDialog.SIZE_SMALL,
                                title: '<i class="fa fa-check-circle"></i> Comment Reported',
                                message: '<div class="text-center">The comment has been reported us. Thank you for your feedback!</div>',
                                closable: true, // <-- Default value is false
                                draggable: true, // <-- Default value is false
                                btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
                                btnOKLabel: 'Report', // <-- Default value is 'OK',
                            });
                            $(report_id).attr('title', "You've reported this comment");
                            $(report_id).removeClass().addClass("text-danger");
                            
                         }
                     });
                 }
             }
         });
     }
 });

    //Comment
    $('#comment_form').bootstrapValidator({

            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Email is required'
                        },
                        regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'Not a valid email address'
                        }
                    }
                },
                comment_text: {
                    validators: {
                        notEmpty: {
                            message: 'A comment is required'
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

            $.ajax({
                type: "post",
                url: location.origin + "/newsComment/submit",
                dataType: 'json', // expected returned data format.
                data: {
                    news_id: newsID,
                    email: $("#email").val(),
                    alias: $("#alias").val(),
                    comment_text: $("#comment_text").val(),
                    comment_recaptcha: $("#g-recaptcha-response").val()
                },
                success: function (data) {
    
                    console.log(data);
                    closeAllDialogs();

                    if (data.valid == true) {

                        location.reload();
                        displaySuccessfulComment();

                    } else {
                        $(":submit").removeAttr("disabled");
                        $("#comment_error").removeClass("hidden").addClass("visible");
                        $('#comment_error').html('<i class="fa fa-exclamation-triangle"></i> ' + data.message);
                    }
                },
                error: function (xhr, status, error) {

                    closeAllDialogs();
                    console.log(error);
                    $("#comment_error").removeClass("hidden").addClass("visible");
                    $('#comment_error').html('<i class="fa fa-exclamation-triangle"></i> ' + error);

                },
                beforeSend: function () {
                    displaySendingComment();
                }
            });
            return false;

        });
        
        
        //Function for editcomment
        $('#editcomment_form').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                editcomment_text: {
                    validators: {
                        notEmpty: {
                            message: 'A comment is required'
                        }
                    }
                }
            },
        })

        .on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            console.log("1");

            // Get the form instance
            var $form = $(e.target);

            console.log("2");

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            console.log("3");

            editcomment_text = $("#editcomment_text").val();

            console.log("4");

            $.ajax({
                type: "post",
                //console.log("5");
                url: location.origin + "/newsComment/update",
                //console.log("6");
                dataType: 'json', // expected returned data format.
                //console.log("7");
                data: {
                    editcomment_text: $("#editcomment_text").val(),
                    news_id: newsID,
                    comment_id: window.comments_id,
                     
                    //console.log("8");
                },
                success: function (data) {
                    console.log("DATA: " + data);
                    console.log("9");
                    closeAllDialogs();
                    console.log("10");

                    if (data.valid == true) {
                        location.reload();
                        console.log("11");
                        displaySuccessfulEdit();
                        console.log("12");
                    } else {
                        /*document.getElementById("editcomment_form").style.display = "block";
                        $('#editcomment_form').data('bootstrapValidator').resetForm();
                        $('#editcomment_form')[0].reset();
                        $("#editform_message").html("");*/

                        $(":submit").removeAttr("disabled");
                        console.log("13");
                        $("#editcomment_error").removeClass("hidden").addClass("visible");
                        console.log("14");
                        $('#editcomment_error').html('<i class="fa fa-exclamation-triangle"></i> ' + data.message);
                        console.log("15");
                    }
                },
                error: function (xhr, status, error) {
                    closeAllDialogs();
                    console.log("16");
                    console.log("ERROR: " + error);
                    console.log("17");
                    $("#editcomment_error").removeClass("hidden").addClass("visible");
                    console.log("18");
                    $('#editcomment_error').html('<i class="fa fa-exclamation-triangle"></i> ' + error);
                    console.log("19");
                },
                beforeSend: function () {
                    displayEditingComment();
                    console.log("20");
                }
            });
            console.log("21");
            return false;
        });
});
</script>

<script>
$(".report_book_comment").click(function() {

    var sender =$(this);
    var comment_id = sender.data("comment-id");

     BootstrapDialog.confirm({
            title: '<i class="fa fa-flag"></i> Report Comment',
            message: 'Are you sure you want to report this comment?',
            type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
            btnOKLabel: 'Report', // <-- Default value is 'OK',
            btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
            callback: function(result) {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if(result) {

                     //var comment_id=$(this).attr('data-comment-id');
                    $.ajax({
                       type: "POST",
                       url: "[[URL::to('newsComment/report')]]",
                       data: {
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
</script>



@stop [[-- End of javascripts --]]
