<?php use App\Author; ?>
@extends('layouts.layout_main')
@section('title', 'AMPL About Author')
@section('metatags')
@section('content')

<div class="container main-content">
    <div class="col-lg-12">
        <h1 class="page-header">More About [[ $name ]]</h1>
    </div>

    <div class="col-xs-3 text-center">
        @if($user->coverExists())
            <img style="border: 2px solid #233140; margin-right: 20px; height:auto;" class=" book-cover img-responsive pull-left" src="[[URL::asset($user->coverShortPath())]]">
        @else
            <img style="border: 2px solid #233140; margin-right: 20px; height:auto;" class=" book-cover img-responsive pull-left" src="[[URL::asset('images/bookcovers/no_cover.gif')]]">
        @endif
        <br><br><br>
    </div>

    <span style="white-space: pre-line">
        @if($user->bioExists())
            [!! file_get_contents($user->bioPath()) !!]
        @else
            There is no description available for [[ $name ]] at this time.
        @endif
    </span>
    <br><br>

    <div class="col-sm-12 text-center">
        <hr>
        <h2>Published Works with AMPL</h2>
        <ul>
            @foreach($books as $book)
                <li style="list-style-position:inside;"> <a href="[[ URL::to('bookpage', $book->book_id) ]]">[[ $book->title ]]</a></li>
            @endforeach
        </ul>
        <br>
        <br>
        <br>

        <hr>
        <a class="btn btn-md btn-primary hvr-bounce-in" data-wow-duration="0s" onclick="history.go(-1);return true;">
            <i class="fa fa-arrow-circle-left"></i> Return to previous page
        </a>
    </div>
</div>
@stop
