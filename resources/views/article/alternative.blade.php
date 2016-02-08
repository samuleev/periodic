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
                    <div>
                        <h4>{{{$alternative->name}}}</h4>
                    </div>
                    <div>
                        {{{$alternative->authors}}}
                    </div>
                    @if(count($alternatives) > 0)
                        <div class="top5">
                            @if($alternative->language == 'ukr')
                                Анотації на мовах:
                            @elseif($alternative->language == 'rus')
                                Аннотации на языках:
                            @elseif($alternative->language == 'eng')
                                Annotations languages:
                            @endif

                            @include('article.languages')
                        </div>
                    @endif
                </div>
            </div>
            <div class="row top10">
                <div class="col-md-12">
                    @if(!empty($alternative->description))
                        <br/>
                        {{{$alternative->description}}}
                    @endif

                    @if(!empty($alternative->keywords))
                        <br/>
                        <b><i>
                                @if($alternative->language == 'ukr')
                                    Ключові слова:
                                @elseif($alternative->language == 'rus')
                                    Ключевые слова:
                                @elseif($alternative->language == 'eng')
                                    Keywords:
                                @endif
                        </i></b> {{{$alternative->keywords}}}
                    @endif
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-12">
                    <img src={{{ url('/public/img/pdf_icon.ico') }}} />
                    <a href={{{route('article.download', array($article->article_id, $fileName))}}} >
                        @if($alternative->language == 'ukr')
                            Повний текст PDF
                        @elseif($alternative->language == 'rus')
                            Полный текст PDF
                        @elseif($alternative->language == 'eng')
                            Full text PDF
                        @endif
                         - {{{$article->file_size}}}</a>
                </div>
            </div>
        </div>
    @else
        <p>No alternative</p>
    @endif
@stop