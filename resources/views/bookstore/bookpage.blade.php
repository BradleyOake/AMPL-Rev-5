@extends('layouts.layout_main')
@section('title')
    [[ $book->title ]]
@stop
@section('description')[[ $book->m_description]] @stop
@section('keywords') [[ $book->m_keywords ]]@stop
@section('metatags')

<script type="text/javascript">
    var onloadCallback = function () {
        grecaptcha.render('recaptcha_element', {
            'sitekey': '6LfayPQSAAAAAJ1wzR3WjtYkKFs-W-rWuEALmZM-',
            'callback': 'correctCaptcha'
        });
    };
</script>
@stop

@section('content')

<div class="container main-content">
    @if($book->status() == 'Quarantined')
        <div class="col-lg-12">
            <h1 class="page-header">Currently Unavailable</h1>
        </div>

        <div class="row">
            <div class="col-xs-12" style="margin-bottom:10px;">
                <div class="text-center">
                    This page is currently not available. Please browse our other amazing books at our <a href="[[URL::to('bookstore')]]">Bookstore</a>.
                </div>
            </div>
        </div>
    @else
    <!-- Page Content -->
        <div class="col-lg-12">
            <h1 class="page-header">[[ $book->title ]]</h1>
        </div>

        <div class="row">
            <div class="col-xs-12" style="margin-bottom:10px;">
                <div class="text-center">
                    <strong>
                    @if (count($book->authors) > 1)
                        Authors:
                    @else
                        Author:
                    @endif
                    </strong><br>

                    @foreach ($book->authors as $author)
                        <a data-toggle="tooltip" title="About [[ $author->name_on_book ]]" href="[[ URL::to('author/about', $author->name_on_book) ]]">
                            [[ $author->name_on_book ]]
                        </a>
                        <br>
                    @endforeach
                </div>
            </div>

            <div class="row" style="margin-top:30px;">
                <div class="col-xs-12 col-sm-4">
                    @if($book->coverExists())
                        <div class="cover-image ih-item square effect7">
                            <a href="[[ URL::to('buybook', array($book->book_id, 'all')) ]]" class="portfolio-box">
                                <div class="img">
                                    <img width=300 class="img-responsive center-block img-rounded" src="[[URL::asset( $book->coverShortPath() )]]" alt="[[ $book->title ]]">
                                </div>

                                <div class="info">
                                    <h3>[[ $book->title ]]</h3>
                                    <p>
                                        <i class="fa fa-money"></i> Buy [[ $book->title ]]
                                    </p>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="cover-image ih-item square effect7">
                            <div class="img">
                                <img width=300 width=250 style="border: 2px solid #233140;" class="img-responsive center-block" src="[[URL::asset('images/bookcovers/no_cover.gif')]]" alt="[[ $book->title ]]">
                            </div>
                        </div>
                    @endif

                    <div class="text-center">
                        <div class="fb-like" data-href="[[ Request::url() ]]" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true">
                        </div>
                    </div>
                    <br>
                    <br>

                    <div class="text-center">
                        <strong><u>Available In:</u></strong>
                    </div>

                    <div class="text-center">
                        @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists())
                            <strong>Electronic</strong>
                            <br>
                        @endif

                        @if ($book->epubFinalExists() )
                            <a data-toggle="tooltip" title="Buy in ePub format" href ="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#electronic">
                                <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="60" src="[[URL::asset('images/filetypes/epub.svg')]]" alt="Buy in ePub format" />
                            </a>
                        @endif

                        @if ($book->pdfFinalExists() )
                            <a data-toggle="tooltip" title="Buy in PDF format" href ="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#electronic">
                                <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="60" src="[[URL::asset('images/filetypes/pdf.svg')]]" alt="Buy in PDF format" />
                            </a>
                        @endif

                        @if ($book->txtFinalExists() )
                            <a data-toggle="tooltip" title="Buy in TXT format" href ="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#electronic">
                                <img  class="wow tada hvr-bounce-in" data-wow-duration="0s" width="60" src="[[URL::asset('images/filetypes/txt.svg')]]" alt="Buy in TXT format" />
                            </a>
                        @endif

                        @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists())
                            <br> $[[ number_format($book->electronic_price, 2, '.', ',') ]] (CAD)
                            <br>
                            <br>
                        @endif

                        @if ($book->mp3FinalExists())
                            <strong>Audio</strong>
                            <br>
                            <a data-toggle="tooltip" title="Buy in MP3 format" href ="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#audio">
                                <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="60" src="[[URL::asset('images/filetypes/mp3.gif')]]" alt="Buy in MP3 format" />
                            </a>
                            <br>
                            $[[ number_format($book->audio_price, 2, '.', ',') ]] (CAD)
                            <br>
                            <br>
                        @endif

                        @if ($book->in_soft || $book->in_hard)
                            <strong>Physical</strong>
                            <br>
                        @endif

                        <div class="row">
                            @if ($book->in_soft && $book->in_hard)
                                <div class="col-sm-offset-1 col-sm-5">
                            @elseif ($book->in_soft && !$book->in_hard)
                                <div class="col-sm-offset-4 col-sm-5">
                            @endif

                                @if ($book->in_soft)
                                    <a data-toggle="tooltip" title="Buy in Paperback format" href="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#physical">
                                        <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="50" src="[[URL::asset('images/filetypes/paperback.svg')]]" alt="Buy in Paperback format" />
                                    </a>
                                    <br>
                                    $[[ number_format($book->soft_price, 2, '.', ',') ]] (CAD)
                                @endif

                            @if ($book->in_soft && $book->in_hard)
                                </div>
                            @elseif ($book->in_soft && !$book->in_hard)
                                </div>
                            @endif

                            @if ($book->in_soft && $book->in_hard)
                                <div class="col-sm-5">
                            @elseif ($book->in_hard && !$book->in_soft)
                                <div class="col-sm-offset-4 col-sm-5">
                            @endif

                                @if ($book->in_hard)
                                    <a data-toggle="tooltip" title="Buy in Hardcover format" href="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#physical">
                                        <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="50" src="[[URL::asset('images/filetypes/hardcover.svg')]]" alt="Buy in Hardcover format" />
                                    </a>
                                    <br>
                                    $[[ number_format($book->hard_price, 2, '.', ',') ]] (CAD)
                                @endif

                            @if ($book->in_soft && $book->in_hard)
                                </div>
                            @elseif ($book->in_hard && !$book->in_soft)
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4">
                    <h3>Summary</h3>
                </div>

                <div class="hidden-xs col-sm-4">
                    <div class="fa-2x text-center">
                        [!! $book->getStars() !!]
                    </div>

                    <div class="text-center">
                        [[ $book->getRating() ]] / 5.0 ([[$book->getNumberValidComments()]] comments)
                    </div>
                </div>

                <div class="col-xs-12 col-sm-8" style="margin-top:10px; margin-bottom:30px">
                    <p>[[ $book->description ]]</p>
                </div>

                <div class="text-center" style="margin-bottom:30px">
                    @if($book->txtSampleExists())
                        <a class="btn btn-lg btn-primary hvr-bounce-in" data-wow-duration="0s" href="[[ URL::to('booksample', array($book->book_id)) ]]">
                            <i class="fa fa-book"></i> Read Sample
                        </a>
                        or
                    @endif
                    <a class="btn btn-lg btn-primary wow tada hvr-bounce-in" data-wow-duration="0s" href="[[ URL::to('buybook', array($book->book_id, 'all')) ]]">
                        <i class="fa fa-money"></i> Buy Now
                    </a>
                </div>

                <div class="artContainer center-block">
                    @if ($images != null)
                        @foreach($images as $image)
                            <a href="[[ URL::asset( $image ) ]]">
                                <img class="bookArt img-responsive" src="[[URL::asset( $image )]]" alt="[[ $book->title ]]">
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            [!! $comments !!]
        </div>
    @endif
