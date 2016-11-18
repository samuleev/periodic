@extends('eng.layouts.default')

@section('seo_headers')
    <title>{{{ $journal->name_eng }}} - {{{ $journal->type_eng }}}</title>
    <meta name="keywords" content="{{{ $journal->dak_spec_eng}}}" >
    <meta name="description" content="{{{ $journal->subject_eng}}}" >
@stop

@section('bread_crumbs')
        <li>@include('eng.crumbs.journal_list')</li>
        <li>@include('eng.crumbs.journal')</li>
        <li class="active">{{{$edition->number_in_year."(".$edition->number.")'".$edition->issue_year}}}</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{route('edition.details', array($journal->prefix, $edition->issue_year, $edition->number_in_year))}}}" alt="Українська версія">
        <img src={{{ url('/public/img/ukr.png') }}}>
        УКР
    </a>
@stop

@section('content')
    @if(isset($edition))
        <div class="container">
            <div class="row" style="margin-top:21px;">
                <div class="col-md-2">
                    @if(null !== $edition->picture_file)
                    <img  class="img-thumbnail" src={{{ url('/public/data/'.$journal->prefix.'/'.$edition->number.'/'.$edition->picture_file) }}} />
                    @else
                    <img  class="img-thumbnail" src={{{ url('/public/data/'.$journal->prefix.'/'.$journal->default_edition_picture) }}} />
                    @endif
                </div>
                <div class="col-md-10">
                        <div class="col-md-8">
                            <h4>{{{ $journal->name_eng }}}</h4>
                        </div>
                        <div class="col-md-4 text-right" style="line-height:40px;">
                            <small style="font-weight:bold; text-transform:uppercase;">{{{ $journal->type_eng }}}</small>
                        </div>
                    <div class="col-md-12" style="background:rgba(86,86,124,.2); width:100%; height:1px; margin: 0 0 21px 0;"></div>
                    <div class="col-md-12">
                        <p><strong>Year of publication:</strong><br>{{{ $edition->issue_year }}}</p>
                        <p><strong>Issue:</strong><br>{{{ $edition->number_in_year.'('.$edition->number.')' }}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center" style="margin:21px 0; background: url(/public/img/icon-line.png) repeat-x;"><span class="glyphicon glyphicon-book" style="font-size:18px;" aria-hidden="true"></span></div>
            <?php  $currentTopicId = null; ?>

            <table class="table table-hover">
                <thead>
                <th style="text-align:center;">#</th>
                <th style="text-align:center;">Title</th>
                <th style="text-align:center;">Authors</th>
                <th style="text-align:center;">Pages</th>
                </thead>
                <tbody>
                <?php  $orderNumber = 0; ?>
                @foreach($articles as $article)
                    <?php  $orderNumber++; ?>
                    <tr>
                        <td style="width:5%;">{{{ $orderNumber }}}.</td>
                        <td style="width:50%;">
                            @if(isset($article->alternative))
                                <a href="{{{ route('alternative.details', array($article->article_id, 'eng')) }}}">
                                    @if (empty($article->name_eng))
                                        {{{ $article->alternative->name }}}
                                    @else
                                        {{{ $article->name_eng }}}
                                    @endif
                                </a>
                            @else
                                <a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name }}}</a>
                            @endif
                        </td>
                        <td style="width:27%;">@include('eng.edition.authors')</td>
                        <td style="width:7%;">@include('article.pages')</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No edition</p>
    @endif
@stop