@extends('layouts.layout_main')
@section('title')
    Sample: [[ $book->title ]]
@stop
@section('description')[[ $book->m_description]] @stop
@section('keywords') [[ $book->m_keywords ]]@stop
@section('content')

<!-- Page Content -->

<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header">Sample [[ $book->title ]]</h1>
    </div>

    <div class="col-xs-4">
        @if($book->coverExists())
            <img style="height: auto; border: 2px solid #233140; margin-right: 20px;" class=" book-cover img-responsive pull-left" src="[[URL::asset( $book->coverShortPath() )]]" alt="[[ $book->title ]]">
        @else
            <img style="height: auto; border: 2px solid #233140; margin-right: 20px;" class=" book-cover img-responsive pull-left" src="[[URL::asset('images/bookcovers/no_cover.gif')]]" alt="[[ $book->title ]]">
        @endif
    </div>

    <div class="col-xs-8">
        <span style="white-space: pre-line">
            @if( $book->txtSampleExists() )
                [[file_get_contents($book->txtSamplePath()) ]]
            @else
                There is no sample available for [[ $book->title ]] at this time.
            @endif
        </span>
        <br>
        <br>
        <br>
        
        <div class="text-center">
            <a class="btn btn-md btn-primary hvr-bounce-in" data-wow-duration="0s" onclick="history.go(-1);return true;">
                <i class="fa fa-arrow-circle-left"></i> Return to previous page
            </a>
        </div>
    </div>
</div>
<br><br>
<!-- /.container -->

@stop
