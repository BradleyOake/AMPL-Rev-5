@extends('layouts.layout_main')
@section('title') Editing Book "[[ $book->title ]]"
@stop

@section('content')
<!-- Page content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i @if($book->status_id < 6)class="fa fa-hourglass-end" @else class="fa fa-pencil-square-o" @endif></i> Edit @if($book->status_id < 6)Pending @else Finished @endif Book &quot;<span id="book_header">[[ $book->title ]]</span>&quot;</h1>
    </div>

    <div class="col-lg-12">
        <p>
            Make any required changes to a book here. Please note that if a file exists for a book you will see a delete/download option for that respective file. Uploading a new file to one that already exists will replace the existing file.
        </p>
    </div>
    <hr>

    <h1 class="col-sm-offset-1" id="edit_err">Book Information</h1>

    <form id="book" class="form-horizontal" method="post">
        <div class="row col-lg-offset-1 col-lg-11">
            <div class="row">
                <div class="col-lg-3">
                    <label for="book_title" class="control-label">Title</label>
                    <input type="text" class="form-control" id="book_title" name="book_title" placeholder="No title set yet..." value="[[ $book->title ]]" maxlength="50" required />
                </div>

                <div class="col-lg-3">
                    <label for="book_status" class="control-label">Status ID</label>
                    <select class="form-control" id="book_status" name="book_status">
                        <?php $i=1 ?>
                        @foreach($bookStatus as $status)
                            @if($book->status_id == $i)
                                <option selected="selected" value=<?php echo $i ?>>[[ $status->description ]]</option>
                            @else
                                <option value=<?php echo $i ?>>[[ $status->description ]]</option>
                            @endif
                            
                            <?php $i++ ?>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3">
                    <label for="isbn" class="control-label">ISBN</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" placeholder="ISBN..." value="[[ $book->isbn ]]" maxlength="17" />
                </div>

                <div class="col-lg-3">
                    <label for="date_publised" class="control-label">Date Published</label>
                    <input type="date" class="form-control" id="date_publised" name="date_publised" placeholder="Date Published..." value="[[ $book->date_published ]]" />
                </div>
            </div>

            <div class="row">
                <br>
                <div class="col-lg-3">
                    <label for="m_keywords" class="control-label">Meta Keywords</label>
                    <textarea style="resize:vertical;" class="form-control" rows="15" id="m_keywords" name="m_keywords" placeholder="No meta keywords set yet..." maxlength="200">[[ $book->m_keywords ]]</textarea>
                </div>

                <div class="col-lg-3">
                    <label for="m_description" class="control-label">Meta Description</label>
                    <textarea style="resize:vertical;" class="form-control" rows="15" id="m_description" name="m_description" placeholder="No meta description set yet..." maxlength="200">[[ $book->m_description ]]</textarea>
                </div>

                <div class="col-lg-3">
                    <label for="book_description" class="control-label">Description</label>
                    <textarea style="resize:vertical;" class="form-control" rows="15" id="book_description" name="book_description" placeholder="No description set yet...">[[ $book->description ]]</textarea>
                </div>

                <div class="col-lg-3">
                    <label for="notes" class="control-label">Notes</label>
                    <textarea style="resize:vertical;" class="form-control" rows="15" id="notes" name="notes" placeholder="No notes set yet..." maxlength="200">[[ $book->notes ]]</textarea>
                </div>
            </div>
        </div>

        <div class="row col-lg-offset-1 col-lg-11">
            <div class="row">
                <br>
                <div class="col-lg-3">
                <label for="electronic_price" class="control-label">Electronic Price</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon3">$</span>
                        <input type="text" class="form-control" id="electronic_price" name="electronic_price" placeholder="Electronic Price..." value="[[ $book->electronic_price ]]" />
                    </div>
                </div>

                <div class="col-lg-3">
                    <label for="audio_price" class="control-label">Audio Price</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon3">$</span>
                        <input type="text" class="form-control" id="audio_price" name="audio_price" placeholder="Audio Price..." value="[[ $book->audio_price ]]" />
                    </div>
                </div>

                <div class="col-lg-3">
                    <label for="soft_price" class="control-label">Soft Price</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon3">$</span>
                        <input type="text" class="form-control" id="soft_price" name="soft_price" placeholder="Soft Price..." value="[[ $book->soft_price ]]" />
                    </div>
                </div>

                <div class="col-lg-3">
                    <label for="hard_price" class="control-label">Hard Price</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon3">$</span>
                        <input type="text" class="form-control" id="hard_price" name="hard_price" placeholder="Hard Price..." value="[[ $book->hard_price ]]" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row col-lg-offset-1 col-lg-11">
            <div class="row">
                <!-- Electronic uploads -->
                <div class="col-lg-3">
                    <br>
                    <ul class="nav nav-pills text-center" role="tablist" id="myElectronicPill">
                        <li role="presentation" class="active" style="width:32%;"><a href="#epub_panel" role="tab" data-toggle="tab">ePUB</a></li>
                        <li role="presentation" style="width:32%;"><a href="#pdf_panel" role="tab" data-toggle="tab">PDF</a></li>
                        <li role="presentation" style="width:32%;"><a href="#txt_panel" role="tab" data-toggle="tab">TXT</a></li>
                    </ul>

                    <div class="tab-content" style="text-align:center;width:96%;">
                        <div role="tabpanel" class="tab-pane active fade in" id="epub_panel">
                            <label for="epub_sample" class="control-label">ePUB Sample</label>&nbsp;
                            @if ($book->epubSampleExists())
                                <button type="button" data-id="[[$book->book_id ]]" data-type="epubsample" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>

                                <a href="[[ URL::to('download/sample', array('id' => $book->book_id, 'type' => 2)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            @endif
                            <input type="file" class="form-control" id="epub_sample" name="epub_sample" accept=".epub" />

                            <label for="epub_full" class="control-label">ePUB Full</label>&nbsp;
                            @if ($book->epubFinalExists())
                                <button type="button" data-id="[[$book->book_id ]]" data-type="2" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                    
                                <a href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 2)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            @endif
                            <input type="file" class="form-control" id="epub_full" name="epub_full" accept=".epub" />
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="pdf_panel">
                            <label for="pdf_sample" class="control-label">PDF Sample</label>&nbsp;
                            @if ($book->pdfSampleExists())
                                <button type="button" data-id="[[$book->book_id ]]" data-type="pdfsample" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <a href="[[ URL::to('download/sample', array('id' => $book->book_id, 'type' => 3)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            @endif
                            <input type="file" class="form-control" id="pdf_sample" name="pdf_sample" accept=".pdf" />

                            <label for="pdf_full" class="control-label">PDF Full</label>&nbsp;
                            @if ($book->pdfFinalExists())
                                <button type="button" data-id="[[$book->book_id ]]" data-type="3" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <a href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 3)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            @endif
                            <input type="file" class="form-control" id="pdf_full" name="pdf_full" accept=".pdf" />
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="txt_panel">
                            <label for="txt_sample" class="control-label">TXT Sample</label>&nbsp;
                            @if ($book->txtSampleExists())
                                <button type="button" data-id="[[$book->book_id ]]" data-type="txtsample" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                
                                <a href="[[ URL::to('download/sample', array('id' => $book->book_id, 'type' => 1)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            @endif
                            <input type="file" class="form-control" id="txt_sample" name="txt_sample" accept=".txt,.doc,.docx" />

                            <label for="txt_full" class="control-label">TXT Full</label>&nbsp;
                            @if ($book->txtFinalExists())
                                <button type="button" data-id="[[$book->book_id ]]" data-type="1" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                
                                <a href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 1)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            @endif
                            <input type="file" class="form-control" id="txt_full" name="txt_full" accept=".txt,.doc,.docx" />
                        </div>
                    </div>
                </div>

                <!-- Audio uploads -->
                <div class="col-lg-3">
                    <br>
                    <ul class="nav nav-pills text-center" role="tablist" id="myAudioPill">
                        <li role="presentation" class="active" style="width:32%;"><a href="#mp3_panel" role="tab" data-toggle="tab">MP3</a></li>
                        <li role="presentation" class="disabled" style="width:32%;"><a href="#ogg_panel" role="tab" data-toggle="tab">OGG</a></li>
                        <li role="presentation" class="disabled" style="width:32%;"><a href="#wav_panel" role="tab" data-toggle="tab">WAV</a></li>
                    </ul>

                    <div class="tab-content" style="text-align:center;width:96%;">
                        <div role="tabpanel" class="tab-pane active fade in" id="mp3_panel">
                            <label for="mp3_sample" class="control-label">MP3 Sample</label>&nbsp;
                            @if ($book->mp3SampleExists())
                                <button type="button" data-id="[[$book->book_id ]]" data-type="mp3sample" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>

                                <a href="[[ URL::to('download/sample', array('id' => $book->book_id, 'type' => 4)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            @endif
                            <input type="file" class="form-control" id="mp3_sample" name="mp3_sample" accept=".mp3" />

                            <label for="mp3_full" class="control-label">MP3 Full</label>&nbsp;
                            @if ($book->mp3FinalExists())
                                <button type="button" data-id="[[$book->book_id ]]" data-type="4" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>

                                <a href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 4)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            @endif
                            <input type="file" class="form-control" id="mp3_full" name="mp3_full" accept=".mp3" />
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="ogg_panel">
                            <label for="ogg_sample" class="control-label">OGG Sample</label>
                            <!--if ($book->oggSampleExists())
                                <button type="button" data-id="[[-- $book->book_id --]]" data-type="oggsample" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <a href="[[-- URL::to('download/sample', array('id' => $book->book_id, 'type' => #)) --]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            endif-->
                            <input type="file" class="form-control" id="ogg_sample" name="ogg_sample" accept=".ogg" />

                            <label for="ogg_full" class="control-label">OGG Full</label>
                            <!-- if ($book->oggFinalExists())
                                <button type="button" data-id="[[-- $book->book_id --]]" data-type="#" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <a href="[[-- URL::to('download/final', array('id' => $book->book_id, 'type' => #)) --]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            endif -->
                            <input type="file" class="form-control" id="ogg_full" name="ogg_full" accept=".ogg" />
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="wav_panel">
                            <label for="wav_sample" class="control-label">WAV Sample</label>
                            <!-- if ($book->wavSampleExists())
                                <button type="button" data-id="[[-- $book->book_id --]]" data-type="wavsample" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <a href="[[-- URL::to('download/sample', array('id' => $book->book_id, 'type' => #)) --]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            endif -->
                            <input type="file" class="form-control" id="wav_sample" name="wav_sample" accept=".wav" />

                            <label for="wav_full" class="control-label">WAV Full</label>
                            <!-- if ($book->wavFinalExists())
                                <button type="button" data-id="[[-- $book->book_id --]]" data-type="#" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <a href="[[-- URL::to('download/final', array('id' => $book->book_id, 'type' => #)) --]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                                    <i class="fa fa-download"></i>
                                </a>
                            endif -->
                            <input type="file" class="form-control" id="wav_full" name="wav_full" accept=".wav" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <br>
                    <label for="in_soft" class="control-label">Available In Softcover?</label>
                    <select class="form-control" id="in_soft" name="in_soft">
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

                    <label for="in_hard" class="control-label">Available In Hardcover?</label>
                    <select class="form-control" id="in_hard" name="in_hard">
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

                    <label class="control-label" for="cover_image">Cover Image</label>
                    @if ($book->coverExists())
                        <button type="button" data-id="[[$book->book_id ]]" data-type="cover" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                            <i class="fa fa-trash-o"></i>
                        </button>

                        <a href="[[ URL::to('download/sample', array('id' => $book->book_id, 'type' => 4)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                            <i class="fa fa-download"></i>
                        </a>
                    @endif
                    <input type="file" class="form-control" name="cover_image" id="cover_image">
                </div>
                <br>

                <div class="col-lg-3">
                    <label for="synopsis" class="control-label">Synopsis</label>
                    <input type="file" class="form-control" id="synopsis" name="synopsis" accept=".txt,.doc,.docx,.pdf" />

                    <label for="chapters" class="control-label">Chapters</label>
                    <input type="file" class="form-control" id="chapters" name="chapters" accept=".txt,.doc,.docx,.pdf" />

                    <label class="control-label" for="banner_image">Banner Image</label>
                    @if ($book->bannerExists())
                        <button type="button" data-id="[[$book->book_id ]]" data-type="banner" class="delete_file btn-sm btn btn-danger" title="Remove File" data-toggle="tooltip">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        
                        <a href="[[ URL::to('download/sample', array('id' => $book->book_id, 'type' => 4)) ]]" class="btn-sm btn btn-primary" title="Download" data-toggle="tooltip">
                            <i class="fa fa-download"></i>
                        </a>
                    @endif
                    <input type="file" class="form-control" name="banner_image" id="banner_image">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12 text-center">
                <br><br>
                <button type="submit" class="save_book btn btn-primary" data-book="[[ $book->book_id ]]" name="save_book">
                    @if($book->status_id < 6)<i class="fa fa-hourglass-end">@else<i class="fa fa-pencil-square-o">@endif </i> Edit Book
                </button>
            </div>
        </div>
    </form>
    <br><hr><br>

    <div class="row col-lg-12 text-center">
        <a class="btn btn-primary btn-lg" style="margin-left:30px;" @if($book->status_id < 6)href="[[ URL::to('admin/book/pendingbooks') ]]" @else href="[[ URL::to('admin/book/finishedbooks') ]]" @endif><i class="fa fa-arrow-circle-left"></i> Back To @if($book->status_id < 6)Pending @else Finished @endif Books</a>
    </div>
    <br>
