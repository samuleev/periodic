@extends('layouts.default')

@section('seo_headers')
    <title>{{{$chapter->name}}}</title>
@stop

@section('bread_crumbs')
    <li>@include('crumbs.chapter_list')</li>
    <li class="active">{{{$chapter->name}}}</li>
@stop

@section('content')
    @if(count($articles))
        <div class="container">
            <div class="row top10">
                <div class="col-md-12">
                    <h3>{{{$chapter->name}}}</h3>
                </div>
            </div>
            <div class="row top10">
                <div class="col-md-12">
                    {!! str_replace('/?', '?', $articles->render()) !!}
                </div>
            </div>
            @foreach($articles as $articleIndex => $article)
                <div class="row top10">
                    <div class="col-md-1" style="width: 40px">
                        {{{$articleIndex + ($articles->currentPage() - 1) * $articles->perPage() + 1}}}.
                    </div>
                    <div class="col-md-6">
                        <a href="{{{route('article.details', array($article->article_id))}}}">{{{$article->name}}}</a>
                    </div>
                </div>
            @endforeach
            <div class="row top10">
                <div class="col-md-12">
                    {!! str_replace('/?', '?', $articles->render()) !!}
                </div>
            </div>
        </div>
    @else
        <p>No articles</p>
    @endif
@stop