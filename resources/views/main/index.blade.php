@extends('layouts.layout_main')
@section('title', 'AMPL Publishing')
@section('metatags')
<meta name="keywords" content="publisher,  welcome, text, novel, online bookstore, entertain, reader, publisher" />
<meta name="description" content="AMPL Publishing is a Canadian company, dedicated to produce and sell entertaining electronic fictional literature (e-books for e-readers). Aspiring Authors are welcome." />
<meta name="robots" content="index,follow,archive" />
<meta name="author" content="AMPL Publishing" />
@stop

@section('content')
<!-- Header Carousel -->
<header id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">

    <!-- Wrapper for slides -->
    <div class="carousel-inner" data-interval="100">
        <?php $i=1; ?>
        @foreach($books->reverse() as $book)
            @if($book->bannerExists())
                @if($i > 1)
                    <div class="item">
                @else
                    <div class="item active">
                @endif
                        <a href="[[ URL::to('bookpage', $book->book_id) ]]">
                            <img class="carousel-image" src="[[ URL::asset($book->coverBannerPath()) ]]" alt="[[ $book->title ]]">
                        </a>
                    </div>

                <?php $i++ ?>
            @endif
        @endforeach
            
        <!-- Controls, left/right -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </div>
</header>

<section id="authors" class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading"><i class="fa fa-pencil"></i> Author Services</h2>
                <hr class="primary">
            </div>
        </div>
    </div>

     <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <p> Looking to get your work published? Well, look no further! AMPL Publishing is looking forward to working with you.</p>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-money wow rollIn text-primary" data-wow-duration="1.5s"></i>
                    <h3>40% royalties</h3>
                    <p class="text-muted">Authors receive a high rate of 40% of the profit from their sold books.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-pencil-square-o wow rollIn text-primary" data-wow-delay=".5s" data-wow-duration="1.5s"></i>
                    <h3>Low-cost editing</h3>
                    <p class="text-muted">You can use this theme as is, or we can help you can make changes!</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-picture-o wow rollIn text-primary" data-wow-delay="1s" data-wow-duration="1.5s"></i>
                    <h3>Cover art services</h3>
                    <p class="text-muted">We provide amazing cover art services for those authors who require it.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-users wow rollIn text-primary" data-wow-delay="1.5s" data-wow-duration="1.5s"></i>
                    <h3>Personalized experience</h3>
                    <p class="text-muted">We customize book pages to make books stand out from each other.</p>
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <a style="margin:10px" href="[[ URL::to('aspiring') ]]" class="btn btn-primary btn-xl wow tada hvr-bounce-in" data-wow-duration="0s"><!-- wow tada hvr-bounce-in"> -->
                    <i class="fa fa-info-circle"></i> Find out More
                </a>
                
                @if(!Auth::user())
                    <span style="margin:10px">or</span>

                    <a href="#" data-toggle="modal" data-target="#register_modal" class="btn btn-primary btn-xl wow tada hvr-bounce-in" data-wow-duration="0s">
                        <i class="fa fa-plus-circle"></i> Register
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>


<section class="mid-dark">
    <div class="container text-center">
        <div class="row">
            <h2><i class="fa fa-book"></i> E-Book Readers</h2>
            <hr class="light">
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <p>AMPL offers entertaining tales in many formats: Plain Text, PDF, E-PUB, and Audio (MP3).</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 text-center">
                <div class="panel panel-default" style="height:234px">
                    <div class="service-box panel-body" style="background:white">
                        <i class="fa fa-4x fa-cart-plus wow bounceIn text-primary"></i>
                        <h3 style="color:black">Affordably priced</h3>
                        <p style="color:black">We offer all of our publishings at an affordable cost so all can enjoy!</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 text-center">
                <div class="panel panel-default">
                    <div class="service-box panel-body" style="background:white">
                        <i class="fa fa-4x fa-smile-o wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <h3 style="color:black">Family-friendly content</h3>
                        <p style="color:black">Our content is family-friendly so that everyone may enjoy our books. </p>
                    </div>
                </div>                
            </div>

            <div class="col-lg-4 col-md-6 text-center">
                <div class="panel panel-default">
                    <div class="service-box panel-body" style="background:white">
                        <i class="fa fa-4x fa-eye wow bounceIn text-primary" data-wow-delay=".2s"></i>
                        <h3 style="color:black">Free samples available</h3>
                        <p style="color:black">We provide free samples of books to prospective customers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- </div> -->

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <hr class="light">
                <a href="[[ URL::to('bookstore') ]]" class="btn btn-default btn-xl wow tada hvr-bounce-in" data-wow-duration="0s">
                    <i class="fa fa-shopping-cart"></i> Visit Our Bookstore
                </a><br/>
                <a class="wow tada hvr-bounce-in pull-right" data-wow-duration="0s" href="https://www.paypal.com/ca/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/ca/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
                    <img height="80" style="margin-top:20px"  class="img-rounded pull-right" src="https://www.paypalobjects.com/webstatic/en_CA/mktg/logo-image/AM_SbyPP_mc_vs_ae.jpg" border="0" alt="PayPal Acceptance Mark">
                </a>
            </div>
        </div>
    </div>
        <!-- </div>
    </div> -->
</section>

<!-- Contact form -->
<section id="contact">
    [!! $contact !!]
</section>

@stop

@stop 

@stop
