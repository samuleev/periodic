@extends('layouts.default')

@section('seo_headers')
    <title>Тематика</title>
@stop

@section('bread_crumbs')
    <li class="active">Тематика</li>
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