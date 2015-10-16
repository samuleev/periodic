@extends('layouts.default')

@section('content')
    @if(isset($edition))
        <div class="container">

            <div class="row top10">
                <div class="col-md-2">
                    @if(null !== $edition->getPictureFile())
                    <img src={{{ url('/data/'.$edition->getJournal()->prefix.'/'.$edition->getNumber().'/'.$edition->getPictureFile()) }}} />
                    @else
                    <img src={{{ url('/data/'.$edition->getJournal()->prefix.'/'.$edition->getJournal()->default_edition_picture) }}} />
                    @endif
                </div>
                <div class="col-md-10">
                    {{{ $edition->getJournal()->type}}}
                    <br/>
                    <h5>{{{ $edition->getJournal()->name }}}</h5>
                    <b>{{{ $edition->getIssueYear() }}} рік &nbsp; &nbsp; № {{{ $edition->getNumberInYear().'('.$edition->getNumber().')' }}} </b>
                </div>
            </div>
            <?php  $currentTopicId = null; ?>
            @foreach($edition->getArticles() as $editionIndex => $article)

                @if($article->getTopic()->topic_id != $currentTopicId)
                    <?php  $currentTopicId = $article->getTopic()->topic_id; ?>
                    @if($article->getTopic()->visible)
                    <div class="row top10">
                        <div class="col-md-12">
                            <b> {{{ $article->getTopic()->name }}} </b>
                        </div>
                    </div>
                    @endif
                @endif

                <div class="row top10">
                    <div class="col-md-12">
                        {{{ $article->getOrder() }}}.

                        @include('article.authors')

                        <a href="{{{ route('article.details', array($article->getId())) }}}">{{{ $article->getName().'.' }}}</a>

                        @include('article.pages')

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No edition</p>
    @endif
@stop