</div>
@stop

@section('scripts')
<script>
    $(".save_book").click(function(e)
    {
        var sender = $(this);
        window.book_id = sender.data("book");
    });

    $(".delete_file").click(function ()
    {
        var sender = $(this);
        var title = "[[ $book->title ]]";
        var id = sender.data("id");
        var type = sender.data("type");

        BootstrapDialog.confirm(
        {
            title: '<i class="fa fa-trash-o"></i> Confirm Delete',
            message: 'Are you sure you want to delete this file for ' + title,
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
                        url: "[[URL::to('admin/deleteFile')]]",
                        data:
                        {
                            id: id,
                            type: type,
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

    $(document).ready(function ()
    {
        $('#book').bootstrapValidator(
        {
            feedbackIcons:
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:
            {
                book_title:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'The book title must be inserted'
                        }
                    }
                },
                book_status:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: 'Status must exist'
                        }
                    }
                },
                electronic_price:
                {
                    validators:
                    {
                        numeric:
                        {
                            message: 'Electronic Price must be numeric'
                        },
                        regexp:
                        {
                            regexp: /^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?\.[0-9]{1,2}$/,
                            //http://stackoverflow.com/questions/16242449/regex-currency-validation is where I got this from
                            message: 'The price must be currency'
                        }
                    }
                },
                audio_price:
                {
                    validators:
                    {
                        numeric:
                        {
                            message: 'Audio Price must be numeric'
                        },
                        regexp:
                        {
                            regexp: /^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?\.[0-9]{1,2}$/,
                            //http://stackoverflow.com/questions/16242449/regex-currency-validation is where I got this from
                            message: 'The price must be currency'
                        }
                    }
                },
                soft_price:
                {
                    validators:
                    {
                        numeric:
                        {
                            message: 'Soft Price must be numeric'
                        },
                        regexp:
                        {
                            regexp: /^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?\.[0-9]{1,2}$/,
                            //http://stackoverflow.com/questions/16242449/regex-currency-validationhttp://stackoverflow.com/questions/26049299/bootstrap-validator-not-validating is where I got this from
                            message: 'The price must be currency'
                        }
                    }
                },
                hard_price:
                {
                    validators:
                    {
                        numeric:
                        {
                            message: 'Hard Price must be numeric'
                        },
                        regexp:
                        {
                            regexp: /^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?\.[0-9]{1,2}$/,
                            //http://stackoverflow.com/questions/16242449/regex-currency-validation is where I got this from
                            message: 'The price must be currency'
                        }
                    }
                },
                isbn:
                {
                    validators:
                    {
                        isbn:
                        {
                            message: 'ISBN must be a proper ISBN number'
                        }
                    }
                },
                synopsis:
                {
                    validators:
                    {
                        file:
                        {
                            extension: 'doc,txt,pdf,mp3,epub',
                            type: 'application/msword,text/plain,application/pdf,audio/mpeg,application/epub+zip',
                            message: 'Please enter a .doc,.txt,.pdf,.mp3,.epub'
                        }
                    }
                },
                chapters:
                {
                    validators:
                    {
                        file:
                        {
                            extension: 'doc,txt,pdf,mp3,epub',
                            type: 'application/msword,text/plain,application/pdf,audio/mpeg,application/epub+zip',
                            message: 'Please enter a .doc,.txt,.pdf,.mp3,.epub'
                        }
                    }
                },
                txt_full:
                {
                    validators:
                    {
                        file:
                        {
                            extension: 'txt',
                            type: 'text/plain',
                            message: 'Please enter a txt file'
                        }
                    }
                },
                txt_sample:
                {
                    validators:
                    {
                        file:
                        {
                            extension: 'txt',
                            type: 'text/plain',
                            message: 'Please enter a txt file'
                        }
                    }
                },
                epub_full:
                {
                    validators:
                    {
                        file:
                        {
                            extension: 'epub',
                            type: 'application/msword,text/plain,application/pdf,audio/mpeg,application/epub+zip',
                            message: 'Please enter a .doc,.txt,.pdf,.mp3,.epub'
                        }
                    }
                },
                epub_sample:
                {
                    validators:
                    {
                        file:
                        {
                            extension: 'epub',
                            type: 'application/msword,text/plain,application/pdf,audio/mpeg,application/epub+zip',
                            message: 'Please enter a .doc,.txt,.pdf,.mp3,.epub'
                        }
                    }
                },
                mp3_full:
                {
                    validators:
                    {
                        file:
                        {
                            extension: 'mp3',
                            type: 'audio/mpeg,audio/mp3',
                            message: 'Please enter a mp3 file'
                        }
                    }
                },
                mp3_sample:
                {
                    validators:
                    {
                        file:
                        {
                            extension: 'mp3',
                            type: 'audio/mpeg,audio/mp3',
                            message: 'Please enter a mp3 file'
                        }
                    }
                },
                pdf_full:
                {
                    validators:
                    {
                        file:
                        {
                            extension: 'pdf',
                            type: 'application/pdf',
                            message: 'Please enter a pdf file'
                        }
                    }
                },
                pdf_sample:
                {
                    validators:
                    {
                        file:
                        {
                            extension: 'pdf',
                            type: 'application/pdf',
                            message: 'Please enter a pdf file'
                        }
                    }
                },
                cover_image:
                {
                    validators:
                    {
                        file:
                        {
                            // extension: 'txt',
                            // type: 'text/plain',
                            message: 'Please enter a gif file'
                        }
                    }
                },
                date_published:
                {
                    validators:
                    {
                        date:
                        {
                            format: 'YYYY-MM-DD',
                            message: 'Date published must be a date'
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

            book_title = $("#book_title").val();
            book_status = $("#book_status").val();
            isbn = $("#isbn").val();
            date_published = $("#date_published").val();
            m_keywords = $("#m_keywords").val();
            m_description = $("#m_description").val();
            book_description = $("#book_description").val();
            notes = $("#notes").val();
            electronic_price = $("#electronic_price").val();
            audio_price = $("#audio_price").val();
            soft_price = $("#soft_price").val();
            hard_price = $("#hard_price").val();
            epub_sample = $("#epub_sample").val();
            epub_full = $("#epub_full").val();
            pdf_sample = $("#pdf_sample").val();
            pdf_full = $("#pdf_full").val();
            txt_sample = $("#txt_sample").val();
            txt_full = $("#txt_full").val();
            mp3_sample = $("#mp3_sample").val();
            mp3_full = $("#mp3_full").val();
            in_soft = $("#in_soft").val();
            in_hard = $("#in_hard").val();
            synopsis = $("#synopsis").val();
            chapters = $("#chapters").val();
            cover_image = $("#cover_image").val();
            banner_image = $("#banner_image").val();

            $.ajax(
            {
                type: "POST",
                url: base_url + "/admin/postEdit",
                dataType: 'json', // expected returned data format.
                data:
                {
                    //new FormData(this),
                    book_id: window.book_id,
                    book_title: book_title,
                    book_status: book_status,
                    isbn: isbn,
                    date_published: date_published,
                    m_keywords: m_keywords,
                    m_description: m_description,
                    book_description: book_description,
                    notes: notes,
                    electronic_price: electronic_price,
                    audio_price: audio_price,
                    soft_price: soft_price,
                    hard_price: hard_price,
                    epub_sample: epub_sample,
                    epub_full: epub_full,
                    pdf_sample: pdf_sample,
                    pdf_full: pdf_full,
                    txt_sample: txt_sample,
                    txt_full: txt_full,
                    mp3_sample: mp3_sample,
                    mp3_full: mp3_full,
                    in_soft: in_soft,
                    in_hard: in_hard,
                    synopsis: synopsis,
                    chapters: chapters,
                    cover_image: cover_image,
                    banner_image: banner_image,
                },
                success: function (data)
                {
                    if(data.valid==true)
                    {
                        $.each(BootstrapDialog.dialogs, function(id, dialog)
                        {
                            dialog.close();
                        });

                        $("#edit_err").removeClass('text-danger').addClass('text-success');
                        $("#edit_err").html(data.message);
                        $('#book').data('bootstrapValidator').resetForm();
                        //$('#book')[0].reset();

                        $('#book_header').html(book_title);

                        window.scrollTo(0,0);

                        $('eb_message').html("Book successfully updated!");
                    }
                    else
                    {
                        $.each(BootstrapDialog.dialogs, function(id, dialog)
                        {
                            dialog.close();
                        });

                        $("#edit_err").addClass("text-danger");
                        $("#edit_err").html(data.message);
                    }
                },
                error: function (xhr, status, error)
                {
                    BootstrapDialog.alert(error);
                },
                beforeSend:function()
                {
                    BootstrapDialog.show(
                    {
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
