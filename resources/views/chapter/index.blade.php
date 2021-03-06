@extends('layouts.default')

@section('seo_headers')
    <title>Тематика</title>
@stop

@section('bread_crumbs')
    <li class="active">Тематика</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{route('eng.chapter.index')}}}" alt="English version">
        <img src={{{ url('/public/img/eng.png') }}}>
        ENG
    </a>
@stop

@section('content')
    @if(count($journals))
        <div class="container">
        <br>
        @foreach($journals as $journalIndex => $journal)
            @if($journal->publishing)
                @include('chapter.single')
            @endif
        @endforeach
        </div>
    @else
        <p>No topics</p>
    @endif
@stop