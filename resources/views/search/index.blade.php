@extends('layouts.default')

@section('seo_headers')
    <title>Пошук публікацій</title>
    <meta name="keywords" content="науковий журнал, збірник наукових праць, технічні науки, військові науки">
    <meta name="description" content="Пошук публікацій Харківського університету Повітряних Сил">
@stop

@section('bread_crumbs')
    <li class="active">Пошук публікацій</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{route('eng.search.index')}}}" alt="English version">
        <img src={{{ url('/public/img/eng.png') }}}>
        ENG
    </a>
@stop

@section('content')

    <div class="container main-content" style="padding-top:21px;">
        @if (count($errors) > 0)
            <div class="row">
                    <div class="alert alert-danger" style="font-style:italic;">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                            <br>
                        @endforeach
                    </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <h4>Форма пошуку</h4>
                <p>За допомогою форми пошуку є змога знайти публікації, що Вас зацікавили за мінімальну кількість часу.</p>
                <p><strong>Вимоги до заповнення форми пошуку:</strong></p>
                <p>Назва публікації - повне або часткове найменування публікації.</p>
                <p>Прізвище автора - повне або часткове прізвище автора публікації.</p>
                <p>Рік видання - рік коли було опубліковано у форматі "1988".</p>
                <p><i>Для здійснення пошуку необхідно заповнити хоча б одне поле форми.</i></p>
            </div>
            <div class="col-md-6 well">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open(array('id' => 'searchForm', 'route' => 'search.process')) !!}

                        {!! Form::label('name', 'Назва публікації', array('class'=>'control-label')) !!}
                        @if(isset($name))
                            {!! Form::text('name', $name, array('class'=>'form-control')) !!}
                        @else
                            {!! Form::text('name', null, array('class'=>'form-control')) !!}
                        @endif
                    </div>
                </div>

                <div class="row top10">
                    <div class="col-md-6">
                        {!! Form::label('author', 'Прізвище автора', array('class'=>'control-label')) !!}
                        @if(isset($author))
                            {!! Form::text('author', $author, array('class'=>'form-control')) !!}
                        @else
                            {!! Form::text('author', null, array('class'=>'form-control')) !!}
                        @endif
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('year', 'Рік видання', array('class'=>'control-label')) !!}
                        @if(isset($year))
                            {!! Form::text('year', $year, array('class'=>'form-control')) !!}
                        @else
                            {!! Form::text('year', null, array('class'=>'form-control')) !!}
                        @endif
                    </div>
                </div>

                <div class="row" style="margin-top:21px;">
                    <div class="col-md-12">
                        {!! Form::submit('Почати пошук', array('class'=>'btn btn-default', 'style' => 'float: right;')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>

        @if((!empty($name) || !empty($author) || !empty($year)) && (!isset($articles) || count($articles) == 0))
            <div class="row top10">
                <div class="col-md-12 text-center" style="background: {{{url('/public/img/icon-line.png')}}} repeat-x;"><span style="font-size:20px;" class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
                <div class="col-md-12" style="margin:21px 0 0 0;">
                    <div class="alert alert-info" role="alert"><strong><i>За вказаними критеріями публікаціїй не знайдено.</i></strong></div>
                </div>
            </div>
        @endif

        @if(isset($articles))
                <div class="col-md-12 text-center" style="background: {{{url('/public/img/icon-line.png')}}} repeat-x; margin:21px 0;"><span style="font-size:18px;" class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></div>
            <div class="row top10">
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
                                    <td style="width:45%;"><i><a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name }}}</a></i></td>
                                    <td style="width:20%; text-align:center;"><small>@if(count($article->authors)>0) @include('edition.authors') @endif</small></td>
                                    <td style="width:25%; text-align:center;"><small>{{{ $article->journal_name }}}</small></td>
                                    <td style="width:15%; text-align:center;"><small><strong>{{{$article->issue_year}}}</strong></small> / <small><strong>№ {{{$article->number_in_year}}}</strong></small></td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
            <div class="row top10">
                <div class="col-md-12 text-center">
                    {!! str_replace('/?', '?', $articles->render()) !!}
                </div>
            </div>
        @endif
    </div>


@stop
