@extends('layouts.default')

@section('seo_headers')
    <title>{{{ $article->name }}}</title>
    @if(isset($article->keywords))
        <meta name="keywords" content="{{{$article->keywords}}}" >
    @endif

    @if(isset($article->description))
        <meta name="description" content="{{{ $article->description}}}" >
    @endif

    <meta name="citation_journal_title" content="{{{$journal->name}}}" />
    <meta name="citation_publisher" content="{{{$journal->founders}}}" />
    <meta name="citation_issn" content="{{{$journal->issn}}}" />
    <meta name="citation_publication_date" content="{{{$edition->issue_year}}}" />
    <meta name="citation_issue" content="{{{$edition->number_in_year}}}" />
    @if( $article->start_page > 0 )
        <meta name="citation_firstpage" content="{{{$article->start_page}}}" />
        @if( $article->end_page > 0 )
            <meta name="citation_lastpage" content="{{{$article->end_page}}}" />
        @endif
    @endif
    <meta name="citation_title" content="{{{$article->name}}}" />
    @foreach($article->authors as $author)
        <?php
        $authorNameWithComa = $author->surname;
            if(isset($author->name))
            {
                $authorNameWithComa = $authorNameWithComa.", ".$author->name.".";
                if(isset($author->patronymic))
                {
                    $authorNameWithComa = $authorNameWithComa." ".$author->patronymic.".";
                }
            }
        ?>
        <meta name="citation_author" content="{{{$authorNameWithComa}}}" />
    @endforeach
    <meta name="citation_abstract_html_url" content="{{{route('article.details', array($article->article_id))}}}" />
    <meta name="citation_pdf_url" content="{{{route('article.download', array($article->article_id, $fileName))}}}" />
@stop

@section('bread_crumps')
        <li>@include('crumps.journal_list')</li>
        <li>@include('crumps.journal')</li>
        <li>@include('crumps.edition')</li>
        <li class="active">{{{$article->name}}}</li>
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
                    <?php
                    $firstAuthor = null;
                    if(count($article->authors)>0)
                    {
                        $firstAuthor = $article->authors[0]->surname;
                        if(isset($article->authors[0]->name))
                        {
                            $firstAuthor = $firstAuthor." ".$article->authors[0]->name.".";
                            if(isset($article->authors[0]->patronymic))
                            {
                                $firstAuthor = $firstAuthor." ".$article->authors[0]->patronymic.".";
                            }
                        }
                    }
                    ?>
                    {{{$firstAuthor}}}
                    <br/>
                    <b>{{{$article->name}}}</b>&nbsp;@if(count($article->authors)>0)/&nbsp;@include('article.authors')&nbsp;@endif//
                    <a href={{{route('journal.details', $journal->prefix)}}}>{{{ $journal->name }}}.</a>
                    - {{{$edition->issue_year}}}. - № {{{$edition->number_in_year}}}. @include('article.pages')
                    <br/>
                    @if($article->topic->name != 'special')
                        Тематика статті: {{{$article->topic->name}}}
                    @endif
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    <a href={{{route('article.download', array($article->article_id, $fileName))}}} >
                        <img src={{{ url('/public/data/pdf_icon.ico') }}} /> Повний текст PDF - {{{$article->file_size}}}</a>
                </div>
            </div>

            @if(count($article->authors) > 0)
            <div class="row top10">
                <div class="col-md-12">
                    Інформація про авторів публікації:
                    <ul>
                    @foreach($article->authors as $author)
                            <li><a href="{{{route('author.details', array($author->author_id))}}}">{{{$author->surname}}} @if(isset($author->name)){{{$author->name}}}. @if(isset($author->patronymic)){{{$author->patronymic}}}.@endif @endif</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="row top10">
                <div class="col-md-12">
                    <small>
                    <i>Бібліографічний опис для цитування:</i><br>
                    {{{$firstAuthor}}}
                    {{{$article->name}}}&nbsp;@if(count($article->authors)>0)/&nbsp;@include('article.authors')&nbsp;@endif// {{{ $journal->name }}}. - {{{$edition->issue_year}}}. - № {{{$edition->number_in_year}}}. @include('article.pages')
                    </small>
                </div>
            </div>

        </div>

    @else
        <p>No article</p>
    @endif
@stop