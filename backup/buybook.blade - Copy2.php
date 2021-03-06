@extends('layouts.layout_main')
@section('title') Purchase [[ $book->title ]] in [[ $format ]] @stop
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
            <div class="col-sm-4 col-xs-12">
                <a href="[[ URL::to('bookpage', $book->book_id) ]]">
                    @if($book->coverExists())
                        <img width=250  style="border: 2px solid #233140;" class="img-rounded cover-image center-block" src="[[URL::asset(  $book->coverShortPath() )]]" alt="[[ $book->title ]]">
                    @else
                        <img width=250  style="border: 2px solid #233140;" class="img-rounded cover-image center-block" src="[[URL::asset('images/bookcovers/no_cover.gif')]]" alt="[[ $book->title ]]">
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
                    <li role="presentation" class="active"><a href="#electronic_panel" role="tab" data-toggle="tab"><i class="fa fa-television" id="electronic"></i> Electronic</a></li>
                    <li role="presentation"><a href="#audio_panel" role="tab" data-toggle="tab"><i class="fa fa-music" id="audio"></i> Audio</a></li>
                    <li role="presentation"><a href="#physical_panel" role="tab" data-toggle="tab"><i class="fa fa-book" id="physical"></i> Physical</a></li>
                </ul>
                <br>

                <!-- Electronic Panel -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active fade in" id="electronic_panel">
                        <p>
                            Please confirm if you would like to download the sample or purchase the complete E-Book. This gives you access to all the available electronic formats.
                        </p>

                        <!-- EPUB Version -->
                        @if ($book->epubFinalExists() and $format === 'epub')
                            @if($book->epubSampleExists())
                                <img height="100" src="[[URL::asset('images/filetypes/epub_sample.svg')]]" alt="epub sample" />
                                <a style="width:200px" data-toggle='tooltip' class="btn btn-primary btn-md" title='Download Epub sample' href="[[ URL::to('download/sample', array($book->book_id, '2')) ]]">
                                    <i class="fa fa-download"></i> Download Sample
                                </a>
                                <br>
                                <br>
                            @endif

                            <img type="submit" height="100" src="[[URL::asset('images/filetypes/epub_full.svg')]]" alt="epub full version" />
                            <a href="#" data-toggle="modal" data-target="#login_modal" style="width:200px" class="btn btn-primary btn-md">
                                <i class="fa fa-cc-paypal"></i> Buy now
                            </a>
                            
                            <form name="epubForm" style="display:inline">
                                <br>
                                This button throws a $quantity error:
                                <button ng-cloak data-ng-click="addBook([[$book->book_id]],2,epubForm)" class="btn btn-primary btn-md" title="Add ePUB to cart" data-toggle="tooltip">
                                    {{ epubButton }}
                                </button>
                            </form>

                        <!-- Text Version -->
                        @elseif ($book->txtFinalExists() and $format === 'text')
                            @if($book->txtSampleExists())
                                <img height="100" src="[[URL::asset('images/filetypes/txt_sample.svg')]]" alt="pdf_sample" />
                                <a style="width:250px" data-toggle='tooltip' class="btn btn-primary btn-md" title='Download Pdf sample' href="[[ URL::to('download/sample', array($book->book_id, '1')) ]]">
                                    <i class="fa fa-download"></i> Download Sample
                                </a>
                                <br>
                                <br>
                            @endif

                            <img height="100" src="[[URL::asset('images/filetypes/txt_full.svg')]]" alt="txt full version" />
                            <a href="#" data-toggle="modal" data-target="#login_modal" style="width:200px" class="btn btn-primary btn-md">
                                <i class="fa fa-cc-paypal"></i> Buy now
                            </a>
                            <a href="#" data-toggle="modal" data-target="#login_modal">
                                <button class="btn btn-primary btn-md" onclick="#login_modal">
                                    {{ hardButton }}
                                </button>
                            </a>

                        <!-- PDF Version -->
                        @elseif ($book->pdfFinalExists())
                            @if($book->pdfSampleExists())
                                <img height="100" src="[[URL::asset('images/filetypes/pdf_sample.svg')]]" alt="pdf sample" />
                                <a style="width:250px" data-toggle='tooltip' class="btn btn-primary btn-md" title='Download Pdf sample' href="[[ URL::to('download/sample', array($book->book_id, '3')) ]]">
                                    <i class="fa fa-download"></i> Download Sample
                                </a>
                                <br>
                                <br>
                            @endif

                            <img height="100" src="[[URL::asset('images/filetypes/pdf_full.svg')]]" alt="pdf full version" />
                            <a href="#" data-toggle="modal" data-target="#login_modal" style="width:200px" class="btn btn-primary btn-md">
                                <i class="fa fa-cc-paypal"></i> Buy now
                            </a>
                            <a href="#" data-toggle="modal" data-target="#login_modal">
                                <button class="btn btn-primary btn-md" onclick="#login_modal">
                                    {{ hardButton }}
                                </button>
                            </a>
                        @endif

                        <!-- Display electronic price -->
                        @if ($book->epubFinalExists() || $book->txtFinalExists() || $book->pdfFinalExists())
                             $[[ number_format($book->electronic_price, 2, '.', ',') ]] (CAD)
                        @endif
                    </div>

                    <!-- Audio Panel -->
                    <div role="tabpanel" class="tab-pane fade" id="audio_panel">
                        <p>
                            Please confirm if you would like to download the sample or purchase the complete E-Book audio version. This gives you access to the book in the MP3 format.
                        </p>

                        <!-- Audio Version -->
                        @if ($book->mp3FinalExists())
                            @if($book->mp3SampleExists())
                                <img height="100" src="[[URL::asset('images/filetypes/mp3_sample.svg')]]" alt="mp3 sample" />
                                <a style="width:250px" data-toggle='tooltip' class="btn btn-primary btn-md" title='Download Mp3 sample' href="[[ URL::to('download/sample', array($book->book_id, '4')) ]]">
                                    <i class="fa fa-download"></i> Download Sample
                                </a>
                                <br>
                                <br>
                            @endif

                            <img height="100" src="[[URL::asset('images/filetypes/mp3_full.svg')]]" alt="mp3 full version" />
                            <a href="#" data-toggle="modal" data-target="#login_modal" style="width:200px" class="btn btn-primary btn-md">
                                <i class="fa fa-cc-paypal"></i> Buy now
                            </a>
                            <a href="#" data-toggle="modal" data-target="#login_modal">
                                <button class="btn btn-primary btn-md" onclick="#login_modal">
                                    {{ hardButton }}
                                </button>
                            </a>
                            
                            $[[ number_format($book->audio_price, 2, '.', ',') ]] (CAD)
                        @endif

                        <a class="pull-right" href="https://www.paypal.com/ca/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/ca/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
                            <img height="100" src="https://www.paypalobjects.com/webstatic/en_CA/mktg/logo-image/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark">
                        </a>
                    </div>

                    <!-- Physical Panel-->
                    <div role="tabpanel" class="tab-pane fade" id="physical_panel"  >
                        @if ($book->in_hard || $book->in_soft )
                            <p>
                                Order a copy of [[ $book->title ]] online today! Addition shipping charges may apply.
                            </p>

                            <!-- Hardcover Version -->
                            @if ($book->in_hard )
                                <div>
                                    <a data-toggle='tooltip' title='Buy in TXT format' href="[[ URL::to('buybook', array($book->book_id, 'text')) ]]">
                                        <img class="hvr-pulse" height="100" class="pull-right" src="[[URL::asset('images/filetypes/hardcover_order.svg')]]" alt="txt" />
                                    </a>

                                    <form name="hardForm" style="display:inline">
                                        <button data-ng-click="hardDown()" class="btn btn-default" >
                                            <i class="fa fa-minus-circle"></i>
                                        </button>

                                        <input data-ng-model="hard_quantity" type="number" id="hard_number" style="width:50px" value="{{ hard_quantity }}" min="1" max="99" />

                                        <button data-ng-click="hardUp()" class="btn btn-default" >
                                            <i class="fa fa-plus-circle"></i>
                                        </button>

                                        <button ng-cloak data-ng-click="addBook([[$book->book_id]],6, hardForm)" class="btn btn-primary btn-md"  title="Add hardcover to cart" data-toggle="tooltip">
                                            {{ hardButton}}
                                        </button>
                                    </form>
                                    $[[ number_format($book->hard_price, 2, '.', ',') ]] (CAD)
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

                            <!-- Paperback Version -->
                            @if ($book->in_soft )
                                <div>
                                    <a data-toggle='tooltip' title='Buy in TXT format' href="[[ URL::to('buybook', array($book->book_id, 'text')) ]]">
                                        <img class="hvr-pulse" height="100" src="[[URL::asset('images/filetypes/paperback_order.svg')]]" alt="txt" />
                                    </a>

                                    <form name="softForm" style="display:inline">
                                        <button data-ng-click="softDown()" class="btn btn-default" >
                                            <i class="fa fa-minus-circle"></i>
                                        </button>
                                        
                                        <input data-ng-id="" data-ng-model="soft_quantity" value="{{ soft_quantity }}"  style="width:50px" min="1" max="99" />
                                        
                                        <button data-ng-click="softUp()" class="btn btn-default" >
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                        
                                        <button ng-cloak data-ng-click="addBook([[$book->book_id]],5)" type="submit" data-book-id="[[$book->book_id]]" class=" btn btn-primary btn-md"  title="Add paperback to cart" data-toggle="tooltip">
                                            {{ softButton}}
                                        </button>
                                    </form>
                                    $[[ number_format($book->soft_price, 2, '.', ',') ]] (CAD)
                                </div>
                                <br>

                                <div id="soft_message" style="background-color: #fcf8e3; width: 50%;" class="remove-button" ng-if="hasSoft">
                                    This item is in your cart.
                                    <a href="" class="book-soft-remove" data-ng-click="deleteBook([[$book->book_id]],5)" data-book-id="[[$book->book_id]]" data-type-id=5>
                                        Remove
                                    </a>
                                </div>
                            @endif
                        @else
                            Not available
                        @endif
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <hr>
    </div>
</div>
<!-- /.container -->

@stop

@section('scripts')
<script>
    var book_id="[[ $book->book_id ]]";
</script>

<script src='https://www.paypalobjects.com/js/external/dg.js' type='text/javascript'></script>

<script>
    var dg = new PAYPAL.apps.DGFlow({
        trigger: 'paypal_submit',
        expType: 'instant'
    });
</script>
@stop
