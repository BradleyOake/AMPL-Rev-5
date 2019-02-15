@extends('layouts.layout_main')
@section('title', 'Add Author')
@section('metatags')
@stop

@section('content')
<!-- main-container -->
<div class="container main-content">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add an Author to [[ $book->title ]]</h1>
        </div>
    </div>

    @if(count($book->authors) > 0)
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center">Current Authors</h2>
            </div>
        </div>

        <table class="table table-striped ampl-table">
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Electronic Rate</th>
                <th>Audio Rate</th>
                <th>Edit</th>
            </tr>

            @foreach ($book->authors as $author)
                <tr>
                    <td>[[ $author->email ]] </td>
                    <td>[[ $author->name_on_book ]]</td>
                    <td>[[ $author->electronic_rate ]]%</td>
                    <td>[[ $author->audio_rate ]]%</td>
                    <td>
                        <button data-book-id="[[$book->book_id ]]" data-book-title="[[$book->title ]]" data-email="[[$author->email ]]" type="submit" style="padding:0px 5px 0px 5px" class="delete_author btn-sm btn btn-danger" title="Remove Author" data-toggle="tooltip">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        
                        <a href="[[ URL::to('admin/editAuthor', array($book->book_id,$author->email)) ]]" style="padding:0px 5px 0px 5px" class="btn-sm btn btn-warning" title="Change Author Details" data-toggle="tooltip">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        
                        <a href="[[ URL::to('admin/editUser', array($author->email)) ]]" style="padding:0px 5px 0px 5px" class="btn-sm btn btn-primary" title="View User Account" data-toggle="tooltip">
                            <i class="fa fa-user"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
        <hr>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Add Author</h2>
        </div>
    </div>
    
    <div class="row">
        <form id="addAuthor" class="form-horizontal" method="post">
            <fieldset>
                <!-- Form Name -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="book_ID">Book ID</label>
                    
                    <div class="col-md-4">
                        <input id="book_ID" name="book_ID" type="text" class="form-control input-md" value="[[ $book->book_id]]" readonly="readonly" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="book_title">Book title</label>
                    
                    <div class="col-md-4">
                        <input id="book_title" name="book_title" type="text" class="form-control input-md" value="[[ $book->title]]" readonly="readonly" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="email">Author</label>
                    
                    <div class="col-md-4">
                        <select name="authorPicks"  id="authorPicks" class="form-control">
                            <option value=""></option>
                            @foreach ($authors as $author)
                                <option value="<?= $author['email'] ?>"><?= $author['email'].' ('.$author->first_name.' '.$author->last_name.')' ?></option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="name_on">Name on Book</label>
                    
                    <div class="col-md-4">
                        <input id="name_on" name="name_on" type="text" class="form-control input-md" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="electronic_rate">Electronic Rate</label>
                    
                    <div class="col-md-4">
                        <input id="electronic_rate" name="electronic_rate" type="text" class="form-control input-md" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="audio_rate">Audio Rate</label>
                    
                    <div class="col-md-4">
                        <input id="audio_rate" name="audio_rate" type="text" class="form-control input-md" value="" />
                    </div>
                </div>
                
                <!-- <div class="form-group">
                    <label class="col-md-4 control-label" for="soft_rate">Soft Rate</label>
                    
                    <div class="col-md-4">
                        <input id="soft_rate" name="soft_rate" type="text" class="form-control input-md" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="hard_rate">Hard Rate</label>
                    
                    <div class="col-md-4">
                        <input id="hard_rate" name="hard_rate" type="text" class="form-control input-md" value="" />
                    </div>
                </div>    
  
                <div class="form-group">
                    <label class="col-md-4 control-label" for="payment_option">Payment Option Number</label>
                    
                    <div class="col-md-4">
                        <input id="payment_option" name="payment_option" type="text" class="form-control input-md" value="">
                    </div>
                </div> -->

                <div class="form-group text-center">
                    <div class="col-sm-112">
                        <button type="submit" class="btn btn-primary" name="updateAuthor">
                            <i class="fa fa-floppy-o"></i> Add Author
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
        <hr>
    </div>
