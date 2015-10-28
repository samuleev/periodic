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
    @if(isset($article))
        <div class="container">

            <div class="row top10">
                <div class="col-md-2">
                    @if(isset($edition->picture_file))
                    <img src={{{ url('/public/data/'.$journal->prefix.'/'.$edition->number.'/'.$edition->picture_file) }}} />
                    @else
                    <img src={{{ url('/public/data/'.$journal->prefix.'/'.$journal->default_edition_picture) }}} />
                    @endif
                </div>
                <div class="col-md-10">
                    {{{ $journal->type}}}
                    <br/>
                    <h5>{{{ $journal->name }}}</h5>
                    <b>{{{ $edition->issue_year }}} рік &nbsp; &nbsp; № {{{ $edition->number_in_year.'('.$edition->number.')' }}}</b>
                    <br/><br/>
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    @if(count($article->authors)>0)
                        {{{$article->authors[0]->surname}}}
                        @if(isset($article->authors[0]->name)){{{$article->authors[0]->name}}}.
                        @if(isset($article->authors[0]->patronymic)){{{$article->authors[0]->patronymic}}}.@endif
                        @endif
                    @endif
                    <br/>
                    <b>{{{$article->name}}}</b>&nbsp;@if(count($article->authors)>0)/&nbsp;@include('article.authors')&nbsp;@endif//
                    <a href={{{route('journal.details', $journal->prefix)}}}>{{{ $journal->name }}}.</a>
                    - {{{$edition->issue_year}}}. - № {{{$edition->number_in_year}}}. @include('article.pages')
                    <br/>
                    Тематика статті: {{{$article->topic->name}}}
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    <a href={{{route('article.download', $article->article_id)}}} >
                        <img src={{{ url('/public/data/pdf_icon.ico') }}} /> Повний текст PDF - {{{$article->file_size}}}</a>
                </div>
            </div>


            <div class="row top10">
                <div class="col-md-12">
                    Цитованість авторів публікації:
                    <ul>
                    @foreach($article->authors as $author)
                            <li>
                            {{{$author->surname}}}
                            @if(isset($author->name)){{{$author->name}}}.
                            @if(isset($author->patronymic)){{{$author->patronymic}}}.@endif
                            @endif
                            </li>
                    @endforeach
                    </ul>
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    <small>
                    <i>Бібліографічний опис для цитування:</i><br>
                        @if(count($article->authors)>0)
                            {{{$article->authors[0]->surname}}}
                            @if(isset($article->authors[0]->name)){{{$article->authors[0]->name}}}.
                            @if(isset($article->authors[0]->patronymic)){{{$article->authors[0]->patronymic}}}.@endif
                            @endif
                        @endif
                    {{{$article->name}}}&nbsp;@if(count($article->authors)>0)/&nbsp;@include('article.authors')&nbsp;@endif//
                    {{{ $journal->name }}}.
                    - {{{$edition->issue_year}}}. - № {{{$edition->number_in_year}}}. @include('article.pages')
                    </small>
                </div>
            </div>

        </div>

    @else
        <p>No article</p>
    @endif
@stop