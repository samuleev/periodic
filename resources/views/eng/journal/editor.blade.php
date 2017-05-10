@extends('eng.layouts.default')

@section('seo_headers')
    <title>{{{ $journal->chief_editor_eng }}}</title>
    <meta name="keywords" content="{{{ $journal->chief_editor_eng}}}" >
    <meta name="description" content="Editor-in-Chief {{{ $journal->name_eng }}}" >
@stop

@section('bread_crumbs')
    <li>@include('eng.crumbs.journal_list')</li>
    <li>@include('eng.crumbs.journal')</li>
    <li class="active">Editor-in-Chief</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{route('journal.editor', array($journal->prefix))}}}" alt="Українська версія">
        <img src={{{ url('/public/img/ukr.png') }}}>
        УКР
    </a>
@stop

@section('content')
    @if(isset($journal))
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h3>{{{ $journal->name_eng }}}</h3>
                </div>
                <div class="col-md-3 text-right" style="padding-top:22px">
                    <small style="font-weight:bold; text-transform:uppercase;">{{{ $journal->type_eng }}}</small>
                </div>
                <div class="col-md-12" style="background:rgba(86,86,124,.2); width:100%; height:1px; margin: 0 0 21px 0;"></div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <img class="img-thumbnail" src="{{{ url('/public/data/'.$journal->prefix.'/editor.jpg') }}}">
                </div>
                <div class="col-md-9">
                    <?php include public_path() . '/data/'.$journal->prefix.'/editor-eng.html'; ?>
                </div>
            </div>
        </div>
    @else
        <p>No journal</p>
    @endif
@stop