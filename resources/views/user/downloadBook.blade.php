@extends('layouts.layout_main')
@section('title', 'AMPL Homepage')

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-download"></i> Download "[[ $book->title ]]"</h1>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="col-sm-4 col-xs-12">
                <a href="[[ URL::to('bookpage', $book->book_id) ]]">
                    @if($book->coverExists())
                        <img width=250  style="border: 2px solid #233140;" class=" book-cover img-responsive center-block" src="[[URL::asset( $book->coverShortPath() )]]" alt="[[ $book->title ]]">
                    @else
                        <img width=250  style="border: 2px solid #233140;" class=" book-cover img-responsive center-block" src="[[URL::asset('images/bookcovers/no_cover.gif')]]" alt="[[ $book->title ]]">
                    @endif
                </a>
                
                <div style="margin-top:5px; margin-bottom:10px" class="text-center">
                    <strong>Released:</strong> [[ date( 'F j, Y', strtotime($book->date_published)) ]]
                </div>
            </div>

            <div class="col-xs-6 col-sm-4">
                <br>
                <p>
                    <strong>Author:</strong>
                    @foreach ($book->authors as $author)
                        <a data-toggle='tooltip' title='About [[ $author->name_on_book ]]' href="[[ URL::to('author', array($author->id, $author->name_on_book)) ]]">
                            [[ $author->name_on_book ]]
                        </a>
                        <br>
                    @endforeach
                </p>
            </div>

            <!--<div class="col-xs-6 col-sm-4">
                <div class="fa-2x text-center">
                    [[ $book->getStars() ]]
                </div>

                <div class="text-center">
                    <p>
                        [[ $book->getRating() ]] / 5.0 ([[ $book-> getNumberComments()]] comments)
                    </p>
                </div>
            </div>-->

            <div class="col-sm-8 col-xs-12" style="margin-top:10px">
                <p>
                    [[ $book->description]]
                </p>
                <hr>

                <div style="margin-top:10px; white-space: nowrap;">
                    <p>
                        @if($showElectronic or $showAudio)
                            <h2> Download Now</h2>

                            @if($showElectronic)
                                @if ($book->epubFinalExists() )
                                    <a style="margin-right:50px;" data-toggle='tooltip' title='Download in ePUB format' href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 2)) ]]">
                                        <img width="50" height="50" src="[[URL::asset('images/filetypes/epub.gif')]]" alt="epub" />ePUB <i class="fa fa-download"></i>
                                    </a>
                                @endif

                                @if ($book->pdfFinalExists() )
                                    <a style="margin-right:50px;" data-toggle='tooltip' title='Download in PDF format' href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 3)) ]]">
                                        <img width="50" height="50" src="[[URL::asset('images/filetypes/pdf.gif')]]" alt="pdf" />PDF <i class="fa fa-download"></i>
                                    </a>
                                @endif

                                @if ($book->txtFinalExists() )
                                    <a style="margin-right:50px;" data-toggle='tooltip' title='Download in TXT format' href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 1)) ]]">
                                        <img width="50" height="50" src="[[URL::asset('images/filetypes/txt.gif')]]" alt="txt" />Text <i class="fa fa-download"></i>
                                    </a>
                                @endif
                            @endif

                            @if($showAudio)
                                @if ($book->mp3FinalExists() )
                                    <a style="margin-right:50px;"data-toggle='tooltip' title='Download in MP3 format' href="[[ URL::to('download/final', array('id' => $book->book_id, 'type' => 4)) ]]">
                                        <img width="50" height="50" src="[[URL::asset('images/filetypes/mp3.gif')]]" alt="mp3" />Audio <i class="fa fa-download"></i>
                                    </a>
                                @endif
                            @endif
                        @else
                            <h2>No Downloads Available</h2>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container -->

@stop
