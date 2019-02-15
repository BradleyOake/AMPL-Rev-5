@extends('layouts.layout_main')
@section('title', 'Edit Book')

@section('content')


<!-- main-container -->
<div class="container main-content">
    <div class="row">

        <div class="col-lg-12">
            <h1 class="page-header">Edit Book</h1>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <p>Make any required changes to a book here. Please note that if a file exists for a book you will see a delete/download option for that respective file. Uploading a new file to one that already exists will replace the existing file.</p>
        </div>

    </div>
    <hr>

    <div class="row">
        <form id="book" class="form-horizontal" method="post">
            <fieldset>
                <div class="form-group text-center">
                    <div class="err" id="book_err">Add book information</div>
                </div>

                <input  id="book_id" name="book_id" type="hidden" class="form-control input-md" value="[[ $book->book_id ]]">

                <div class="form-group">
                    <label class="col-md-4 control-label" for="">Book ID</label>
                    <div class="col-md-4">
                        <input disabled id="" name="" type="numer" class="form-control input-md" value="[[ $book->book_id ]]">

                    </div>
                </div>

                <!-- Book Title -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="book_title">Book title</label>
                    <div class="col-md-4">
                        <input id="book_title" name="book_title" type="text" class="form-control input-md" value="[[ $book->title ]]">

                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-4 control-label" for="book_description">Book Description</label>
                    <div class="col-md-4">
                        <textarea id="book_description" name="book_description" class="form-control input-md" rows="4" cols="100">[[ $book->description ]]</textarea>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-4 control-label" for="book_status">Book Status</label>
                    <div class="col-md-4">
                        <select name="book_status" id="book_status" class="form-control">
                            @foreach ($bookStatus as $status)
                            <option [[ ($book->status_id == $status->status_id) ? 'selected' : '' ]] value="[[ $status->status_id ]]">[[ $status->description ]]</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <hr>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="electronic_price">Electronic Price</label>
                    <div class="col-md-4">
                        <input name="electronic_price" id="electronic_price" type="text" class="form-control input-md" value="[[ $book->electronic_price ]]">
                    </div>
                </div>

                <div class="form-group">
                    @if ($book->txtFinalExists() )
                    <div class="pull-right col-md-4 ">
                        <button type="button" data-id="[[$book->book_id ]]" data-type="1" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip"><i class="fa fa-trash-o"></i>
                        </button>
                        <a href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 1)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></a>
                    </div>
                    @endif
                    <label class="col-md-4 control-label" for="txt_full">Text Full</label>
                    <div class="col-md-4">
                        <input type="file" name="txt_full" id="txt_full">
                    </div>
                </div>

                <div class="form-group">
                    @if ($book->txtSampleExists() )
                    <div class="pull-right col-md-4 ">
                        <button type="button" data-id="[[$book->book_id ]]" data-type="txtsample" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip"><i class="fa fa-trash-o"></i>
                        </button>
                        <a href="[[ URL::to('download/sample', array('id' => $book->book_id, 'type' => 1)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></a>
                    </div>
                    @endif
                    <label class="col-md-4 control-label" for="txt_sample">Text Sample</label>
                    <div class="col-md-4">
                        <input type="file" name="txt_sample" id="txt_sample">
                    </div>
                </div>

                <div class="form-group">
                    @if ($book->epubFinalExists() )
                    <div class="pull-right col-md-4 ">
                        <button type="button" data-id="[[$book->book_id ]]" data-type="2" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip"><i class="fa fa-trash-o"></i>
                        </button>
                        <a href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 2)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></a>
                    </div>
                    @endif
                    <label class="col-md-4 control-label" for="epub_full">E-Pub Full</label>
                    <div class="col-md-4">
                        <input type="file" name="epub_full" id="epub_full">
                    </div>
                </div>

                <div class="form-group">
                    @if ($book->epubSampleExists() )
                    <div class="pull-right col-md-4 ">
                        <button type="button" data-id="[[$book->book_id ]]" data-type="epubsample" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip"><i class="fa fa-trash-o"></i>
                        </button>
                        <a href="[[ URL::to('download/sample', array('id' => $book->book_id, 'type' => 2)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></a>
                    </div>
                    @endif
                    <label class="col-md-4 control-label" for="epub_sample">E-Pub Sample</label>
                    <div class="col-md-4">
                        <input type="file" name="epub_sample" id="epub_sample">
                    </div>
                </div>

                <div class="form-group">
                    @if ($book->pdfFinalExists() )
                    <div class="pull-right col-md-4 ">
                        <button type="button" data-id="[[$book->book_id ]]" data-type="3" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip"><i class="fa fa-trash-o"></i>
                        </button>
                        <a href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 3)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></a>
                    </div>
                    @endif
                    <label class="col-md-4 control-label" for="pdf_full">Pdf Full</label>
                    <div class="col-md-4">
                        <input type="file" name="pdf_full" id="pdf_full">
                    </div>
                </div>

                <div class="form-group">
                    @if ($book->pdfSampleExists() )
                    <div class="pull-right col-md-4 ">
                        <button type="button" data-id="[[$book->book_id ]]" data-type="pdfsample" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip"><i class="fa fa-trash-o"></i>
                        </button>
                        <a href="[[ URL::to('download/sample', array('id' => $book->book_id, 'type' => 3)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></a>
                    </div>
                    @endif
                    <label class="col-md-4 control-label" for="pdf_sample">Pdf Sample</label>
                    <div class="col-md-4">
                        <input type="file" name="pdf_sample" id="pdf_sample">
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="audio_price">Audio Price</label>
                    <div class="col-md-4">
                        <input name="audio_price" id="audio_price" type="text" class="form-control input-md" value="[[ $book->audio_price ]]">
                    </div>
                </div>
                <!--
                <div class="form-group">
                      <label class="col-md-4 control-label" for="soft_price">Soft Price</label>
                    <div class="col-md-4">
                        <input name="soft_price" id="soft_price" type="text" class="form-control input-md" value="">
                    </div>
                </div>

                <div class="form-group">
                      <label class="col-md-4 control-label" for="hard_price">Hard Price</label>
                    <div class="col-md-4">
                        <input name="hard_price" id="hard_price" type="text" class="form-control input-md" value="">
                    </div>
                </div>-->


                <div class="form-group">
                    @if ($book->mp3FinalExists() )
                    <div class="pull-right col-md-4 ">
                        <button type="button" data-id="[[$book->book_id ]]" data-type="4" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip"><i class="fa fa-trash-o"></i>
                        </button>
                        <a href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 4)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></a>
                    </div>
                    @endif
                    <label class="col-md-4 control-label" for="mp3_full">Mp3 Full</label>
                    <div class="col-md-4">
                        <input type="file" name="mp3_full" id="mp3_full">
                    </div>
                </div>

                <div class="form-group">
                    @if ($book->mp3SampleExists() )
                    <div class="pull-right col-md-4 ">
                        <button type="button" data-id="[[$book->book_id ]]" data-type="mp3sample" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip"><i class="fa fa-trash-o"></i>
                        </button>
                        <a href="[[ URL::to('download/sample', array('id' => $book->book_id, 'type' => 4)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip"><i class="fa fa-download"></i></a>
                    </div>
                    @endif
                    <label class="col-md-4 control-label" for="mp3_sample">Mp3 Sample</label>
                    <div class="col-md-4">
                        <input type="file" name="mp3_sample" id="mp3_sample">
                    </div>
                </div>


                <hr>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="cover_image">Cover Image</label>
                    <div class="col-md-4">
                        <input type="file" name="cover_image" id="cover_image">
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="isbn">ISBN</label>
                    <div class="col-md-4">
                        <input name="isbn" id="isbn" type="text" class="form-control input-md" value="[[ $book->isbn ]]">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="date_publised">Date Published</label>
                    <div class="col-md-4">
                        <input name="date_published" id="date_published" type="date" class="form-control input-md" value="[[ $book->date_published ]]">
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="synopsis">Synopsis</label>
                    <div class="col-md-4">
                        <input type="file" name="synopsis" id="synopsis">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-4 control-label" for="chapters">Chapters</label>
                    <div class="col-md-4">
                        <input type="file" name="chapters" id="chapters">
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="book_description">Meta Description</label>
                    <div class="col-md-4">
                        <textarea id="m_description" name="m_description" class="form-control input-md" rows="4" cols="100">[[ $book->m_description]]</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="book_description">Meta Keywords</label>
                    <div class="col-md-4">
                        <textarea id="m_keywords" name="m_keywords" class="form-control input-md" rows="4" cols="100">[[ $book->m_keywords ]]</textarea>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="col-sm-112">

                        <button type="submit" class="btn btn-primary" name="save_book"><i class="fa fa-floppy-o"></i> Save Changes</button>

                    </div>
                </div>

            </fieldset>
        </form>


    </div>
