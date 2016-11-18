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

@section('bread_crumbs')
        <li>@include('crumbs.journal_list')</li>
        <li>@include('crumbs.journal')</li>
        <li>@include('crumbs.edition')</li>
        <li class="active">{{{$article->name}}}</li>
@stop

@section('lang_switch')
    @foreach($alternatives as $iteratedAlternative)
        @if($iteratedAlternative->language == 'eng')
            <a style="color:#FFFFFF;text-decoration: none;" href="{{{ route('alternative.details', array($article->article_id, 'eng')) }}}" alt="English version">
                <img src={{{ url('/public/img/eng.png') }}}>
                ENG
            </a>
        @endif
    @endforeach
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
                    <div>
                        <h4>{{{$article->name}}}</h4>
                    </div>
                    @if(count($article->authors)>0)
                        <div>
                            @include('article.authors')
                        </div>
                    @endif
                    <div class="top5">
                        <a href={{{route('journal.details', $journal->prefix)}}}>{{{ $journal->name }}}.</a>
                        — {{{$edition->issue_year}}}. — № {{{$edition->number_in_year.'('.$edition->number.')'}}}. @include('article.pages_prefix')
                    </div>
                    @if($article->topic->name != 'special')
                        <div class="top5">
                            <b><i>Тематика статті:</i></b> <a href="{{{route('topic.details', array($article->topic->topic_id))}}}">{{{$article->topic->name}}}</a>
                        </div>
                    @endif
                    @if(!empty($article->udk))
                        <div class="top5">
                            <b><i>УДК</i></b> {{{$article->udk}}}
                        </div>
                    @endif
                    @if(!empty($article->language))
                        <div class="top5">
                            <b><i>Мова статті:</i></b>
                            @if($article->language == 'ukr')
                                українська
                            @elseif($article->language == 'rus')
                                російська
                            @elseif($article->language == 'eng')
                                англійська
                            @endif
                        </div>
                    @endif
                    @if(count($alternatives) > 0)
                        <div class="top5">
                            Анотації на мовах:
                            @include('article.languages')
                        </div>
                    @endif
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    <?php
                    $firstAuthor = null;
                    $firstAuthorSurname = null;
                    if(count($article->authors)>0)
                    {
                        $firstAuthor = $article->authors[0]->surname;
                        $firstAuthorSurname = $article->authors[0]->surname;
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

                    @if(!empty($article->description))
                        <br/>
                        {{{$article->description}}}
                    @endif

                    @if(!empty($article->keywords))
                        <br/>
                        <b><i>Ключові слова:</i></b> {{{$article->keywords}}}
                    @endif


                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    <img src={{{ url('/public/img/pdf_icon.ico') }}} />
                    <a href={{{route('article.download', array($article->article_id, $fileName))}}} >
                        Повний текст PDF - {{{$article->file_size}}}</a>
                </div>
            </div>

            @if($article->topic->name != 'special')
                <?php
                    $searchName = "";
                    $words = explode(" ", $article->name);
                    $delimiter = "";
                    for ($i = 0; $i < min(3, count($words)); $i++)
                    {
                        if ($i > 0) {
                            $delimiter = "+";
                        }

                        $searchName = $searchName . $delimiter . $words[$i];
                    }
                ?>
                <div class="row top10">
                    <div class="col-md-12">
                        <img src={{{ url('/public/img/google-scholar.jpg') }}} />
                        <a target="_blank" href={{{"http://scholar.google.com.ua/scholar?as_q=site%3Airbis-nbuv.gov.ua&as_epq=" . $searchName . "&as_sauthors=" . $firstAuthorSurname . "&hl=uk"}}}>
                            Цитування публікації </a>
                    </div>
                </div>
            @endif

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
                    {{{$article->name}}}&nbsp;@if(count($article->authors)>0)/&nbsp;@include('article.authors')&nbsp;@endif// {{{ $journal->name }}}. — {{{$edition->issue_year}}}. — № {{{$edition->number_in_year}}}. @include('article.pages_prefix')
                    </small>
                </div>
            </div>

        </div>

    @else
        <p>No article</p>
    @endif
@stop