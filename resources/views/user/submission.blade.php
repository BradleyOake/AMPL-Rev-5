@extends('layouts.layout_main')
@section('title', 'AMPL Homepage')
@section('metaDescription', '')

@section('content')

<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-pencil"></i> Manuscript Upload</h1>
    </div>

    <div class="col-lg-12 text-center">
        <p>Upload a synopsis and three chapters of your book to AMPL here</p>
    </div>
    <br>

    <div class="col-lg-12">
        <form id="submission_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data" data-bv-message="This value is not valid" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
            <fieldset>
                <legend class="text-center">Book Information</legend>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Book Title</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" name="title" id="title" required />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Author Name</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" name="author" id="author" required value="[[ Auth::user()->first_name ]] [[ Auth::user()->last_name ]]" readonly />
                    </div>
                </div>
            </fieldset>
            <br>

            <fieldset>
                <legend class="text-center">File Upload</legend>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Synopsis</label>
                    <div class="col-sm-4">
                        <input type="file" name="synopsis" id="synopsis" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Chapters</label>
                    <div class="col-sm-4">
                        <input type="file" name="chapters" id="chapters" required>
                    </div>
                </div>
            </fieldset>
            <br>

            <div class="form-group">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-primary btn-md" style="margin-top:20px">
                        Submit My Book
                    </button>
                </div>
            </div>
        </form>

        <div class="col-sm-12 text-center">
            <p id="form_message" name="form_message">
            </p>
        </div>
    </div>
</div>
@stop

 @section('scripts')
<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#submission_form').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                title:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Please enter the title of your book'
                        },
                        regexp:
                        {
                            regexp: /^[a-zA-Z0-9_\'\"\s\#\(\)\@\*\&\$\!\.\,\-\_\:\/]+$/,
                            message: 'The title cannot contain special characters'
                        }
                    }
                },
                author:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Please enter your name as you want it to appear on your book'
                        }
                    }
                },
                synopsis:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Please enter a brief synopsis of your book'
                        },
                        file:
                        {
                            extension: 'doc,docx,pdf,txt',
                            type: 'application/msword,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            maxSize: 100000000,   // 2048 * 1024
                            message: 'Please enter a .doc, .docx, or .txt'
                        }
                    }
                },
                chapters:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Please enter at least 3 chapters of your book'
                        },
                        file:
                        {
                            extension: 'doc,docx,txt,pdf,',
                            type: 'application/msword,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            maxSize: 100000000,   // 2048 * 1024
                            message: 'Please enter a .doc, .docx, or .txt'
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
                type: "POST",
                url: base_url + "/user/bookSubmission",
                dataType: 'json', // expected returned data format.

                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data)
                {
                    if(data.valid === 'true')
                    {
                        $($form)[0].reset();
                        $($form).data('bootstrapValidator').resetForm();

                        $.each(BootstrapDialog.dialogs, function(id, dialog)
                        {
                            dialog.close();
                        });

                        BootstrapDialog.show(
                        {
                            title: '<i class="fa fa-check-circle"></i> Thank you for book submission!',
                            message: 'Your book has successfully been submitted for review.',
                            closable: true,
                            cssClass: 'ampl-dialog',
                            buttons: [
                            {
                                label: 'Close',
                                action: function(dialogItself)
                                {
                                    dialogItself.close();
                                }
                            }]
                        });
                    }
                    else
                    {
                        $.each(BootstrapDialog.dialogs, function(id, dialog)
                        {
                            dialog.close();
                        });

                        BootstrapDialog.show(
                        {
                            title: '<i class="fa fa-exclamation-circle"></i> An Error Occured',
                            message: 'Sorry, an error occured when submitting your book.',
                            closable: true,
                            cssClass: 'ampl-dialog',
                            buttons: [
                            {
                                label: '<i class="fa fa-arrow-left"></i> Back',
                                cssClass: 'pull-left btn-danger',
                                action: function()
                                {
                                    window.location.replace(document.referrer);
                                }
                            },
                            {
                                label: 'Close',
                                action: function(dialogItself)
                                {
                                    dialogItself.close();
                                }
                            }]
                        });
                    }
                },
                error: function (xhr, status, error)
                {
                    $.each(BootstrapDialog.dialogs, function(id, dialog)
                    {
                        dialog.close();
                    });
                    BootstrapDialog.alert(error);
                },
                beforeSend:function()
                {
                    BootstrapDialog.show(
                    {
                        title: '<div class="text-center">Submitting Your Book<div>',
                        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>Submitting..<div>'
                    });
                }
            });
        
            return false;
        });
    });
</script>
@stop
