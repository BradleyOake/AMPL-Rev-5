@extends('layouts.layout_main')
@section('title') Purchase [[ $book->title ]] @stop
@section('description')[[ $book->m_description]] @stop
@section('keywords') [[ $book->m_keywords ]]@stop
@section('content')

<div class="container main-content">
    @if($book->status() == 'Quarantined')
        This page is currently not available. Please browse our other amazing books at our <a href="[[URL::to('bookstore')]]">Bookstore</a>.
    @else
        <!-- Page Content -->
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

                @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists() || $book->epubSampleExists() || $book->pdfSampleExists() || $book->txtSampleExists() || $book->mp3FinalExists() || $book->mp3SampleExists() || $book->in_hard || $book->in_soft)
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

                        <div class="tab-content" style="text-align:center;">
                            <!-- ===========================
                            =====   Electronic Panel   =====
                            ============================ -->
                            @if ($book->epubFinalExists() || $book->pdfFinalExists() || $book->txtFinalExists() || $book->epubSampleExists() || $book->pdfSampleExists() || $book->txtSampleExists())
                                <div role="tabpanel" class="tab-pane active fade in" id="electronic_panel">
                                    @if(Auth::check())
                                        <!-- ============================
                                        =====   LOGGED IN - BEGIN   =====
                                        ============================= -->
                                        @if ($book->isOwned(Auth::user()->email, 0) && $book->hasAccess(Auth::user()->email, '0'))
                                            <p style="text-align:initial;">
                                                You already own this book, please visit <a href="[[URL::to('user/downloadBook/'.$book->book_id)]]">this</a> page to download it!
                                            </p>
                                        @elseif ($book->isOwned(Auth::user()->email, 0) && !$book->hasAccess(Auth::user()->email, '0'))
                                          <div class="form-group text-center">
                                              <p> Purchases over 60 days old cannot cannot be redownloaded, please <a href="[[ URL::to('contact') ]]">contact</a> AMPL to gain access to the book.</p>
                                          </div>
                                        @else
                                            <!-- ===========================================
                                            =====   LOGGED IN BUT DOES NOT OWN EBOOK   =====
                                            ============================================ -->
                                            <p style="text-align:initial;">
                                                Please confirm if you would like to download the sample or purchase the complete E-Book. This gives you access to all the available electronic formats.
                                            </p>

                                            <p>
                                                <strong>$[[ number_format($book->electronic_price, 2, '.', ',') ]] (CAD)</strong><br><br>
                                                <form action="[[ URL::to('paypal/checkout') ]]"} METHOD="POST" style="display:inline; width:100%;">
                                                    <input type="hidden" name="book_id" value="[[ $book->book_id ]]">
                                                    <input type="hidden" name="type_id" value="0">

                                                    <button type="submit" name="paypal_submit" id="paypal_submit" style="width:20%;" class="btn btn-primary btn-md" title="Purchase eBook" type="image">
                                                        <i class="fa fa-cc-paypal"></i> Buy Now
                                                    </button>
                                                </form>
                                               

                                                <button style="width:20%" ng-cloak data-ng-click="addBook([[$book->book_id]],0,ebookForm)" id="ebookButton" class="btn btn-primary btn-md" title="Add eBook to cart" data-toggle="tooltip">
                                                    <i class="fa fa-cart-plus"></i> {{ ebookButton }}
                                                </button>
                                            </p>
                                            
                                            <div id="ebook_message" style="background-color: #fcf8e3;" class="remove-button" ng-if="hasEbook">
                                                This item is in your cart.
                                                <a href="" class="book-hard-remove" data-ng-click="deleteBook([[$book->book_id]],0)" data-book-id="[[$book->book_id]]" data-type-id=0>
                                                    Remove
                                                </a>
                                            </div>
                                            
                                            <br>

                                            <!-- eBook Samples -->
                                            <div class="row">
                                                @if($book->epubSampleExists())
                                                    <div class="col-sm-4">
                                                        <img height="100" src="[[URL::asset('images/filetypes/epub_sample.svg')]]" alt="ePUB sample version" /><br><br>
                                                        <a data-toggle='tooltip' class="btn btn-primary btn-md" title='Download ePUB sample' href="[[ URL::to('download/sample', array($book->book_id, '2')) ]]">
                                                            <i class="fa fa-download"></i> Download ePUB Sample
                                                        </a>
                                                    </div>
                                                @endif

                                                @if($book->pdfSampleExists())
                                                    <div class="col-sm-4">
                                                        <img height="100" src="[[URL::asset('images/filetypes/pdf_sample.svg')]]" alt="PDF sample version" /><br><br>
                                                        <a data-toggle='tooltip' class="btn btn-primary btn-md" title='Download PDF sample' href="[[ URL::to('download/sample', array($book->book_id, '3')) ]]">
                                                            <i class="fa fa-download"></i> Download PDF Sample
                                                        </a>
                                                    </div>
                                                @endif

                                                @if($book->txtSampleExists())
                                                    <div class="col-sm-4">
                                                        <img height="100" src="[[URL::asset('images/filetypes/txt_sample.svg')]]" alt="TXT sample version" /><br><br>
                                                        <a data-toggle='tooltip' class="btn btn-primary btn-md" title='Download TXT sample' href="[[ URL::to('download/sample', array($book->book_id, '1')) ]]">
                                                            <i class="fa fa-download"></i> Download TXT Sample
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- ==========================
                                        =====   LOGGED IN - END   =====
                                        =========================== -->
                                    @else
                                        <!-- ================================
                                        =====   NOT LOGGED IN - BEGIN   =====
                                        ================================= -->
                                        <p style="text-align:initial;">
                                            Please confirm if you would like to download the sample or purchase the complete E-Book. This gives you access to all the available electronic formats.
                                        </p>

                                        <p>
                                            <strong>$[[ number_format($book->electronic_price, 2, '.', ',') ]] (CAD)</strong><br><br>
                                            <a href="#" data-toggle="modal" data-target="#login_modal" style="width:20%;" class="btn btn-primary btn-md">
                                                <i class="fa fa-cc-paypal"></i> Buy now
                                            </a>

                                            <button style="width:20%" ng-cloak data-ng-click="addBook([[$book->book_id]],0,ebookForm)" class="btn btn-primary btn-md" title="Add eBook to cart" data-toggle="tooltip">
                                                <i class="fa fa-cart-plus"></i> {{ ebookButton }}
                                            </button>
                                        </p>
                                        
                                        <div id="ebook_message" style="background-color: #fcf8e3;" class="remove-button" ng-if="hasEbook">
                                            This item is in your cart.
                                            <a href="" class="book-hard-remove" data-ng-click="deleteBook([[$book->book_id]],0)" data-book-id="[[$book->book_id]]" data-type-id=0>
                                                Remove
                                            </a>
                                        </div>
                                        
                                        <br>

                                        <!-- eBook Samples -->
                                        <div class="row">
                                            @if($book->epubSampleExists())
                                                <div class="col-sm-4">
                                                    <img height="100" src="[[URL::asset('images/filetypes/epub_sample.svg')]]" alt="ePUB sample version" /><br><br>
                                                    <a data-toggle='tooltip' class="btn btn-primary btn-md" title='Download ePUB sample' href="[[ URL::to('download/sample', array($book->book_id, '2')) ]]">
                                                        <i class="fa fa-download"></i> Download ePUB Sample
                                                    </a>
                                                </div>
                                            @endif

                                            @if($book->pdfSampleExists())
                                                <div class="col-sm-4">
                                                    <img height="100" src="[[URL::asset('images/filetypes/pdf_sample.svg')]]" alt="PDF sample version" /><br><br>
                                                    <a data-toggle='tooltip' class="btn btn-primary btn-md" title='Download PDF sample' href="[[ URL::to('download/sample', array($book->book_id, '3')) ]]">
                                                        <i class="fa fa-download"></i> Download PDF Sample
                                                    </a>
                                                </div>
                                            @endif

                                            @if($book->txtSampleExists())
                                                <div class="col-sm-4">
                                                    <img height="100" src="[[URL::asset('images/filetypes/txt_sample.svg')]]" alt="TXT sample version" /><br><br>
                                                    <a data-toggle='tooltip' class="btn btn-primary btn-md" title='Download TXT sample' href="[[ URL::to('download/sample', array($book->book_id, '1')) ]]">
                                                        <i class="fa fa-download"></i> Download TXT Sample
                                                    </a>
                                                </div>
                                            @endif
                                            <br><br>
                                        </div>

                                        <!-- ==============================
                                        =====   NOT LOGGED IN - END   =====
                                        =============================== -->
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

                                @if (Auth::check())
                                    <!-- ============================
                                    =====   LOGGED IN - BEGIN   =====
                                    ============================= -->
                                    @if ($book->isOwned(Auth::user()->email, 4) && $book->hasAccess(Auth::user()->email, 4))
                                        <p style="text-align:initial;">
                                            You already own this audiobook, please visit <a href="[[URL::to('user/downloadBook/'.$book->book_id)]]">this</a> page to download it!
                                        </p>
                                    @elseif ($book->isOwned(Auth::user()->email, 4) && !$book->hasAccess(Auth::user()->email, 4))
                                      <div class="form-group text-center">
                                          <p> Purchases over 60 days old cannot cannot be redownloaded, please <a href="[[ URL::to('contact') ]]">contact</a> AMPL to gain access to the book.</p>
                                      </div>
                                    @else
                                        <!-- =========================================
                                        =====   LOGGED IN BUT DOES NOT OWN MP3   =====
                                        ========================================== -->
                                        <p style="text-align:initial;">
                                            Please confirm if you would like to download the sample or purchase the complete Audiobook.
                                        </p>

                                        <p>
                                            <strong>$[[ number_format($book->audio_price, 2, '.', ',') ]] (CAD)</strong><br><br>
                                            <form action="[[ URL::to('paypal/checkout') ]]"} METHOD="POST" style="display:inline; width:100%;">
                                                <input type="hidden" name="book_id" value="[[ $book->book_id ]]">
                                                <input type="hidden" name="type_id" value="4">

                                                <button type="submit" name="payp_submit" id="pay_submit" style="width:20%;" class="btn btn-primary btn-md" title="Purchase mp3" type="image">
                                                    <i class="fa fa-cc-paypal"></i> Buy Now
                                                </button>
                                            </form>
                                            

                                            <button style="width:20%" ng-cloak data-ng-click="addBook([[$book->book_id]],4,mp3Form)" value="{{ mp3Button }}" id="mp3Button" name="mp3Button" class="btn btn-primary btn-md" title="Add MP3 to cart" data-toggle="tooltip">
                                                <i class="fa fa-cart-plus"></i> {{ mp3Button }}
                                            </button>
                                 
                                        </p>
                                        
                                        <div id="mp3_message" style="background-color: #fcf8e3;" class="remove-button" ng-if="hasMp3">
                                            This item is in your cart.
                                            <a href="" class="book-hard-remove" data-ng-click="deleteBook([[$book->book_id]],4)" data-book-id="[[$book->book_id]]" data-type-id=4>
                                                Remove
                                            </a>
                                        </div>
                                       
                                        <br>

                                        <!-- eBook Samples -->
                                        @if($book->mp3SampleExists())
                                            <img height="100" src="[[URL::asset('images/filetypes/mp3_sample.svg')]]" alt="mp3 sample version" />
                                        @endif
                                        <br><br>
                                        @if($book->mp3SampleExists())
                                            <a style="width:30%;" data-toggle='tooltip' class="btn btn-primary btn-md" title='Download MP3 sample' href="[[ URL::to('download/sample', array($book->book_id, '4')) ]]">
                                                <i class="fa fa-download"></i> Download MP3 Sample
                                            </a>
                                        @endif
                                    @endif

                                    <!-- ==========================
                                    =====   LOGGED IN - END   =====
                                    =========================== -->
                                @else
                                    <!-- ================================
                                    =====   NOT LOGGED IN - BEGIN   =====
                                    ================================= -->
                                    <p style="text-align:initial;">
                                        Please confirm if you would like to download a sample or purchase the complete audiobook.
                                    </p>

                                    <p>
                                        <strong>$[[ number_format($book->audio_price, 2, '.', ',') ]] (CAD)</strong><br><br>
                                        <a href="#" data-toggle="modal" data-target="#login_modal" style="width:20%" class="btn btn-primary btn-md">
                                            <i class="fa fa-cc-paypal"></i> Buy now
                                        </a>

                                        <button style="width:20%" ng-cloak data-ng-click="addBook([[$book->book_id]], 4, mp3Form)" class="btn btn-primary btn-md">
                                            <i class="fa fa-cart-plus"></i> {{ mp3Button }}
                                        </button>
                                    </p>
                                    
                                    <div id="mp3_message" style="background-color: #fcf8e3;" class="remove-button" ng-if="hasMp3">
                                        This item is in your cart.
                                        <a href="" class="book-hard-remove" data-ng-click="deleteBook([[$book->book_id]],4)" data-book-id="[[$book->book_id]]" data-type-id=4>
                                            Remove
                                        </a>
                                    </div>
                                    
                                    <br>

                                    @if($book->mp3SampleExists())
                                        <img height="100" src="[[URL::asset('images/filetypes/mp3_sample.svg')]]" alt="MP3 sample version" />
                                        <br><br>

                                        <a style="width:39%" data-toggle='tooltip' class="btn btn-primary btn-md" title='Download MP3 sample' href="[[ URL::to('download/sample', array($book->book_id, '4')) ]]">
                                            <i class="fa fa-download"></i> Download MP3 Sample
                                        </a>
                                    @endif

                                    <!-- ==============================
                                    =====   NOT LOGGED IN - END   =====
                                    =============================== -->
                                @endif
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
                                <br>

                                <!-- Paperback Version -->
                                <div class="row">
                                    @if ($book->in_soft)
                                        <div class="col-sm-6">
                                            <p>
                                                <strong>$[[ number_format($book->soft_price, 2, '.', ',') ]] (CAD)</strong>
                                            </p>

                                            <div>
                                                <img height="100" src="[[URL::asset('images/filetypes/paperback_order.svg')]]" alt="Buy paperback version" />
                                                <span style="display: inline-block; vertical-align: top; margin-top:5px; padding-left:5px;">
                                                    <form name="softForm" style="display:inline">
                                                        <button data-ng-click="softDown()" class="btn btn-default" >
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>

                                                        <input data-ng-model="soft_quantity" type="number" id="soft_number" style="width:50px" value="1" min="1" max="20" readonly pattern="/^[0-9]+$/" />

                                                        <button data-ng-click="softUp()" class="btn btn-default" id="softUp">
                                                            <i class="fa fa-plus-circle"></i>
                                                        </button>
                                                        <br><br>

                                                        <button ng-cloak data-ng-click="addBook([[$book->book_id]],5)" type="submit" data-book-id="[[$book->book_id]]" class="btn btn-primary btn-md" title="Add paperback to cart" data-toggle="tooltip">
                                                            <i class="fa fa-cart-plus"></i> {{ softButton}}
                                                        </button>
                                                    </form>
                                                </span>
                                            </div>
                                            <br>

                                            <div id="soft_message" style="background-color: #fcf8e3;" class="remove-button" ng-if="hasSoft">
                                                This item is in your cart.
                                                <a href="" class="book-soft-remove" data-ng-click="deleteBook([[$book->book_id]],5)" data-book-id="[[$book->book_id]]" data-type-id=5>
                                                    Remove
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Hardcover Version -->
                                    @if ($book->in_hard )
                                        <div class="col-sm-6">
                                            <p>
                                                <strong>$[[ number_format($book->hard_price, 2, '.', ',') ]] (CAD)</strong>
                                            </p>

                                            <div>
                                                <img height="100" src="[[URL::asset('images/filetypes/hardcover_order.svg')]]" alt="Buy hardcover version" />
                                                <span style="display:inline-block; vertical-align:top; margin-top:5px; padding-left:5px;">
                                                    <form name="hardForm" style="display:inline">
                                                        <button data-ng-click="hardDown()" class="btn btn-default" >
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>

                                                        <input data-ng-model="hard_quantity" type="number" id="hard_number" style="width:50px" value="1" min="1" max="20" readonly pattern="/^[0-9]+$/" />

                                                        <button data-ng-click="hardUp()" class="btn btn-default" id="hardUp" name="hardUp">
                                                            <i class="fa fa-plus-circle"></i>
                                                        </button>
                                                        <br><br>

                                                        <button ng-cloak data-ng-click="addBook([[$book->book_id]], 6, hardForm)" class="btn btn-primary btn-md"  title="Add Hardcover to cart" data-toggle="tooltip">
                                                            <i class="fa fa-cart-plus"></i> {{ hardButton}}
                                                        </button>
                                                    </form>
                                                </span>
                                                <br>
                                            </div>
                                            <br>

                                            <div id="hard_message" style="background-color: #fcf8e3;" class="remove-button" ng-if="hasHard">
                                                This item is in your cart.
                                                <a href="" class="book-hard-remove" data-ng-click="deleteBook([[$book->book_id]],6)" data-book-id="[[$book->book_id]]" data-type-id=6>
                                                    Remove
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        <br>
                        </div> <!-- end of div class="tab-content" style="text-align:center;" -->
                    </div> <!-- end of div class="col-sm-8 col-xs-12" style="margin-top:10px" -->
                @else
                    This book is unavailable for purchase.
                @endif
            </div> <!-- end of div class="col-xs-12" -->
        </div> <!-- end of div class="row" -->
    @endif
</div> <!-- end of div class="container main-content" -->
<!-- /.container -->

@stop

@section('scripts')
<script>
    var book_id="[[ $book->book_id ]]";
    
</script>

<script src='https://www.paypalobjects.com/js/external/dg.js' type='text/javascript'></script>

<script>
    var dg = new PAYPAL.apps.DGFlow({
        trigger: 'pay_submit',
        expType: 'instant'
    });
    var dg = new PAYPAL.apps.DGFlow({
        trigger: 'paypal_submit',
        expType: 'instant'
    });
</script>

<script>
//if an attempt at adding more than 20 physical copies to cart...
$("#hardUp").click(function() {
    if($("#hard_number").val() == 20)
    {      
        displayTooManyPhysicalCopies();
    }
});
$("#softUp").click(function() {
    if($("#soft_number").val() == 20)
    {      
        displayTooManyPhysicalCopies();
    }
});
$("#mp3Button").change(function() {
    alert($("#mp3Button").val());
});



$(document).ready(function () {
    
   
    
});    
    
</script>
@stop