</div>
<!-- /.container -->


@stop

@section('javascripts')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4&appId=726168714129895";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<script>
    // this is the id of the submit button
    $(".like_book_comment").click(function() {
   var sender =$(this);
    var comment_id = sender.data("comment-id");
        $.ajax({
               type: "POST",
               url: "[[URL::to('bookComment/agree')]]",
               data: {
                        comment_id: comment_id,
                     },
               success: function(data)
               {
                  location.reload();
               }
             });

        return false; // avoid to execute the actual submit of the form.
    });
</script>

<script>
    // this is the id of the submit button
    $(".dislike_book_comment").click(function() {
   var sender =$(this);
    var comment_id = sender.data("comment-id");
        $.ajax({
               type: "POST",
               url: "[[URL::to('bookComment/disagree')]]",
                data: {
                        comment_id: comment_id,
                     },
               success: function(data)
               {
                  location.reload();
               }
             });

        return false; // avoid to execute the actual submit of the form.
    });
</script>

<script>
// this is the id of the submit button

$(".delete_book_comment").click(function() {

    var sender =$(this);
    var comment_id = sender.data("comment-id");

     BootstrapDialog.confirm({
            title: '<i class="fa fa-trash-o"></i> Confirm Delete',
            message: 'Are you sure you want to delete your post?',
           // type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Cancel', // <-- Default value is 'Cancel',
            btnOKLabel: 'Delete', // <-- Default value is 'OK',
            btnOKClass: 'btn-danger', // <-- If you didn't specify it, dialog type will be used,
            callback: function(result) {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if(result) {

                     //var comment_id=$(this).attr('data-comment-id');
                    $.ajax({
                       type: "POST",
                       url: "[[URL::to('bookComment/delete')]]",
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
                       url: "[[URL::to('bookComment/report')]]",
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

 <script type="text/javascript">
        var bookID = "[[ $book->book_id ]]"; // used to ste the var to be passed through ajax call
    </script>

    <script src="[[ URL::asset('js/commentValidate.js') ]]"></script>
@stop