</div>

<!-- /.container -->

@stop @section('javascripts')

<script>
    // this is the id of the submit button

    $(".delete_file").click(function () {

        var sender = $(this);
        var title = "[[ $book->title ]]";
        var id = sender.data("id");
        var type = sender.data("type");

        BootstrapDialog.confirm({
            title: '<i class="fa fa-trash-o"></i> Confirm Delete',
            message: 'Are you sure you want to delete this file for ' + title,
            // type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
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
                        url: "[[URL::to('admin/deleteFile')]]",
                        data: {
                            id: id,
                            type: type,
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
            }
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#book').bootstrapValidator({

            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                book_title: {
                    validators: {
                        notEmpty: {
                            message: 'The book title must be inserted'
                        }
                    }
                },
                book_description: {
                    validators: {
                        notEmpty: {
                            message: 'There must be a description'
                        }
                    }
                },
                book_status: {
                    validators: {
                        notEmpty: {
                            message: 'Status must exist'
                        }
                    }
                },

                electronic_price: {
                    validators: {
                        notEmpty: {
                            message: 'Electronic price is required'
                        },
                        numeric: {
                            message: 'Electronic Price must be numeric'
                        },
                        regexp: {
                            regexp: /^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?\.[0-9]{1,2}$/,
                            //http://stackoverflow.com/questions/16242449/regex-currency-validation is where I got this from
                            message: 'The price must be currency'
                        }
                    }
                },
                audio_price: {
                    validators: {
                        notEmpty: {
                            message: 'Audio price is required'
                        },
                        numeric: {
                            message: 'Audio Price must be numeric'
                        },
                        regexp: {
                            regexp: /^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?\.[0-9]{1,2}$/,
                            //http://stackoverflow.com/questions/16242449/regex-currency-validation is where I got this from
                            message: 'The price must be currency'
                        }
                    }
                },
                soft_price: {
                    validators: {
                        notEmpty: {
                            message: 'Soft price is required'
                        },
                        numeric: {
                            message: 'Soft Price must be numeric'
                        },
                        regexp: {
                            regexp: /^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?\.[0-9]{1,2}$/,
                            //http://stackoverflow.com/questions/16242449/regex-currency-validationhttp://stackoverflow.com/questions/26049299/bootstrap-validator-not-validating is where I got this from
                            message: 'The price must be currency'
                        }
                    }
                },
                hard_price: {
                    validators: {
                        notEmpty: {
                            message: 'Hard price is required'
                        },
                        numeric: {
                            message: 'Hard Price must be numeric'
                        },
                        regexp: {
                            regexp: /^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?\.[0-9]{1,2}$/,
                            //http://stackoverflow.com/questions/16242449/regex-currency-validation is where I got this from
                            message: 'The price must be currency'
                        }
                    }
                },
                isbn: {
                    validators: {
                        isbn: {
                            message: 'ISBN must be a proper ISBN number'
                        }
                    }
                },
                synopsis: {
                    validators: {
                        file: {
                            extension: 'doc,txt,pdf,mp3,epub',
                            type: 'application/msword,text/plain,application/pdf,audio/mpeg,application/epub+zip',

                            message: 'Please enter a .doc,.txt,.pdf,.mp3,.epub'
                        }

                    }
                },
                chapters: {
                    validators: {
                        file: {
                            extension: 'doc,txt,pdf,mp3,epub',
                            type: 'application/msword,text/plain,application/pdf,audio/mpeg,application/epub+zip',

                            message: 'Please enter a .doc,.txt,.pdf,.mp3,.epub'
                        }

                    }
                },
                txt_full: {
                    validators: {
                        file: {
                            extension: 'txt',
                            type: 'text/plain',

                            message: 'Please enter a txt file'
                        }

                    }
                },
                txt_sample: {
                    validators: {
                        file: {
                            extension: 'txt',
                            type: 'text/plain',

                            message: 'Please enter a txt file'
                        }

                    }
                },
                epub_full: {
                    validators: {
                        file: {
                            extension: 'epub',
                            type: 'application/msword,text/plain,application/pdf,audio/mpeg,application/epub+zip',

                            message: 'Please enter a .doc,.txt,.pdf,.mp3,.epub'
                        }

                    }
                },
                epub_sample: {
                    validators: {
                        file: {
                            extension: 'epub',
                            type: 'application/msword,text/plain,application/pdf,audio/mpeg,application/epub+zip',

                            message: 'Please enter a .doc,.txt,.pdf,.mp3,.epub'
                        }

                    }
                },
                mp3_full: {
                    validators: {
                        file: {
                            extension: 'mp3',
                            type: 'audio/mpeg,audio/mp3',

                            message: 'Please enter a mp3 file'
                        }

                    }
                },
                mp3_sample: {
                    validators: {
                        file: {
                            extension: 'mp3',
                            type: 'audio/mpeg,audio/mp3',

                            message: 'Please enter a mp3 file'
                        }

                    }
                },
                pdf_full: {
                    validators: {
                        file: {
                            extension: 'pdf',
                            type: 'application/pdf',

                            message: 'Please enter a pdf file'
                        }

                    }
                },
                pdf_sample: {
                    validators: {
                        file: {
                            extension: 'pdf',
                            type: 'application/pdf',

                            message: 'Please enter a pdf file'
                        }

                    }
                },
                cover_image: {
                    validators: {
                        file: {
                            // extension: 'txt',
                            // type: 'text/plain',

                            message: 'Please enter a gif file'
                        }

                    }
                },
                date_published: {
                    validators: {
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Date published must be a date'
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
                    type: "POST",
                    url: public_path + "admin/editBook",
                    dataType: 'json', // expected returned data format.

                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (data) {

                        if (data.valid == true) {

                            /*  $("#book_err").addClass("text-success");
                        $("#book_err").html(data.name+" has been updated"); */
                            //   $('#profile').load(document.URL +  ' #profile')
                            //  $('#book').data('bootstrapValidator').resetForm();
                            $("#book_err").html("The book addition has been successful");
                            $('#book').data('bootstrapValidator').resetForm();
                            BootstrapDialog.alert('The book update has been successful');

                        } else {
                            //$("#book_err").addClass("text-danger");
                            $("#book_err").html("An error occurred in submitting the form");
                            $("#book_err").html("An error occurred in submitting the form");
                        }
                    },
                    error: function (xhr, status, error) {

                        $("#book_err").html(error);
                        BootstrapDialog.alert(error);
                    },
                    beforeSend: function () {
                        $("#book_err").html("Loading...");
                    }


                });
                return false;

            });


    });
</script>
@stop
