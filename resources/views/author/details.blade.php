@extends('layouts.default')

@section('seo_headers')
    <title>{{{ $article->name }}}</title>
    @if(isset($article->keywords))
        <meta name="keywords" content="{{{$article->keywords}}}" >
    @endif

    @if(isset($article->description))
        <meta name="description" content="{{{ $journal->description}}}" >
    @endif
@stop

@section('bread_crumps')
    @include('crumps.journal_list')
    &#10095;
    @include('crumps.journal')
    &#10095;
    @include('crumps.edition')
    &#10095;
    @include('crumps.article')
@stop

@section('content')
    @if(isset($author))
        <div class="container">

            <div class="row top10">
                <div class="col-md-2">

                </div>
                <div class="col-md-10">
                </div>
            </div>
       </div>

    @else
        <p>No author</p>
    @endif
@stop