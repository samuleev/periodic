@extends('layouts.default')

@section('bread_crumps')
    @include('crumps.journal_list')
    &gt;
    @include('crumps.journal')
    &gt;
    @include('crumps.edition')
    &gt;
    @include('crumps.article')
@stop

@section('content')
    @if(isset($article))


        <div class="container">

            <div class="row top10">
                <div class="col-md-2">
                    @if(isset($edition->picture_file))
                    <img src={{{ url('/data/'.$journal->prefix.'/'.$edition->number.'/'.$edition->picture_file) }}} />
                    @else
                    <img src={{{ url('/data/'.$journal->prefix.'/'.$journal->default_edition_picture) }}} />
                    @endif
                </div>
                <div class="col-md-10">
                    {{{ $journal->type}}}
                    <br/>
                    <h5>{{{ $journal->name }}}</h5>
                    <b>{{{ $edition->issue_year }}} рік &nbsp; &nbsp; № {{{ $edition->number_in_year.'('.$edition->number.')' }}} </b>
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    @if(count($article->authors)>0)
                    {{{$article->authors[0]->name_short}}}
                    @endif
                    <br />
                    <b>{{{$article->name}}}</b>&nbsp;@if(count($article->authors)>0)/&nbsp;@include('article.authors')&nbsp;@endif//
                    <a href={{{route('journal.details', $journal->journal_id)}}}>{{{ $journal->name }}}.</a>
                    - {{{$edition->issue_year}}}. - № {{{$edition->number_in_year}}}. @include('article.pages')
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    <a href={{{route('article.download', $article->article_id)}}} >
                        <img src={{{ url('/data/pdf_icon.ico') }}} /> Повний текст PDF - {{{$article->file_size}}}</a>
                </div>
            </div>


            <div class="row top10">
                <div class="col-md-12">
                    Цитованість авторів публікації:
                    <ul>
                    @foreach($article->authors as $author)
                        <li>{{{$author->name_short}}}</li>
                    @endforeach
                    </ul>
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    <small>
                    <i>Бібліографічний опис для цитування:</i><br>
                    @if(count($article->authors)>0)
                    {{{$article->authors[0]->name_short}}}
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