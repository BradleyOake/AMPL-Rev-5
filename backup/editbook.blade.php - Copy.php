@extends('layouts.layout_main')
@section('title', 'AMPL Admin Panel')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    @if(!Auth::user() || !Auth::user()->role_id == 7 )
        <h1>You do not have permission to view this page.</h1>
        <script type="text/javascript">
            window.location = "[[ URL::to('') ]]";
        </script>
    @else
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-lock"></i> Edit @if($book->status_id < 6)Pending @endif Book &quot;<span id="book_header">[[ $book->title ]]</span>&quot;</h1>
        </div>

        <h1 class="col-sm-offset-1"  id="edit_err">Book Information</h1>

        <form class="form-horizontal" method="post" id="editbook_form">
            <div class="row col-lg-offset-1 col-lg-11">
                <label for="title" class="control-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="No title set yet..." value="[[ $book->title ]]" maxlength="50" required />

                <div class="row">
                    <div class="col-lg-4">
                        <label for="eb_mkeywords" class="control-label">Meta Keywords</label>
                        <textarea style="resize:vertical;" class="form-control" rows="15" id="eb_mkeywords" name="eb_mkeywords" placeholder="No meta keywords set yet..." maxlength="200">[[ $book->m_keywords ]]</textarea>
                    </div>

                    <div class="col-lg-4">
                        <label for="eb_mdescription" class="control-label">Meta Description</label>
                        <textarea style="resize:vertical;" class="form-control" rows="15" id="eb_mdescription" name="eb_mdescription" placeholder="No meta description set yet..." maxlength="200">[[ $book->m_description ]]</textarea>
                    </div>

                    <div class="col-lg-4">
                        <label for="eb_description" class="control-label">Description</label>
                        <textarea style="resize:vertical;" class="form-control" rows="15" id="eb_description" name="eb_description" placeholder="No description set yet...">[[ $book->description ]]</textarea>
                    </div>
                </div>
            </div>

            <div class="row col-lg-offset-1 col-lg-11">
                <div class="row">
                    <div class="col-lg-2">
                    <label for="eb_electronicprice" class="control-label">Electronic Price</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon3">$</span>
                            <input type="text" class="form-control" id="eb_electronicprice" name="eb_electronicprice" placeholder="Electronic Price..." value="[[ $book->electronic_price ]]" />
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <label for="eb_audioprice" class="control-label">Audio Price</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon3">$</span>
                            <input type="text" class="form-control" id="eb_audioprice" name="eb_audioprice" placeholder="Audio Price..." value="[[ $book->audio_price ]]" />
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <label for="eb_softprice" class="control-label">Soft Price</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon3">$</span>
                            <input type="text" class="form-control" id="eb_softprice" name="eb_softprice" placeholder="Soft Price..." value="[[ $book->soft_price ]]" />
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <label for="eb_hardprice" class="control-label">Hard Price</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon3">$</span>
                            <input type="text" class="form-control" id="eb_hardprice" name="eb_hardprice" placeholder="Hard Price..." value="[[ $book->hard_price ]]" />
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <label for="eb_insoft" class="control-label">In Softcover?</label>
                        <select class="form-control" id="eb_insoft" name="eb_insoft">
                          @if($book->in_soft == 1)
                            <option selected="selected" value="1">Yes</option>
                          @else
                            <option value="1">Yes</option>
                          @endif
                          @if($book->in_soft == 0)
                            <option selected="selected" value="0">No</option>
                          @else
                            <option value="0">No</option>
                          @endif
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <label for="eb_inhard" class="control-label">In Hardcover?</label>
                        <select class="form-control" id="eb_inhard" name="eb_inhard">
                          @if($book->in_hard == 1)
                            <option selected="selected" value="1">Yes</option>
                          @else
                            <option value="1">Yes</option>
                          @endif
                          @if($book->in_hard == 0)
                            <option selected="selected" value="0">No</option>
                          @else
                            <option value="0">No</option>
                          @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row-fluid col-lg-offset-1">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="eb_statusid" class="control-label">Status ID</label>
                            <select class="form-control" id="eb_statusid" name="eb_statusid">
                                <?php $i=1 ?>
                                @foreach($statusDescription as $statusDescriptions)
                                    @if($book->status_id == $i)
                                        <option selected="selected" value=<?php echo $i ?>>[[ $statusDescriptions ]]</option>
                                    @else
                                        <option value=<?php echo $i ?>>[[ $statusDescriptions ]]</option>
                                    @endif
                                    
                                    <?php $i++ ?>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <div>
                                <label for="eb_isbn" class="control-label">ISBN</label>
                                <input type="text" class="form-control" id="eb_isbn" name="eb_isbn" placeholder="ISBN..." value="[[ $book->isbn ]]" maxlength="17" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <label for="eb_datepublished" class="control-label">Date Published</label>
                                <input type="date" class="form-control" id="eb_datepublished" name="eb_datepublished" placeholder="Date Published..." value="[[ $book->date_published ]]" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div>
                            <label for="eb_notes" class="control-label">Notes</label>
                            <textarea style="resize:vertical;" class="form-control" rows="7" id="eb_notes" name="eb_notes" placeholder="No notes set yet..." maxlength="200">[[ $book->notes ]]</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12 text-center">
                    <br><br>
                    <button type="submit" class="edit_book btn btn-primary btn-lg" data-book="[[ $book->book_id ]]" name="editbook">
                        @if($book->status_id < 6)<i class="fa fa-hourglass-end">@else<i class="fa fa-pencil-square-o">@endif </i> Edit Book
                    </button>
                </div>
            </div>
        </form>
        <br><hr><br>

        <div class="row col-lg-12 text-center">
            <a class="btn btn-primary btn-lg" @if($book->status_id < 6)href="[[ URL::to('admin/pendingbooks') ]]" @else href="[[ URL::to('admin/editbooks') ]]" @endif><i class="fa fa-arrow-circle-left"></i> Back To @if($book->status_id < 6)Pending @else Edit @endif Books</a>
        </div>
    @endif
    <br>