</div>
@stop

@section('scripts')
<script type="text/javascript">
    // this is the id of the submit button
    $(".delete_author").click(function ()
    {
        var sender = $(this);
        var book_id = sender.data("book-id");
        var email = sender.data("email");
        var title = sender.data("book-title");

        BootstrapDialog.confirm(
        {
            title: 'Confirm Remove',
            message: 'Are you sure you want to remove ' + email + ' from ' + title + '?',
            // type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
            btnOKLabel: 'Delete', // <-- Default value is 'OK',
            btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
            callback: function (result)
            {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if (result)
                {
                    //var comment_id=$(this).attr('data-comment-id');
                    $.ajax(
                    {
                        type: "POST",
                        url: "[[URL::to('admin/authorRemove')]]",
                        data:
                        {
                            book_id: book_id,
                            email: email,
                        },
                        success: function (data)
                        {
                            location.reload();
                        }
                    });
                }
            }
        });
    });

    $(document).ready(function()
    {
        $('#addAuthor').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                name_on:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Author name must be inserted'
                        }
                    }
                },
                authorPicks:
                {

                    validators:
                    {
                        notEmpty:
                        {
                            message: 'You must pick an Author'
                        },
                        remote:
                        {
                            message: 'Author already assigned to this book',
                            url: public_path+'admin/addAuthorCheck',
                            data: function(validator)
                            {
                                return
                                {
                                    email: validator.getFieldElements('authorPicks').val(),
                                    bookID: validator.getFieldElements('book_ID').val()
                                };
                            },
                            type: 'POST'
                        }
                    }
                },
                electronic_rate:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Please enter an electronic rate. Enter zero if unsure.'
                        },
                        numeric:
                        {
                            message: 'Electronic Price must be numeric'
                        },
                        greaterThan:
                        {
                            value: 0,
                            message: 'The rate must be positive'
                        },
                        lessThan:
                        {
                            value: 100,
                            message: 'The rate cannot be above 100'
                        }
                    }
                },
                audio_rate:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Please enter an audio rate. Enter zero if unsure.'
                        },
                        numeric:
                        {
                            message: 'Audio Price must be numeric'
                        },
                        greaterThan:
                        {
                            value: 0,
                            message: 'The rate must be positive'
                        },
                        lessThan:
                        {
                            value: 100,
                            message: 'The rate cannot be above 100'
                        }
                    }
                },/*
                soft_rate:
                {
                    validators:
                    {
                        numeric:
                        {
                            message: 'Soft Price must be numeric'
                        },
                        greaterThan:
                        {
                            value: 0,
                            message: 'The rate must be positive'
                        },
                        lessThan:
                        {
                            value: 100,
                            message: 'The rate cannot be above 100'
                        }
                    }
                },
                hard_rate:
                {
                    validators:
                    {
                        numeric:
                        {
                            message: 'Hard Price must be numeric'
                        },
                        greaterThan:
                        {
                            value: 0,
                            message: 'The rate must be positive'
                        },
                        lessThan:
                        {
                            value: 100,
                            message: 'The rate cannot be above 100'
                        }
                    }
                },*/
                payment_option:
                {
                    validators:
                    {
                        integer:
                        {
                            message: 'The payment option number must be a whole number'
                        },
                        greaterThan:
                        {
                            value: 1,
                            message: 'Currently the options are 1-3 inclusive.'
                        },
                        lessThan:
                        {
                            value: 3,
                            message: 'Currently the options are 1-3 inclusive.'
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
                url: public_path + "admin/addAuthor",
                dataType: 'json', // expected returned data format.
                data: new FormData( this ),
                processData: false,
                contentType: false,
                success: function (data)
                {
                    if(data.valid==true)
                    {
                        location.reload();
                    }
                    else
                    {
                        //$("#book_err").addClass("text-danger");
                        $("author_err").html("An error occurred in submitting the form");
                    }
                },
                error: function(xhr, status, error)
                {
                    $("#author_err").html(error);
                },
                beforeSend:function()
                {
                    $("#author_err").html("Loading...");
                }
            });

            return false;
        });
    });
</script>
@stop
