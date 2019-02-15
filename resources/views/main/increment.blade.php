@extends('layouts.layout_main')
@section('title')
    {{ $post->title }}
@stop
@section('metatags')
@stop

@section('content')

{{DB::table('news_comment')
            ->where('comment_id', Session::get('agree'))
            ->increment('agree');
            }}
            
{{Redirect::to('newspage')}}

@stop