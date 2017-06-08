@extends('layouts.default')

@section('seo_headers')
    <title>Тематика</title>
@stop

@section('bread_crumbs')
    <li>@include('crumbs.journal_list')</li>
    <li>@include('crumbs.journal')</li>
    <li class="active">Тематика</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{route('eng.chapter.journal', $journal->prefix)}}}" alt="English version">
        <img src={{{ url('/public/img/eng.png') }}}>
        ENG
    </a>
@stop

@section('content')
        <div class="container">
            <br>
            @include('chapter.single')
        </div>
@stop