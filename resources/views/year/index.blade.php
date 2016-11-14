@extends('layouts.default')

@section('seo_headers')
    <title>Перелік років виданнь</title>
@stop

@section('bread_crumbs')
@stop

@section('content')
    @if(count($years))
        <div class="container">
        @foreach($years as $year)
        <div class="row top10">
            <div class="col-md-6">
                <a href="{{{ route('year.details', array($year->issue_year)) }}}">{{{$year->issue_year}}}</a>
            </div>
        </div>
        @endforeach
    </div>
@else
    <p>No years</p>
@endif
@stop