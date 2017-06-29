@extends('eng.layouts.default')

@section('seo_headers')
    <title>Publication Search</title>
    <meta name="keywords" content="Publication Search form KNAFU">
    <meta name="description" content="Publication Search form KNAFU">
@stop

@section('bread_crumbs')
    <li class="active">Publication Search</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{route('search.index')}}}" alt="Українська версія">
        <img src={{{ url('/public/img/ukr.png') }}}>
        УКР
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
                <h4>Search form</h4>
                <p>There is an opportunity to find the publication you are interested in with the help of Search Form.</p>
                <p><strong>Search Form requirements:</strong></p>
                <p>Title of the publication - full or partial title of publication.</p>
                <p>Author’s surname - full or partial author’s surname of publication.</p>
                <p>Year of publication - the year when the article was published must be in the format like "1988".</p>
                <p><i>To make a search it is necessary to fill at least one field of the form.</i></p>
            </div>
            <div class="col-md-6 well">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open(array('id' => 'searchForm', 'route' => 'eng.search.process')) !!}

                        {!! Form::label('name', 'Title of the publication', array('class'=>'control-label')) !!}
                        @if(isset($name))
                            {!! Form::text('name', $name, array('class'=>'form-control')) !!}
                        @else
                            {!! Form::text('name', null, array('class'=>'form-control')) !!}
                        @endif
                    </div>
                </div>

                <div class="row top10">
                    <div class="col-md-6">
                        {!! Form::label('author', 'Author’s surname', array('class'=>'control-label')) !!}
                        @if(isset($author))
                            {!! Form::text('author', $author, array('class'=>'form-control')) !!}
                        @else
                            {!! Form::text('author', null, array('class'=>'form-control')) !!}
                        @endif
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('year', 'Date of publication', array('class'=>'control-label')) !!}
                        @if(isset($year))
                            {!! Form::text('year', $year, array('class'=>'form-control')) !!}
                        @else
                            {!! Form::text('year', null, array('class'=>'form-control')) !!}
                        @endif
                    </div>
                </div>

                <div class="row" style="margin-top:21px;">
                    <div class="col-md-12">
                        {!! Form::submit('Search', array('class'=>'btn btn-default', 'style' => 'float: right;')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>

        @if((!empty($name) || !empty($author) || !empty($year)) && (!isset($articles) || count($articles) == 0))
            <div class="row top10">
                <div class="col-md-12 text-center" style="background: url(/public/img/icon-line.png) repeat-x;"><span style="font-size:20px;" class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
                <div class="col-md-12" style="margin:21px 0 0 0;">
                    <div class="alert alert-info" role="alert"><strong><i>No publication found for defined criteria.</i></strong></div>
                </div>
            </div>
        @endif

        @if(isset($articles))
                <div class="col-md-12 text-center" style="background: url(/public/img/icon-line.png) repeat-x; margin:21px 0;"><span style="font-size:18px;" class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></div>
            <div class="row top10">
                    <table class="table table-hover">
                        <thead>
                            <th style="text-align:center;">Title</th>
                            <th style="text-align:center;">Authors</th>
                            <th style="text-align:center;">Journal</th>
                            <th style="text-align:center;">Year / Issue</th>
                        </thead>
                        <tbody>
                        @foreach($articles as $article)
                                <tr>
                                    <td style="width:45%;"><i><a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name }}}</a></i></td>
                                    <td style="width:20%; text-align:center;"><small>@if(count($article->authors)>0) @include('article.authors') @endif</small></td>
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
