    /*
     *  Sends the news post to be liked by the user
     */
    $(".like_news_comment").click(function () {
        console.log('test');
    }); < /script> < script >
        /*
         *  Sends the news post to be disliked by the user
         */
        $(".dislike_news_comment").click(function () {
            var sender = $(this);

            $.ajax({
                type: "POST",
                url: "{{URL::to('newsComment/disagree')}}",
                data: {
                    comment_id: sender.data("comment-id"),
                },
                success: function (data) {
                    location.reload();
                }
            });
        });

    /*
     *  Sends the news post to be liked by the user
     */
    $(".delete_news_comment").click(function () {

        var sender = $(this);

        BootstrapDialog.confirm({
            title: '<i class="fa fa-trash-o"></i> Confirm Delete',
            message: 'Are you sure you want to delete your post?',
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
            btnOKLabel: 'Delete', // <-- Default value is 'OK',
            btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
            callback: function (result) {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if (result) {

                    //var comment_id=$(this).attr('data-comment-id');
                    $.ajax({
                        type: "POST",
                        url: "{{URL::to('newsComment/delete')}}",
                        data: {
                            comment_id: sender.data("comment-id"),
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
            }
        });
    });

    /*
     *  Sends the news post to be reported by the user
     */
    $(".report_news_comment").click(function () {

        var sender = $(this);

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

                    //var comment_id=$(this).attr('data-comment-id');
                    $.ajax({
                        type: "POST",
                        url: "{{URL::to('newsComment/report')}}",
                        data: {
                            comment_id: sender.data("comment-id"),
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
            }
        });
    });

    $(document).ready(function () {


        $('#comment_form').bootstrapValidator({

                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    comment_email: {
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

                comment_email = $("#comment_email").val();
                comment_alias = $("#comment_alias").val();
                comment_text = $("#comment_text").val();
                comment_recaptcha = $("#g-recaptcha-response").val();

                $.ajax({
                    type: "post",
                    url: public_path + "newsComment/submit",
                    dataType: 'json', // expected returned data format.
                    data: {
                        newsid: newsID,
                        comment_email: comment_email,
                        comment_alias: comment_alias,
                        comment_text: comment_text,
                        comment_recaptcha: comment_recaptcha
                    },
                    success: function (data) {

                        if (data.valid == true) {
                            location.reload();
                        } else {
                            document.getElementById("comment_form").style.display = "block";
                            $('#comment_form').data('bootstrapValidator').resetForm();
                            $('#comment_form')[0].reset();
                            $("#form_message").html("");

                            BootstrapDialog.show({
                                title: '<i class="fa fa-exclamation-circle"></i> Alert',
                                message: 'Please complete the ReCaptcha',
                                buttons: [{
                                    label: 'Close',
                                    cssClass: 'btn-primary',
                                    action: function (dialogRef) {
                                        dialogRef.close();
                                    }
                            }]
                            });
                        }
                    },
                    beforeSend: function () {
                        document.getElementById("comment_form").style.display = "none";
                        $("#form_message").html("<br><br><br><h3>Submitting your comment...</h3><br><i class=\"fa fa-5x  fa-spinner fa-spin\"></i><br>")
                    }
                });
                return false;

            });
    });
