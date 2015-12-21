@extends('layouts.default')

@section('seo_headers')
    <title>Пошук публікацій</title>
    <meta name="keywords" content="науковий журнал, збірник наукових праць, технічні науки, військові науки">
    <meta name="description" content="Пошук публікацій Харківського університету Повітряних Сил">
@stop

@section('bread_crumps')
    <li class="active">Пошук публікацій</li>
@stop

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container main-content">
        <div class="row">
            <div class="col-md-6">
                <h3>Пошук публікацій</h3>
            </div>
        </div>
        <div class="row top10">
            <div class="col-md-6 well">
                {!! Form::open(array('id' => 'searchForm', 'route' => 'search.process')) !!}

                {!! Form::label('name', 'Назва публікації', array('class'=>'control-label')) !!}
                @if(isset($name))
                    {!! Form::text('name', $name, array('class'=>'form-control')) !!}
                @else
                    {!! Form::text('name', null, array('class'=>'form-control')) !!}
                @endif

                <br />
                {!! Form::label('author', 'Прізвище автора', array('class'=>'control-label')) !!}
                @if(isset($author))
                    {!! Form::text('author', $author, array('class'=>'form-control')) !!}
                @else
                    {!! Form::text('author', null, array('class'=>'form-control')) !!}
                @endif

                <br />
                {!! Form::label('year', 'Рік видання', array('class'=>'control-label')) !!}
                @if(isset($year))
                    {!! Form::text('year', $year, array('class'=>'form-control')) !!}
                @else
                    {!! Form::text('year', null, array('class'=>'form-control')) !!}
                @endif
                <br />

                {!! Form::submit('Пошук', array('class'=>'btn btn-default', 'style' => 'float: right;')) !!}

                {!! Form::close() !!}
            </div>
        </div>

        @if((!empty($name) || !empty($author) || !empty($year)) && (!isset($articles) || count($articles) == 0))
            <div class="row top10">
                <div class="col-md-12">
                    <h4>За вказаними критеріями публікаціїй не знайдено.</h4>
                </div>
            </div>
        @endif

        @if(isset($articles))
            @foreach($articles as $article)
                <div class="row top10">
                    <div class="col-md-12">
                        <a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name.'.' }}}</a>
                        &nbsp;@if(count($article->authors)>0)/&nbsp;@include('article.authors')&nbsp;@endif// {{{ $article->journal_name }}}. - {{{$article->issue_year}}}. - № {{{$article->number_in_year}}}.
                    </div>
                </div>
            @endforeach
            <div class="row top10">
                <div class="col-md-12">
                    {!! str_replace('/?', '?', $articles->render()) !!}
                </div>
            </div>
        @endif
    </div>


@stop
