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
                <div class="col-md-6">
                    <h3>Тематики</h3>
                </div>
                <div class="col-md-6">
                    {!! str_replace('/?', '?', $topics->render()) !!}
                </div>
            </div>
            <div class="row top10">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Тематика</th>
                            <th>Кількість публікацій</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topics as $topicIndex => $topic)
                            <tr>
                                <td>
                                    {{{$topicIndex + ($topics->currentPage() - 1) * $topics->perPage() + 1 }}}.
                                </td>
                                <td>
                                    <a href="{{{route('topic.details', array($topic->topic_id))}}}">{{{$topic->name}}}</a>
                                </td>
                                <td>
                                    {{{$topic->article_count}}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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