@extends('layouts.default')

@section('bread_crumps')
    @include('crumps.journal_list')
    &gt;
    @include('crumps.journal')
    &gt;
    @include('crumps.edition')
@stop

@section('content')
    @if(isset($edition))
        <div class="container">

            <div class="row top10">
                <div class="col-md-2">
                    @if(null !== $edition->picture_file)
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
                    <div class="col-md-12">
                        {{{ $article->sort_order }}}.

                        @include('article.authors')

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