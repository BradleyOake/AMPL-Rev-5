@extends('layouts.layout_main')
@section('title', 'All News Comments')
@section('metatags')
@stop
@section('content')

<div class="container main-content">

@foreach($allNewsComms as $newsComments)

<div class="col-lg-12">
<h4>Name: [[ $newsComments->name ]]</h4>
<p>Comment: [[ $newsComments->text ]]</p>
<p>Comment Made On: [[ $newsComments->created_on ]]</p>
<p>Current Status of Comment: [[ $newsComments->comment_status ]]</p>
<p>Location of Comment: <a href="[[URL::to('newspage', $newsComments->news_id) ]]">[[ DB::table('news_post')->where('news_id', $newsComments->news_id)->pluck('title') ]]</a></p>
</div>
<a href="[[URL::to('admin/disableNewsComment', $newsComments->comment_id)]]" class="btn btn-primary">Disable Comment</a> 
<a href="[[URL::to('admin/enableNewsComment', $newsComments->comment_id)]]" class="btn btn-primary">Enable Comment</a>
<div class="col-sm-offset-1"><hr/></div>

@endforeach

[[$allNewsComms->links()]]
</div>

@stop