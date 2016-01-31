@extends('layouts.default')

@section('seo_headers')
    <title>{{{ $alternative->name }}}</title>
    @if(isset($alternative->keywords))
        <meta name="keywords" content="{{{$alternative->keywords}}}" >
    @endif

    @if(isset($alternative->description))
        <meta name="description" content="{{{ $alternative->description}}}" >
    @endif

@stop

@section('bread_crumps')
    <li>@include('crumps.journal_list')</li>
    <li>@include('crumps.journal')</li>
    <li>@include('crumps.edition')</li>
    <li class="active">{{{$alternative->name}}}</li>
@stop

@section('content')
    @if(isset($alternative->name))
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
                    @if(count($alternatives) > 0)
                        Аннотації на мовах:
                        <ul class="nav nav-pills" role="tablist">
                            <li role="presentation"><a href={{{route('article.details', array($article->article_id))}}}>{{{$article->language}}}</a></li>
                            @foreach($alternatives as $iteratedAlternative)
                                @if($iteratedAlternative == $alternative)
                                    <li role="presentation" class="active" ><a href={{{route('alternative.details', array($article->article_id, $iteratedAlternative->language))}}}>{{{$iteratedAlternative->language}}}</a></li>
                                @else
                                    <li role="presentation"><a href={{{route('alternative.details', array($article->article_id, $iteratedAlternative->language))}}}>{{{$iteratedAlternative->language}}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="row top10">
                <div class="col-md-12">
                    <b>{{{$alternative->name}}}</b>
                    <br/>
                    {{{$alternative->authors}}}
                    <br/>

                    @if(!empty($alternative->description))
                        <br/>
                        {{{$alternative->description}}}
                    @endif

                    @if(!empty($alternative->keywords))
                        <br/>
                        <b><i>Ключові слова:</i></b> {{{$alternative->keywords}}}
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
        </div>
    @else
        <p>No alternative</p>
    @endif
@stop