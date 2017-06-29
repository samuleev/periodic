@extends('layouts.default')

@section('seo_headers')
    <title>ТОП-50 публікацій ХНУПС</title>
    <meta name="keywords" content="топ, рейтинг, публікації, статті, хнупс">
    <meta name="description" content="ТОП 50 публікацій Харківського національного університету Повітряних Сил">
@stop

@section('bread_crumbs')
    <li class="active">ТОП-50 публікацій</li>
@stop

@section('content')
    <div class="container" style="padding-top:21px;">
            <div class="row">
                <div class="col-md-12">
                    <h4>ТОП-50 публікацій</h4>
                    <p><strong>Розраховується автоматично за кількістю завантажень з сайту університету</strong></p>
                    <br>
                </div>
                <div class="row top10">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <th style="text-align:center;">№</th>
                            <th style="text-align:center;">Назва публікації</th>
                            <th style="text-align:center;">Автори публікації</th>
                            <th style="text-align:center;">Назва журналу</th>
                            <th style="text-align:center;">Рік / Випуск</th>
                            </thead>
                            <tbody>
                            @for ($i = 0; $i < count($articles); $i++)
                                <?php
                                $article = $articles[$i];
                                ?>
                                <tr>
                                    <td style="width:3%;">{{{ $i + 1 }}}.</td>
                                    <td style="width:45%;"><i><a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name }}}</a></i></td>
                                    <td style="width:20%;"><small>@if(count($article->authors)>0) @include('edition.authors') @endif</small></td>
                                    <td style="width:22%;"><small>{{{ $article->journal_name }}}</small></td>
                                    <td style="width:15%;"><small><strong>{{{$article->edition_issue_year}}}</strong></small> / <small><strong>№ {{{$article->edition_number_in_year}}}</strong></small></td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
@stop