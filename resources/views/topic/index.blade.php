@extends('layouts.default')

@section('seo_headers')
    <title>Тематики</title>
@stop

@section('bread_crumbs')
    <li class="active">Тематики</li>
@stop

@section('content')
    @if(count($topics))
        <div class="container">

            <div class="col-md-12 text-center" style="margin-top:21px; background: {{{url('/public/img/icon-line.png')}}} repeat-x;"><span style="font-size:18px;" class="glyphicon glyphicon-tags" aria-hidden="true"></span></div>

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
                <div class="col-md-12 text-center">
                    {!! str_replace('/?', '?', $topics->render()) !!}
                </div>
            </div>
        </div>
    @else
        <p>No topics</p>
    @endif
@stop