@extends('layouts.default')

@section('content')
@if(isset($message))
    <div class="container">

        <div class="row top10">
            <div class="col-md-12">
                {{{$message}}}
            </div>
        </div>
        @if(isset($trace))
        <div class="row top10">
            <div class="col-md-12">
                {{{$trace}}}
            </div>
        </div>
        @endif
    </div>
@else
    <p>Error: no messages from backend</p>
@endif
@stop
