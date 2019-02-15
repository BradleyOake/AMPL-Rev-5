@extends('layouts.layout_main')
@section('title', 'Edit Author')

@section('content')


<!-- main-container -->
<div class="container main-content">
<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit [[ $author->email]]'s Information on [[ $book->title ]]</h1>

            </div>
        </div>
     <div class="row">

<form id="editAuthor" class="form-horizontal" method="post">
    <div class="form-group text-center">
            <div class="err" id="author_err">Change author information</div>
        </div>
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="email">Author Email</label>
  <div class="col-md-4">
  <input name="email" id="email" type="text" class="form-control input-md" value="[[ $author->email]]" readonly="readonly">

  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="book_ID">Book ID</label>
  <div class="col-md-4">
  <input id="book_ID" name="book_ID" type="text" class="form-control input-md" value="[[ $book->book_id]]" readonly="readonly">

  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="book_title">Book title</label>
  <div class="col-md-4">
  <input id="book_title" name="book_title" type="text" class="form-control input-md" value="[[ $book->title]]" readonly="readonly">

  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="name_on">Name on Book</label>
  <div class="col-md-4">
  <input id="name_on" name="name_on" type="text" class="form-control input-md" value="[[ $author->name_on_book]]">

  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="electronic_rate">Electronic Rate</label>
  <div class="col-md-4">
     <input id="electronic_rate" name="electronic_rate" type="text" class="form-control input-md" value="[[  $author->electronic_rate]]">
    </select>
  </div>
  </div>

  <div class="form-group">
  <label class="col-md-4 control-label" for="audio_rate">Audio Rate</label>
  <div class="col-md-4">
     <input id="audio_rate" name="audio_rate" type="text" class="form-control input-md" value="[[  $author->audio_rate]]">
    </select>
  </div>
  </div>


                <div class="form-group text-center">
        <div class="col-sm-112">

            <button type="submit" class="btn btn-primary" name="updateAuthor"><i class="fa fa-floppy-o"></i> Save Changes</button>

        </div></div>

</fieldset>
</form>

</div>
</div>

<!-- /.container -->

@stop


@section('javascripts')

<script type="text/javascript">


$(document).ready(function()
{
     $('#editAuthor').bootstrapValidator(
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
                        message: 'The book title must be inserted'
                  }
                }
            },
            electronic_rate: {
                validators: {
                    numeric: {
                        message: 'Electronic Price must be numeric'
                    },
                    greaterThan: {
                         value: 0,

                        message: 'The rate must be positive'
                        },
                     lessThan: {
                         value: 100,

                        message: 'The rate cannot be above 100'
                        }
                }
            },
            audio_rate: {
                validators: {
                    numeric: {
                        message: 'Audio Price must be numeric'
                    },
                     greaterThan: {
                         value: 0,

                        message: 'The rate must be positive'
                        },
                     lessThan: {
                         value: 100,

                        message: 'The rate cannot be above 100'
                        }
                }
            },
            soft_rate: {
                validators: {
                    numeric: {
                        message: 'Soft Price must be numeric'
                    },
                    greaterThan: {
                         value: 0,

                        message: 'The rate must be positive'
                        },
                     lessThan: {
                         value: 100,

                        message: 'The rate cannot be above 100'
                        }
                }
            },
            hard_rate: {
                validators: {
                    numeric: {
                        message: 'Hard Price must be numeric'
                    },
                     greaterThan: {
                         value: 0,

                        message: 'The rate must be positive'
                        },
                     lessThan: {
                         value: 100,

                        message: 'The rate cannot be above 100'
                        }
                }
            },
             payment_option: {
                validators: {
                    integer: {
                        message: 'The payment option number must be a whole number'
                    },
                     greaterThan: {
                         value: 1,

                        message: 'Currently the options are 1-3 inclusive.'
                        },
                     lessThan: {
                         value: 3,

                        message: 'Currently the options are 1-3 inclusive.'
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
            url: public_path + "admin/editAuthor",
            dataType: 'json', // expected returned data format.

            data: new FormData( this ),
                processData: false,
                contentType: false,
            success: function (data)
            {

                if(data.valid==true)
                    {
                        $("#author_err").addClass("text-success");

                        $('#editAuthor').data('bootstrapValidator').resetForm();
                       $("#author_err").html("Author update successful");

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
