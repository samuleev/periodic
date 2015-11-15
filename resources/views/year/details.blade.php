@extends('layouts.default')

@section('seo_headers')
    <title>Перелік статей за {{{ $selectedYear }}} рік</title>
@stop

@section('bread_crumps')
@stop

@section('content')
    @if(count($selectedYear))
        <div class="container">
            @foreach($articles as $article)
            <div class="row top10">
                <div class="col-md-12">
                    <a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name }}}</a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p>No year</p>
    @endif
@stop