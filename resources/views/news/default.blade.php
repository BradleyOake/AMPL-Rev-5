@extends('layouts.layout_main')
@section('title')
    {{ $post->title }}
@stop
@section('metatags')
    <meta name="keywords" content="news, updates, {{ $post->title }}, AMPL" />
    <meta name="description" content="" />
    <meta name="robots" content="index, follow, archive" />
    <meta name="author" content="AMPL Publishing" />
@stop
@section('pageHeader')
    <div class="col-lg-12">
        <h1 class="page-header">{{ $post->title }}</h1>
    </div>
@stop

@section('content')

   <div class="container main-content">

       <div class="row" style="margin-top:20px">
            <div class="col-xs-10 col-sm-offset-1">
                <p>
                    @if ($post->image == true)
                         <img width="200" height="200" align="{{$post->image_align}}" src="{{URL::asset('images/newsSubmission/newsid'.$post->news_id.'/image-'.$post->news_id.'.gif')}}" />
                    @endif
                    {{ $post->html }}
                </p>
            </div>
        </div>

       <hr/>

        @foreach ($post->getComments() as $comment)
    <?php


$numAgreed = DB::table('news_comment_opinion')
            ->where('comment_id', $comment->comment_id)
     ->where('agreed', 1)
            ->count();

$numDisagreed = DB::table('news_comment_opinion')
            ->where('comment_id', $comment->comment_id)
     ->where('agreed', 2)
            ->count();

       ?>
<div class="row">
    <div class="col-sm-offset-3 col-sm-6">

        <strong>
            <i class="fa fa-user fa-2x"></i>  {{ $comment->name or 'anonymous' }}
        </strong> on {{ date( 'F j, Y', strtotime($comment->created_on)) }}


        <a data-toggle="modal" data-target="#loginModal"  class="comment-icons report_news_comment" title="Report Comment" data-toggle='tooltip'><i class="fa fa-flag"></i></a>

        <div class="pull-right">
            <button type="submit" data-toggle="modal" data-target="#loginModal" class="like_news_comment btn-sm btn" title="Like" data-toggle="tooltip"><i class="fa fa-thumbs-o-up"></i> ({{ $numAgreed }})</button>
            <button type="submit" data-toggle="modal" data-target="#loginModal"  class="dislike_news_comment btn-sm btn" title="Dislike" data-toggle="tooltip"><i class="fa fa-thumbs-o-down"></i> ({{ $numDisagreed }})</button>
        </div>

        <br><br>

        {{ $comment->text }}

        <br>
        <br>
    </div>
    </div>
    <div class ="row">
        <div class="col-sm-offset-3 col-sm-6">
            <hr>
        </div>
    </div>
        @endforeach
    <hr>
    <h3 class="text-center">Leave a Comment <i class="fa fa-comment"></i></h3>

    <div class="col-sm-offset-3 col-sm-6 text-center">
        <p>
            <a href="#" data-toggle="modal" data-target="#loginModal" class="btn btn-primary"> Login</a> to leave a comment
        </p>
    </div>
</div>
@stop

@section('javascripts')
@stop
