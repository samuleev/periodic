@extends('layouts.default')

@section('seo_headers')
    <title>Тематики</title>
@stop

@section('bread_crumps')
    <li class="active">Тематики</li>
@stop

@section('content')
    @if(count($topics))
        <div class="container">
            <div class="row top10">
                <div class="col-md-12">
                    <h3>Тематики</h3>
                </div>
            </div>
            <div class="row top10">
                <div class="col-md-12">
                    {!! str_replace('/?', '?', $topics->render()) !!}
                </div>
            </div>
            @foreach($topics as $topicIndex => $topic)
                <div class="row top10">
                    <div class="col-md-1" style="width: 30px">
                        {{{$topicIndex + ($topics->currentPage() - 1) * $topics->perPage() + 1 }}}.
                    </div>
                    <div class="col-md-6">
                        <a href="{{{route('topic.details', array($topic->topic_id))}}}">{{{$topic->name}}}</a>
                    </div>
                    <div class="col-md-2">
                        {{{$topic->article_count}}}
                    </div>
                </div>
            @endforeach

            <div class="row top10">
                <div class="col-md-12">
                    {!! str_replace('/?', '?', $topics->render()) !!}
                </div>
            </div>
        </div>
    @else
        <p>No topics</p>
    @endif
@stop