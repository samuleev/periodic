@extends('layouts.default')

@section('seo_headers')
    <title>ТОП-50 авторів ХНУПС</title>
    <meta name="keywords" content="топ, рейтинг, автори, статті, хнупс">
    <meta name="description" content="ТОП 50 авторів Харківського національного університету Повітряних Сил">
@stop

@section('bread_crumbs')
    <li class="active">ТОП-50 авторів</li>
@stop

@section('content')
    <div class="container" style="padding-top:21px;">
        @if(count($authors) == 0)
            <div class="row">
                <div class="col-md-12">
                    <h4>В базі даних немає авторів</h4>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <h4>ТОП-50 авторів</h4>
                    <p><strong>Розраховується автоматично за кількістю публікацій авторів у наукових виданнях ХНУПС починаючи з 1999 року</strong></p>
                </div>
            </div>
            <div class="row" style="padding-top:21px;">
                <div class="col-md-4">
                    <table class="table table-hover">
                        <thead>
                        <th style="text-align:left;">Автор</th>
                        <th style="text-align:left;">Кількість публікацій</th>
                        <tbody>

                        @for ($i = 0; $i < count($authors) / 2; $i++)
                            <tr>
                                <?php
                                $author = $authors[$i];
                                ?>
                                <td style="width:20%;">{{{$i + 1}}}.
                                    <a href="{{{route('author.details', array($author->author_id))}}}">@include('author.name')</a>
                                </td>
                                <td style="width:1%;"> {{{$authors[$i]->number}}}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>

                <div class="col-md-4">
                    <table class="table table-hover">
                        <thead>
                        <th style="text-align:left;">Автор</th>
                        <th style="text-align:left;">Кількість публікацій</th>
                        <tbody>

                        @for ($i = 0; $i < count($authors) / 2; $i++)
                            <tr>
                                <?php
                                $author = $authors[(count($authors) / 2) + $i];
                                ?>

                                <td style="width:20%;">{{{(count($authors) / 2) + $i + 1}}}.
                                    <a href="{{{route('author.details', array($author->author_id))}}}">@include('author.name')</a></td>
                                <td style="width:1%;">{{{$author->number}}}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@stop