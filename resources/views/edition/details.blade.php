@extends('layouts.default')

@section('seo_headers')
    <title>{{{ $journal->name }}} - {{{ $journal->type }}}</title>
    <meta name="keywords" content="{{{ $journal->dak_spec}}}" >
    <meta name="description" content="{{{ $journal->subject}}}" >
@stop

@section('bread_crumps')
        <li>@include('crumps.journal_list')</li>
        <li>@include('crumps.journal')</li>
        <li class="active">{{{$edition->number_in_year."(".$edition->number.")'".$edition->issue_year}}}</li>
@stop

@section('content')
    @if(isset($edition))
        <div class="container">

            <div class="row top10">
                <div class="col-md-2">
                    @if(null !== $edition->picture_file)
                    <img src={{{ url('/public/data/'.$journal->prefix.'/'.$edition->number.'/'.$edition->picture_file) }}} />
                    @else
                    <img src={{{ url('/public/data/'.$journal->prefix.'/'.$journal->default_edition_picture) }}} />
                    @endif
                </div>
                <div class="col-md-10">
                    {{{ $journal->type}}}
                    <br/>
                    <h5>{{{ $journal->name }}}</h5>
                    <b>{{{ $edition->issue_year }}} рік &nbsp; &nbsp; № {{{ $edition->number_in_year.'('.$edition->number.')' }}} </b>
                </div>
            </div>
            <?php  $currentTopicId = null; ?>
            @foreach($articles as $editionIndex => $article)

                @if($article->topic_id != $currentTopicId)
                    <?php  $currentTopicId = $article->topic_id; ?>
                    @if($article->topic->visible)
                    <div class="row top10">
                        <div class="col-md-12">
                            <b> {{{ $article->topic->name }}} </b>
                        </div>
                    </div>
                    @endif
                @endif

                <div class="row top10">
                    <div class="col-md-1" style="width: 20px">
                        {{{ $article->sort_order }}}.
                    </div>
                    <div class="col-md-7">
                        @include('edition.authors')

                        <a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name.'.' }}}</a>

                        @include('article.pages')
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No edition</p>
    @endif
@stop