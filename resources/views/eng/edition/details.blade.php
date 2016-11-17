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
                        <div class="col-md-9">
                            <h4>{{{ $journal->name_eng }}}</h4>
                        </div>
                        <div class="col-md-3 text-right" style="line-height:40px;">
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
                <th style="text-align:center;">Article title</th>
                <th style="text-align:center;">Authors</th>
                <th style="text-align:center;">Pages</th>
                </thead>
                <tbody>
                @foreach($articles as $article)
                    @if($article->topic_id != $currentTopicId)
                        <?php  $currentTopicId = $article->topic_id; ?>
                        @if($article->topic->visible)
                            <tr>
                            <td colspan="4" style="width:100%; text-align:center;"><b><i> {{{ $article->topic->name }}} </i></b></td>
                            </tr>
                        @endif
                    @endif
                    <tr>
                        <td style="width:5%;">{{{ $article->sort_order }}}.</td>
                        <td style="width:55%;"><a href="{{{ route('article.details', array($article->article_id)) }}}">{{{ $article->name }}}</a>
                        </td>
                        <td style="width:30%;">@include('edition.authors')</td>
                        <td style="width:5%;">@include('article.pages')</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No edition</p>
    @endif
@stop