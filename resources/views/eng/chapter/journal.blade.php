@extends('eng.layouts.default')

@section('seo_headers')
    <title>Subjects</title>
@stop

@section('bread_crumbs')
    <li>@include('eng.crumbs.journal_list')</li>
    <li>@include('eng.crumbs.journal')</li>
    <li class="active">Subjects</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{ route('chapter.journal', $journal->prefix) }}}" alt="Українська версія">
        <img src={{{ url('/public/img/ukr.png') }}}>
        УКР
    </a>
@stop

@section('content')
        <div class="container">
            <br>
            @include('eng.chapter.single')
        </div>
@stop