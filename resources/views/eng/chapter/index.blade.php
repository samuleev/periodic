@extends('eng.layouts.default')

@section('seo_headers')
    <title>Subjects</title>
@stop

@section('bread_crumbs')
    <li class="active">Subjects</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{ route('chapter.index') }}}" alt="Українська версія">
        <img src={{{ url('/public/img/ukr.png') }}}>
        УКР
    </a>
@stop

@section('content')
    @if(count($journals))
        <div class="container">
        <br>
        @foreach($journals as $journalIndex => $journal)
            @if($journal->publishing)
                @include('eng.chapter.single')
            @endif
        @endforeach
        </div>
    @else
        <p>No topics</p>
    @endif
@stop