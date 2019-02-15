@extends('layouts.layout_main')
@section('title', 'Add Book')
@section('metatags')
@stop

@section('content')
<!-- main-container -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header">Add Book</h1>
    </div>

    <div class="row">
        <div class="col-lg-offset-1 col-lg-11">
            <p>Here you can upload a new book to our system. Please note that to make a final type of a book available you need only to upload the complete book of that type.</p>
        </div>
    </div>

    <hr>
    <div class="row">
        <form id="book" class="form-horizontal" method="post">
            <div class="form-group text-center">
                <div class="err" id="book_err">Add book information</div>
            </div>

            <!-- Book title -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="book_title">Book title</label>
                <div class="col-md-4">
                    <input id="book_title" name="book_title" type="text" class="form-control input-md" value="">
                </div>
            </div>

            <!-- Book description -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="book_description">Book Description</label>
                <div class="col-md-4">
                    <textarea id="book_description" name="book_description" class="form-control input-md" rows="4" cols="100"></textarea>
                </div>
            </div>

            <!-- Book status -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="book_status">Book Status</label>
                <div class="col-md-4">
                    <select name="book_status" id="book_status" class="form-control">
                        <option selected hidden value="">Select a book status</option>
                        @foreach ($bookStatus as $status)
                            <option value="[[ $status->status_id ]]">[[ $status->description ]]</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr>
            <div class="form-group">
                <label class="col-md-4 control-label" for="electronic_price">Electronic Price</label>
                <div class="col-md-4">
                    <input name="electronic_price" id="electronic_price" type="text" class="form-control input-md" value="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="txt_full">Text Full</label>
                <div class="col-md-4">
                    <input type="file" name="txt_full" id="txt_full">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="txt_sample">Text Sample</label>
                <div class="col-md-4">
                    <input type="file" name="txt_sample" id="txt_sample">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="epub_full">E-Pub Full</label>
                <div class="col-md-4">
                    <input type="file" name="epub_full" id="epub_full">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="epub_sample">E-Pub Sample</label>
                <div class="col-md-4">
                    <input type="file" name="epub_sample" id="epub_sample">
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="pdf_full">Pdf Full</label>
                <div class="col-md-4">
                    <input type="file" name="pdf_full" id="pdf_full">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="pdf_sample">Pdf Sample</label>
                <div class="col-md-4">
                    <input type="file" name="pdf_sample" id="pdf_sample">
                </div>
            </div>

            <hr>
            <div class="form-group">
                <label class="col-md-4 control-label" for="audio_price">Audio Price</label>
                <div class="col-md-4">
                    <input name="audio_price" id="audio_price" type="text" class="form-control input-md" value="">
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
                <label class="col-md-4 control-label" for="mp3_full">Mp3 Full</label>
                <div class="col-md-4">
                    <input type="file" name="mp3_full" id="mp3_full">
                </div>
            </div>

            <div class="form-group">
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
                    <input name="isbn" id="isbn" type="text" class="form-control input-md" value="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="date_publised">Date Published</label>
                <div class="col-md-4">
                    <input name="date_published" id="date_published" type="date" class="form-control input-md" value=>
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
                    <textarea id="m_description" name="m_description" class="form-control input-md" rows="4" cols="100"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="book_description">Meta Keywords</label>
                <div class="col-md-4">
                    <textarea id="m_keywords" name="m_keywords" class="form-control input-md" rows="4" cols="100"></textarea>
                </div>
            </div>

            <div class="form-group text-center">
                <br>
                <div class="col-sm-112">
                    <button type="submit" class="btn btn-primary btn-lg" name="save_book"><i class="fa fa-floppy-o"></i> Save Book</button>
                </div>
            </div>
        </form>
    </div>
    <hr>

    <div class="row col-lg-12 text-center">
        <br><br>
        <a class="btn btn-primary btn-lg" style="margin-left:30px;" href="[[ URL::to('admin') ]]"><i class="fa fa-arrow-circle-left"></i> Back To Admin Panel</a>
    </div>
</div>

<!-- /.container -->

@stop @section('scripts')

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
                    url: base_url + "/admin/books/postAdd",
                    dataType: 'json', // expected returned data format.

                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (data) {

                        console.log(data.valid);
                       if(data.valid==true)
                    {
                        $($form)[0].reset();
                        $($form).data('bootstrapValidator').resetForm();

                        $.each(BootstrapDialog.dialogs, function(id, dialog){
                            dialog.close();
                        });

                         BootstrapDialog.show({
                            title: '<i class="fa fa-check-circle"></i> Book Insert Successful',
                            message: data.message,
                            closable: true,
                            cssClass: 'ampl-dialog',
                            buttons: [
                                {
                                    label: '<i class="fa fa-home"></i>',
                                    cssClass: 'btn-primary',
                                    action: function() {
                                        window.location.href = "[[URL::to('admin/panel') ]]";
                                    }
                                },
                                {
                                    label: '<i class="fa fa-eye"></i>',
                                    cssClass: 'btn-primary',
                                    action: function() {
                                        window.location.href = "[[URL::to('bookpage') ]]"+"/"+data.id;
                                    }
                                },
                                  {
                                    label: '<i class="fa fa-download"></i>',
                                    cssClass: 'btn-primary',
                                    action: function() {
                                        window.location.href = "[[URL::to('user/downloadBook')]]"+"/"+data.id;
                                    }
                                },
                                 {
                                    label: '<i class="fa fa-pencil"></i> Add Author',
                                    cssClass: 'btn-primary',
                                    action: function() {
                                        window.location.href = "[[URL::to('admin/addAuthor') ]]"+"/"+data.id;
                                    }
                                },
                                {
                                    label: '<i class="fa fa-arrow-left"></i> Back',
                                     cssClass: 'pull-left btn-danger',
                                    action: function() {
                                       window.location.replace(document.referrer);
                                    }
                                }
                            ]
                        });
                    }
                    else
                    {

                        $.each(BootstrapDialog.dialogs, function(id, dialog){
                            dialog.close();
                        });

                         BootstrapDialog.show({
                            title: '<i class="fa fa-exclamation-circle"></i> An Error Occured',
                            message: data.message,
                            closable: true,
                            cssClass: 'ampl-dialog',
                            buttons: [
                                {
                                    label: '<i class="fa fa-arrow-left"></i> Back',
                                     cssClass: 'pull-left btn-danger',
                                    action: function() {
                                       window.location.replace(document.referrer);
                                    }
                                },
                                {
                                    label: 'Close',
                                    action: function(dialogItself){
                                        dialogItself.close();
                                    }
                                }
                            ]
                        });
                    }
                },
                error: function (xhr, status, error) {
                        BootstrapDialog.alert(error);
                },
                beforeSend:function()
                {
                     BootstrapDialog.show({
                        title: '<div class="text-center">Submitting Data<div>',
                        message: '<div class="text-center"><i class="fa fa-5x fa-spinner fa-spin"></i><br><br>Sending..<div>'
                    });
                }

                });
                return false;

            });


    });
</script>
@stop
