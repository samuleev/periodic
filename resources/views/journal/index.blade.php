@extends('layouts.default')

@section('content')
    @if(count($journals))
        <div class="container">
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
