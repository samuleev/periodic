@extends('layouts.default')

@section('bread_crumps')
    @include('crumps.journal_list')
@stop

@section('content')
    @if(count($journals))
        <div class="container main-content">
            @foreach($journals as $index =>  $journal)
                @if($index % 2 == 0)
                    <div class="row top10">
                        <div class="col-md-6">
                            @include('journal.index_element')
                        </div>
                    @if($index == (count($journals) - 1))
                    </div> {{-- row --}}
                    @endif
                @else
                        <div class="col-md-6">
                            @include('journal.index_element')
                        </div>
                    </div> {{-- row --}}
                @endif
            @endforeach
        </div> {{-- container --}}
    @else
        <p>No journals</p>
    @endif
@stop