</div>

@stop

@section('scripts')
<script>
    $(".edit_book").click(function(e)
    {
        var sender = $(this);
        window.book_id = sender.data("book");
    });

    $(document).ready(function()
    {
        $('#editbook_form').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                eb_title:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'You must enter a book title'
                        }
                    }
                },
                eb_insoft:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'You must enter a value for In Soft'
                        }
                    }
                },
                eb_inhard:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'You must enter a value for In Hard'
                        }
                    }
                },
                /*eb_isbn:
                {
                    validators:
                    {
                        remote:
                        {
                            message: 'That ISBN is already in our database',
                            url: base_url + "/book/checkISBN",
                            type: 'POST'
                        }
                    }
                }*/

            },
        })
        .on('success.form.bv', function(e)
        {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            title = $("#title").val();
            m_keywords = $("#eb_mkeywords").val();
            m_description = $("#eb_mdescription").val();
            description = $("#eb_description").val();
            electronic_price = $("#eb_electronicprice").val();
            audio_price = $("#eb_audioprice").val();
            soft_price = $("#eb_softprice").val();
            hard_price = $("#eb_hardprice").val();
            in_soft = $("#eb_insoft").val();
            in_hard = $("#eb_inhard").val();
            status_id = $("#eb_statusid").val();
            isbn = $("#eb_isbn").val();
            date_published = $("#eb_datepublished").val();
            notes = $("#eb_notes").val();

            $.ajax(
            {
                type: "POST",
                url: "[[URL::to('book/updateBook')]]",
                dataType : 'json', // expected returned data format.
                data:
                {
                    book_id: window.book_id,
                    title: title,
                    m_keywords: m_keywords,
                    m_description: m_description,
                    description: description,
                    electronic_price: electronic_price,
                    audio_price: audio_price,
                    soft_price: soft_price,
                    hard_price: hard_price,
                    in_soft: in_soft,
                    in_hard: in_hard,
                    status_id: status_id,
                    isbn: isbn,
                    date_published: date_published,
                    notes: notes,
                },
                success: function(data)
                {
                    if(data.valid==true)
                    {
                        $("#edit_err").removeClass('text-danger').addClass('text-success');
                        $("#edit_err").html(data.message);
                        $('#editbook_form').data('bootstrapValidator').resetForm();
                        //$('#editbook_form')[0].reset();

                        $('#book_header').html(title);

                        window.scrollTo(0,0);

                        $('#eb_message').html("Book successfully updated!");
                    }
                    else
                    {
                        $("#edit_err").addClass("text-danger");
                        $("#edit_err").html(data.message);
                    }
                },
                beforeSend:function()
                {
                    $("#edit_err").html("Loading...");
                }
            });

            return false;
        });
    });
</script>
@stop
