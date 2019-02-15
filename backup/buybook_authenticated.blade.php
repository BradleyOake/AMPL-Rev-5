@extends('layouts.layout_main')
@section('title') Purchase [[ $book->title ]] @stop
@section('description')[[ $book->m_description]] @stop
@section('keywords') [[ $book->m_keywords ]]@stop

@section('content')
<!-- Page Content -->
<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header">[[ $book->title ]]</h1>
    </div>

    <div class="row">
        <div class="col-xs-12">
                <div class="col-sm-4 col-xs-12 book-cover" style="padding:50px">
                    @if($book->coverExists())
                        <div class="cover-image ih-item square effect7">
                            <a href="[[ URL::to('bookpage', $book->book_id) ]]" class="portfolio-box">
                                <div class="img">
                                    <img width=250 style="border: 2px solid #233140;" class="img-rounded center-block" src="[[ URL::asset($book->coverShortPath()) ]]" alt="[[ $book->title ]]">
                                </div>
                            
                                <div class="info">
                                    <h3>[[ $book->title ]]</h3>
                                        <p>
                                            <i class="fa fa-eye"></i> View [[ $book->title ]]
                                        </p>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="cover-image ih-item square effect7">
                            <div class="img">
                                <img width=250 style="border: 2px solid #233140;" class="img-rounded center-block" src="[[ URL::asset('images/bookcovers/no_cover.gif') ]]" alt="[[ $book->title ]]">
                            </div>
                        </div>
                    @endif
                    
                    <div style="margin-top:5px; margin-bottom:10px" class="text-center">
                        <strong>Released:</strong> [[ date( 'F j, Y', strtotime($book->date_published)) ]]
                    </div>
                </div>

                <div class="col-xs-6 col-sm-4">
                    <br>
                    <p>
                        <strong>Author:</strong>
                        @foreach ($book->authors as $author)
                            <a data-toggle="tooltip" title="About [[ $author->name_on_book ]]" href="[[ URL::to('author', array($author->id, $author->name_on_book)) ]]">
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
                <h2> Purchase: [[ $book->title ]] </h2>
                <ul class="nav nav-pills" role="tablist" id="myPill">
                    @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists() || $book->epubSampleExists() || $book->pdfSampleExists() || $book->txtSampleExists())
                        <li role="presentation" class="active"><a href="#electronic_panel" role="tab" data-toggle="tab"><i class="fa fa-television" id="electronic"></i> Electronic</a></li>
                    @endif

                    @if ($book->mp3FinalExists() || $book->mp3SampleExists())
                        @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists() || $book->epubSampleExists() || $book->pdfSampleExists() || $book->txtSampleExists())
                            <li role="presentation"><a href="#audio_panel" role="tab" data-toggle="tab"><i class="fa fa-music" id="audio"></i> Audio</a></li>
                        @else
                            <li role="presentation" class="active"><a href="#audio_panel" role="tab" data-toggle="tab"><i class="fa fa-music" id="audio"></i> Audio</a></li>
                        @endif
                    @endif

                    @if ($book->in_hard || $book->in_soft)
                        @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists() || $book->epubSampleExists() || $book->pdfSampleExists() || $book->txtSampleExists() || $book->mp3FinalExists() || $book->mp3SampleExists())
                            <li role="presentation"><a href="#physical_panel" role="tab" data-toggle="tab"><i class="fa fa-book" id="physical"></i> Physical</a></li>
                        @else
                            <li role="presentation" class="active"><a href="#physical_panel" role="tab" data-toggle="tab"><i class="fa fa-book" id="physical"></i> Physical</a></li>
                        @endif
                    @endif
                </ul>
                <br>
                
                <!-- ===========================
                =====   Electronic Panel   =====
                ============================ -->
                <div class="tab-content" style="text-align:center;">
                    @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists() || $book->epubSampleExists() || $book->pdfSampleExists() || $book->txtSampleExists())
                        <div role="tabpanel" class="tab-pane active fade in" id="electronic_panel">
                            <p style="text-align:initial;">
                                Please confirm if you would like to download the sample or purchase the complete E-Book. This gives you access to all the available electronic formats.
                            </p>

                            <!-- Display electronic price -->
                            <p>
                                <strong>$[[ number_format($book->electronic_price, 2, '.', ',') ]] (CAD)</strong>
                            </p>

                            <!-- ePUB Version -->
                            @if ($book->epubFinalExists())
                                @if($book->epubSampleExists())
                                    <img height="100" src="[[URL::asset('images/filetypes/epub_sample.svg')]]" alt="ePUB sample" />
                                    <a style="width:39%;" data-toggle="tooltip" class="btn btn-primary btn-md" title="Download Epub sample" href="[[ URL::to('download/sample', array($book->book_id, '2')) ]]">
                                        <i class="fa fa-download"></i> Download ePUB Sample
                                    </a>
                                    <br>
                                    <br>
                                @endif

                                <img height="100" src="[[URL::asset('images/filetypes/epub_full.svg')]]" alt="ePUB full version" />
                                <span style="display:inline-block; width:38%; vertical-align:top; margin-top:5px;">
                                    <form action="[[ URL::to('paypal/checkout') ]]"} METHOD="POST" style="display:inline; width:100%;">
                                        <input type="hidden" name="book_id" value="[[ $book->book_id ]]">
                                        <input type="hidden" name="type_id" value="2">
                                        <button type="submit" name="paypal_submit" id="paypal_submit" style="width:100%;" class="btn btn-primary btn-md" title="Purchase ePUB" type="image">
                                            <i class="fa fa-cc-paypal"></i> Buy Now
                                        </button>
                                    </form>
                                    <br><br>
                                    <button style="width:100%;" ng-cloak data-ng-click="addBook([[$book->book_id]], 2, epubForm)" class="btn btn-primary btn-md" title="Add ePUB to cart" data-toggle="tooltip">
                                        <i class="fa fa-cart-plus"></i> {{ epubButton }}
                                    </button>
                                </span>
                                <br><br><br>
                            @endif

                            <!-- PDF Version -->
                            @if($book->pdfFinalExists())
                                @if($book->pdfSampleExists())
                                    <img height="100" src="[[URL::asset('images/filetypes/pdf_sample.svg')]]" alt="PDF sample version" />
                                    <a style="width:39%;" data-toggle="tooltip" class="btn btn-primary btn-md" title="Download PDF sample" href="[[ URL::to('download/sample', array($book->book_id, '3')) ]]">
                                        <i class="fa fa-download"></i> Download Sample
                                    </a>
                                    <br>
                                    <br>
                                @endif

                                <img height="100" src="[[URL::asset('images/filetypes/pdf_full.svg')]]" alt="PDF full version" />
                                <span style="display:inline-block; width:38%; vertical-align:top; margin-top:5px;">
                                    <form action="[[ URL::to('paypal/checkout') ]]"} METHOD="POST" style="display:inline; width:100%;">
                                        <input type="hidden" name="book_id" value="[[ $book->book_id ]]">
                                        <input type="hidden" name="type_id" value="3">
                                        <button type="submit" name="paypal_submit" id="paypal_submit" style="width:100%;" class="btn btn-primary btn-md" title="Purchase PDF" type="image">
                                            <i class="fa fa-cc-paypal"></i> Buy Now
                                        </button>
                                    </form>
                                    <br><br>
                                    <button style="width:100%;" ng-cloak data-ng-click="addBook([[$book->book_id]], 3, pdfForm)" class="btn btn-primary btn-md" title="Add PDF to cart" data-toggle="tooltip">
                                        <i class="fa fa-cart-plus"></i> {{ pdfButton }}
                                    </button>
                                </span>
                                <br><br><br>
                            @endif

                            <!-- Text Version -->
                            @if($book->txtFinalExists())
                                @if($book->txtSampleExists())
                                    <img height="100" src="[[URL::asset('images/filetypes/txt_sample.svg')]]" alt="TXT sample version" />
                                    <a style="width:39%;" data-toggle="tooltip" class="btn btn-primary btn-md" title="Download TXT sample" href="[[ URL::to('download/sample', array($book->book_id, '1')) ]]">
                                        <i class="fa fa-download"></i> Download Sample
                                    </a>
                                    <br>
                                    <br>
                                @endif

                                <img height="100" src="[[URL::asset('images/filetypes/txt_full.svg')]]" alt="TXT full version" />
                                <span style="display:inline-block; width:38%; vertical-align:top; margin-top:5px;">
                                    <form action="[[ URL::to('paypal/checkout') ]]"} METHOD="POST" style="display:inline; width:100%;">
                                        <input type="hidden" name="book_id" value="[[ $book->book_id ]]">
                                        <input type="hidden" name="type_id" value="1">
                                        <button type="submit" name="paypal_submit" id="paypal_submit" style="width:100%;" class="btn btn-primary btn-md" title="Purchase TXT" type="image">
                                            <i class="fa fa-cc-paypal"></i> Buy Now
                                        </button>
                                    </form>
                                    <br><br>
                                    <button style="width:100%;" ng-cloak data-ng-click="addBook([[$book->book_id]], 1, txtForm)" class="btn btn-primary btn-md" title="Add TXT to cart" data-toggle="tooltip">
                                        <i class="fa fa-cart-plus"></i> {{ txtButton }}
                                    </button>
                                </span>
                                <br><br><br>
                            @endif
                        </div>
                    @endif


                    <!-- ======================
                    =====   Audio Panel   =====
                    ======================= -->
                    @if ($book->mp3FinalExists() || $book->mp3SampleExists())
                        @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists() || $book->epubSampleExists() || $book->pdfSampleExists() || $book->txtSampleExists())
                            <div role="tabpanel" class="tab-pane fade" id="audio_panel">
                        @else
                            <div role="tabpanel" class="tab-pane active fade in" id="audio_panel">
                        @endif

                            <p style="text-align:initial;">
                                Please confirm if you would like to download the sample or purchase the complete E-Book audio version. This gives you access to the book in the MP3 format.
                            </p>

                            <!-- Audio Version -->

                            <p>
                                <strong>$[[ number_format($book->audio_price, 2, '.', ',') ]] (CAD)</strong>
                            </p>
                            @if ($book->mp3SampleExists())
                                <img height="100" src="[[URL::asset('images/filetypes/mp3_sample.svg')]]" alt="MP3 sample version" />
                                <a style="width:39%;" data-toggle="tooltip" class="btn btn-primary btn-md" title="Download MP3 sample" href="[[ URL::to('download/sample', array($book->book_id, '4')) ]]">
                                    <i class="fa fa-download"></i> Download Sample
                                </a>
                                <br>
                                <br>
                            @endif

                            <img height="100" src="[[URL::asset('images/filetypes/mp3_full.svg')]]" alt="MP3 full version" />
                            <span style="display:inline-block; width:38%; vertical-align:top; margin-top:5px;">
                                <form action="[[ URL::to('paypal/checkout') ]]"} METHOD="POST" style="display:inline; width:100%;">
                                    <input type="hidden" name="book_id" value="[[ $book->book_id ]]">
                                    <input type="hidden" name="type_id" value="4">
                                    <button type="submit" name="paypal_submit" id="paypal_submit" style="width:100%;" class="btn btn-primary btn-md"  title="Purchase MP3" type="image">
                                        <i class="fa fa-cc-paypal"></i> Buy Now
                                    </button>
                                </form>
                                <br><br>
                                <button style="width:100%;" ng-cloak data-ng-click="addBook([[$book->book_id]], 4, mp3Form)" class="btn btn-primary btn-md" title="Add MP3 to cart" data-toggle="tooltip">
                                    <i class="fa fa-cart-plus"></i> {{ mp3Button }}
                                </button>
                            </span>
                            <br><br><br>
                        </div>
                    @endif


                    <!-- =========================
                    =====   Physical Panel   =====
                    ========================== -->
                    @if ($book->in_hard || $book->in_soft)
                        @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists() || $book->epubSampleExists() || $book->pdfSampleExists() || $book->txtSampleExists() || $book->mp3FinalExists() || $book->mp3SampleExists())
                            <div role="tabpanel" class="tab-pane fade" id="physical_panel">
                        @else
                            <div role="tabpanel" class="tab-pane active fade in" id="physical_panel">
                        @endif
                            <p style="text-align:initial;">
                                Order a copy of [[ $book->title ]] online today! Addition shipping charges may apply.
                            </p>

                            <!-- Paperback Version -->
                            @if ($book->in_soft)
                                <p>
                                    <strong>$[[ number_format($book->soft_price, 2, '.', ',') ]] (CAD)</strong>
                                </p>

                                <div>
                                    <img height="100" src="[[URL::asset('images/filetypes/paperback_order.svg')]]" alt="Buy paperback version" />
                                    <span style="display: inline-block; width: 38%; vertical-align: top; margin-top:5px;">
                                        <form name="softForm" style="display:inline">
                                            <button data-ng-click="softDown()" class="btn btn-default" >
                                                <i class="fa fa-minus-circle"></i>
                                            </button>

                                            <input data-ng-id="" data-ng-model="soft_quantity" value="{{ soft_quantity }}"  style="width:50px" min="1" max="99" />

                                            <button data-ng-click="softUp()" class="btn btn-default" >
                                                <i class="fa fa-plus-circle"></i>
                                            </button>
                                            <br><br>

                                            <button style="width:75%" ng-cloak data-ng-click="addBook([[$book->book_id]],5)" type="submit" data-book-id="[[$book->book_id]]" class="btn btn-primary btn-md" title="Add paperback to cart" data-toggle="tooltip">
                                                <i class="fa fa-cart-plus"></i> {{ softButton}}
                                            </button>
                                        </form>
                                    </span>
                                </div>
                                <br>

                                <div id="soft_message" style="background-color: #fcf8e3; width: 50%;" class="remove-button" ng-if="hasSoft">
                                    This item is in your cart.
                                    <a href="#" class="book-soft-remove" data-ng-click="deleteBook([[$book->book_id]],5)" data-book-id="[[$book->book_id]]" data-type-id=5>
                                        Remove
                                    </a>
                                </div>
                            @endif

                            <!-- Hardcover Version -->
                            @if ($book->in_hard )
                                <p>
                                    <strong>$[[ number_format($book->hard_price, 2, '.', ',') ]] (CAD)</strong>
                                </p>

                                <div>
                                <img height="100" src="[[URL::asset('images/filetypes/hardcover_order.svg')]]" alt="Buy hardcover version" />
                                    <span style="display: inline-block; width: 38%; vertical-align: top; margin-top:5px;">
                                        <form name="hardForm" style="display:inline">
                                            <button data-ng-click="hardDown()" class="btn btn-default" >
                                                <i class="fa fa-minus-circle"></i>
                                            </button>

                                            <input data-ng-model="hard_quantity" type="number" id="hard_number" style="width:50px" value="{{ hard_quantity }}" min="1" max="99" />

                                            <button data-ng-click="hardUp()" class="btn btn-default" >
                                                <i class="fa fa-plus-circle"></i>
                                            </button>
                                            <br><br>

                                            <button style="width:75%" ng-cloak data-ng-click="addBook([[$book->book_id]], 6, hardForm)" class="btn btn-primary btn-md"  title="Add Hardcover to cart" data-toggle="tooltip">
                                                <i class="fa fa-cart-plus"></i> {{ hardButton}}
                                            </button>
                                        </form>
                                    </span>
                                    <br>
                                </div>
                                <br>

                                <div id="hard_message" style="background-color: #fcf8e3; width: 50%;" class="remove-button" ng-if="hasHard">
                                    This item is in your cart.
                                    <a href="#" class="book-hard-remove" data-ng-click="deleteBook([[$book->book_id]],6)" data-book-id="[[$book->book_id]]" data-type-id=6>
                                        Remove
                                    </a>
                                </div>
                                <br>
                            @endif
                        </div>
                    @endif
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container -->

@stop

@section('scripts')
<script>
    var book_id="[[ $book->book_id ]]";
</script>

<script src="https://www.paypalobjects.com/js/external/dg.js" type="text/javascript"></script>

<script>
    var dg = new PAYPAL.apps.DGFlow({
        trigger: 'paypal_submit',
        expType: 'instant'
    });
</script>
@stop
