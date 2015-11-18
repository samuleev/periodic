@extends('layouts.default')

@section('seo_headers')
    <title>@include('author.name')</title>
    @if(isset($article->keywords))
        <meta name="keywords" content="@include('author.name')" >
    @endif

    @if(isset($article->description))
        <meta name="description" content="Інформація про автора @include('author.name')" >
    @endif
@stop

@section('bread_crumps')
    <li>@include('crumps.author_list')</li>
    <li class="active">@include('author.name')</li>
@stop

@section('content')
    @if(isset($author))
        <div class="container">

            <div class="row top10">
                <div class="col-md-12">
                    <h4>@include('author.name')</h4>
                </div>
            </div>
            <div class="row top10">
                <div class="col-md-12">
                    <b>Публікації автора</b>
                </div>
            </div>
            @foreach($articles as $index => $article)
            <div class="row top10">
                <div class="col-md-1" style="width: 20px">
                    {{{ $index + 1 }}}.
                </div>
                <div class="col-md-7">
                    <a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name.'.' }}}</a>
                    /&nbsp;@include('edition.authors')
                </div>
            </div>
            @endforeach
       </div>

    @else
        <p>No author</p>
    @endif
@stop