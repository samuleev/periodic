@extends('layouts.default')

@section('seo_headers')
    <title>@include('author.name')</title>
    @if(isset($article->keywords))
        <meta name="keywords" content="@include('author.name')" >
    @endif

    @if(isset($article->description))
        <meta name="description" content="Інформація про автора @include('author.name')" >
    @endif
@stop

@section('bread_crumbs')
    <li>@include('crumbs.author_list')</li>
    <li class="active">@include('author.name')</li>
@stop

@section('content')
    @if(isset($author))
        <div class="container">
            <?php
            $authorSearchName = "";
            if(isset($author->name))
            {
                $authorSearchName = $author->name;
                if(isset($author->patronymic))
                {
                    $authorSearchName = $authorSearchName.$author->patronymic;
                }
            }
            $authorSearchName = $authorSearchName . "%20" . $author->surname;
            ?>

            <div class="row top10">
                <div class="col-md-12">
                    <h4>@include('author.name')</h4>
                </div>
            </div>
            <div class="row top10">
                <div class="col-md-12">
                    <img src={{{ url('/public/img/google-scholar.jpg') }}} />
                    <a target="_blank" href={{{"http://scholar.google.com.ua/scholar?as_q=site%3Airbis-nbuv.gov.ua&as_sauthors=" . $authorSearchName . "&hl=uk&btnG=&as_sdt=0%2C5"}}}>
                        Цитованість автора</a>
                </div>
            </div>
            <div class="row top10">
                <div class="col-md-12">
                    <b>Публікації автора</b>
                </div>
            </div>
                <div class="row top10">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <th style="text-align:center;">Назва публікації</th>
                            <th style="text-align:center;">Автори публікації</th>
                            <th style="text-align:center;">Назва журналу</th>
                            <th style="text-align:center;">Рік / Випуск</th>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td style="width:45%;"><i><a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name.'.' }}}</a></i></td>
                                    <td style="width:20%;"><small>@if(count($article->authors)>0) @include('article.authors') @endif</small></td>
                                    <td style="width:25%;"><small>{{{ $article->journal_name }}}</small></td>
                                    <td style="width:15%;"><small><strong>{{{$article->edition_issue_year}}}</strong></small> / <small><strong>№ {{{$article->edition_number_in_year}}}</strong></small></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            {{--@foreach($articles as $index => $article)--}}
            {{--<div class="row top10">--}}
                {{--<div class="col-md-1" style="width: 20px">--}}
                    {{--{{{ $index + 1 }}}.--}}
                {{--</div>--}}
                {{--<div class="col-md-7">--}}
                    {{--<a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name.'.' }}}</a>--}}
                    {{--/&nbsp;@include('edition.authors')--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@endforeach--}}
       </div>

    @else
        <p>No author</p>
    @endif
@stop