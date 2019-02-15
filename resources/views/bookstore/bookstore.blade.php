<?php use App\Author; ?>
@extends('layouts.layout_main')
@section('title', 'AMPL Bookstore')
@section('metatags')
<meta name="keywords" content="ebook, ebooks, audio books, epub, pdf, mp3, books, bookstore, ebooks download, download, e books" />
<meta name="description" content="AMPL Publishing is a Canadian company, dedicated to produce and sell entertaining electronic fictional literature (e-books for e-readers). Aspiring Authors are welcome." />
<meta name="robots" content="index,follow,archive" />
<meta name="author" content="AMPL Publishing" />
@stop

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header">Online Bookstore</h1>
    </div>

    @foreach ($books->reverse() as $book)
        @if($book->status_id == 7 || $book->status_id == 5)
            <div class="row">
                <div class="col-xs-offset-1 col-xs-11">
                    <h2 class="book-title">[[ $book->title ]]</h2>
                </div>

                <div class="col-xs-12">
                    <div class="col-sm-4 col-xs-12 book-cover" style="padding:50px">
                        <div class="cover-image ih-item square effect7">
                            @if($book->coverExists())
                                <a href="[[ URL::to('bookpage', $book->book_id) ]]" class="portfolio-box">
                                    <div class="img">
                                        <img width=250 src="[[URL::asset( $book->coverShortPath() )]]" alt="img">
                                    </div>

                                    <div class="info">
                                        <h3>[[ $book->title ]]</h3>
                                        <p>
                                            <i class="fa fa-eye"></i> View [[ $book->title ]]
                                        </p>
                                    </div>
                                </a>
                            @else
                                <div class="img">
                                    <img width=250 src="[[URL::asset('images/bookcovers/no_cover.gif')]]" alt="img">
                                </div>
                            @endif
                        </div>

                        <div style="margin-top:5px; margin-bottom:10px" class="text-center">
                            <strong>Released:</strong> [[ date( 'F j, Y', strtotime($book->date_published)) ]]
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 text-center">
                        <p>
                            <strong>
                            @if (count($book->authors) > 1)
                                Authors:
                            @else
                                Author:
                            @endif
                            </strong><br>

                            @foreach ($book->authors as $author)
                                <a data-toggle='tooltip' title='About [[ $author->name_on_book ]]' href="[[ URL::to('author/about', $author->name_on_book) ]]">
                                    [[ $author->name_on_book ]]
                                </a>
                                <br>
                            @endforeach
                        </p>
                    </div>

                    <div class="col-xs-6 col-sm-4">
                        <div class="fa-2x text-center">
                            [!! $book->getStars() !!]
                        </div>

                        <div class="text-center">
                            <p>
                                [[ $book->getRating() ]] / 5.0 ([[ $book->getNumberValidComments()]] comments)
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-8 col-xs-12" style="margin-top:10px">
                        @if (strlen($book->description) > 250 )
                            <p>
                                [[ substr(strip_tags($book->description), 0, 250) ]]...
                            </p>
                            <a style="margin:10px;" href="[[ URL::to('bookpage', $book->book_id) ]]" class="btn btn-primary btn-xl wow tada hvr-bounce-in" data-wow-duration="0s">
                                <i class="fa fa-book"></i> READ MORE
                            </a>
                        @elseif (strlen($book->description) > 0)
                            <p>
                                [!! $book->description !!]
                            </p>
                        @else
                            <p>
                                <br>- Description not available
                            </p>
                        @endif
                    </div>

                    @if($book->status_id == 5)
                        <p>
                            This book is upcoming and has not been fully published yet!
                        </p>
                    @else
                        @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists() || $book->epubSampleExists() || $book->pdfSampleExists() || $book->txtSampleExists() || $book->mp3FinalExists() || $book->mp3SampleExists())
                            <div class="col-xs-12 col-md-4" style="margin-top:20px;">
                                <strong>Electronic versions:</strong>
                                <br>

                                <div style="margin-top:10px; white-space: nowrap;">
                                    <p>
                                        @if ($book->epubFinalExists() || $book->epubSampleExists())
                                            <a data-toggle='tooltip' title='Buy in ePUB format' href="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#electronic">
                                                <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="50" src="[[URL::asset('images/filetypes/epub.svg')]]" alt="Buy in ePUB format" />
                                            </a>
                                        @endif

                                        @if ($book->pdfFinalExists() || $book->pdfSampleExists())
                                            <a data-toggle='tooltip' title='Buy in PDF format' href="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#electronic">
                                                <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="50" src="[[URL::asset('images/filetypes/pdf.svg')]]" alt="Buy in PDF format" />
                                            </a>
                                        @endif

                                        @if ($book->txtFinalExists() || $book->txtSampleExists())
                                            <a data-toggle='tooltip' title='Buy in TXT format' href="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#electronic">
                                                <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="50" src="[[URL::asset('images/filetypes/txt.svg')]]" alt="Buy in TXT format" />
                                            </a>
                                        @endif

                                        @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists() || $book->epubSampleExists() || $book->pdfSampleExists() || $book->txtSampleExists())
                                            $[[ number_format($book->electronic_price, 2, '.', ',') ]] (CAD)
                                            <br><br>
                                        @endif

                                        @if ($book->mp3FinalExists() || $book->mp3SampleExists())
                                            <a data-toggle='tooltip' title='Buy in MP3 format' href="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#audio">
                                                <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="50" src="[[URL::asset('images/filetypes/mp3.svg')]]" alt="Buy in MP3 format" />
                                            </a>
                                            $[[ number_format($book->audio_price, 2, '.', ',') ]] (CAD)
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if ($book->in_hard || $book->in_soft)
                            <div class="col-xs-12 col-md-4" style="margin-top:20px">
                                <strong>Physical versions:</strong>
                                <br>
                                <div style="margin-top:10px; white-space: nowrap;">
                                    <p>
                                        @if ($book->in_soft )
                                            <a data-toggle='tooltip' title='Buy in Paperback format' href="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#physical">
                                                <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="50" src="[[URL::asset('images/filetypes/paperback.svg')]]" alt="Buy in Paperback format" />
                                            </a>
                                            $[[ number_format($book->soft_price, 2, '.', ',') ]] (CAD)
                                            <br><br>
                                        @endif

                                        @if ($book->in_hard )
                                            <a data-toggle='tooltip' title='Buy in Hardcover format' href="[[ URL::to('buybook', array($book->book_id, 'all')) ]]#physical">
                                                <img class="wow tada hvr-bounce-in" data-wow-duration="0s" width="50" src="[[URL::asset('images/filetypes/hardcover.svg')]]" alt="Buy in Hardcover format" />
                                            </a>
                                            $[[ number_format($book->hard_price, 2, '.', ',') ]] (CAD)
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <hr>
        @endif
    @endforeach
</div>
<!-- /.container -->

@stop
