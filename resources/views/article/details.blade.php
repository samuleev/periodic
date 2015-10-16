@extends('layouts.default')

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
                    @if(count($article->getAuthors())>0)
                    {{{$article->getAuthors()[0]->getShortName()}}}
                    @endif
                    <br />
                    <b>{{{$article->getName()}}}</b>&nbsp;@if(count($article->getAuthors())>0)/&nbsp;@include('article.authors')&nbsp;@endif//
                    <a href={{{route('journal.details', $journal->journal_id)}}}>{{{ $journal->name }}}.</a>
                    - {{{$edition->issue_year}}}. - № {{{$edition->number_in_year}}}. @include('article.pages')
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    <a href={{{route('article.download', $article->getId())}}} >
                        <img src={{{ url('/data/pdf_icon.ico') }}} /> Повний текст PDF - {{{$article->getFileSize()}}}</a>
                </div>
            </div>


            <div class="row top10">
                <div class="col-md-12">
                    Цитованість авторів публікації:
                    <ul>
                    @foreach($article->getAuthors() as $author)
                        <li>{{{$author->getShortName()}}}</li>
                    @endforeach
                    </ul>
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    <small>
                    <i>Бібліографічний опис для цитування:</i><br>
                    @if(count($article->getAuthors())>0)
                    {{{$article->getAuthors()[0]->getShortName()}}}
                    @endif
                    {{{$article->getName()}}}&nbsp;@if(count($article->getAuthors())>0)/&nbsp;@include('article.authors')&nbsp;@endif//
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