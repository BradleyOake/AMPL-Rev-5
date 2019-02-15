@extends('layouts.layout_main')
@section('title', 'About AMPL')
@section('metatags')
<meta name="description" content="Learn more about what AMPL Publishing is and how we started. Find out more about our AMPL Team of editors, web-designers, artists, and authors and what you need to do to become a team member." />
<meta name="keywords" content="about, team, dream, join, author, canadian, founders, talented" />
<meta name="revisit-after" content="3 month">
<meta name="author" content="AMPL Publishing" />
@stop @section('content')

<!-- main-container -->
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header">More About AMPL Publishing</h1>
    </div>
</div>

<!-- Who are we -->
<section id="about-who">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-">Who are we?</h2>
                <hr class="primary">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center bg-primary hover-box">
                <p>The AMPL team consists of editors, web-designers, artists and authors which could include you. Our intent is to amuse and divert you with a captivating assortment of fictional novels and stories that have never been published before. We represent a unique opportunity for aspiring authors and a delightful resource for readers of all ages.</p>

                <p>This is the perfect site to find new and exciting e-books and is a great place to share your own creativity if you are so inclined. The head office of AMPL Publishing is located in Bowmanville, Ontario, which is one hour east of Toronto.</p>
            </div>
        </div>
    </div>
</section>

<!-- Who are we -->
<section id="about-what">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-">What is it that AMPL does?</h2>
                <hr class="primary">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center bg-primary hover-box">
                <p>We are a paperLESS publisher providing only electronic works (e-Books) and audio books (MP3). Our content is available in the following formats: PDF, E-PUB, plain text, and MP3. Our goal is to share fresh and exhilarating stories with you, while avoiding the paper cuts.</p>

                <p>The AMPL team works tirelessly to ensure that our company maintains your satisfaction and a high standard of quality reading material at a reasonable cost. Furthermore, it is our mandate that you get enough of the story to determine your interest before you buy. Just download the sample and enjoy with our compliments.</p>

                <p>AMPL believes in dreams, and thus, we strive to open another avenue for talented, aspiring authors to share their works with the world.</p>
            </div>
        </div>
    </div>
</section>

<!-- Who are we -->
<section id="about-how">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-">How did AMPL Publishing Start?</h2>
                <hr class="primary">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center bg-primary hover-box">
                <h4>"Once Upon a Time..." </h4>
                <p>AMPL Publishing began with a dream; some would classify it as an inspiration. After several attempts to publish her stories, Meena Mason was ready to throw in the towel, so to speak. One night she dreamt of AMPL and woke up excited, not only to entertain and uplift others with her works, but to provide an additional route for hard-working, committed authors to achieve their dreams.</p>
                <p>AMPL founders and their dedicated team have worked extremely hard to bring AMPL to you. The true dream of AMPL is to entertain and create a space devoted to assisting aspiring authors, like Meena, to publish their work, in hopes that they may read or write that story and...</p>
                <h4 class="col-sm-push-10">"...live happily ever after."</h4>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center hover-box">
            <a href="[[ URL::to('contact') ]]">
                We love to hear what you think. Provide us with your feedback by clicking here.    <img class="img-responsive center-block" id="ad2" src="[[URL::asset('images/banners/Write%20that%20Wrong.gif')]]" alt="Write that wrong" />
            </a>
        </div>
    </div>
</div>
@stop
