@extends('layouts.default')

@section('seo_headers')
    <title>{{{ $journal->name }}} - {{{ $journal->type }}}</title>
    <meta name="keywords" content="{{{ $journal->dak_spec}}}" >
    <meta name="description" content="{{{ $journal->subject}}}" >
@stop

@section('bread_crumps')
        <li>@include('crumps.journal_list')</li>
        <li class="active">{{{ $journal->name }}}</li>
@stop

@section('content')
    @if(isset($journal))

        <script type="text/javascript">
            function updateEditions(prefix, selectedYear) {
                $('#editions_by_year').load('' + prefix + '/' + selectedYear);
            }
        </script>

        <div class="container">

            <div class="row top10">
                <div class="col-md-6" style="width: 390px">
                    <img src={{{ url('/public/data/'.$journal->prefix.'/'.$journal->picture_file) }}} />
                </div>
                <div class="col-md-6">
                         <div class="row">
                            <div class="col-md-12">
                                {{{ $journal->type }}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5>{{{ $journal->name }}}</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                {{{ $journal->founders}}}, {{{ $journal->founded}}}.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                Виходить {{{ $journal->period}}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                ISSN {{{ $journal->issn}}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 top10">
                                Тематика: {{{ $journal->subject}}}
                            </div>
                        </div>
                 </div>
            </div>

            <div class="row top10 padding15 border">
                <div class="col-md-6" style="width: 390px">
                        <div class="row">
                            <div class="col-md-12">
                                <strong>РОКИ ВИДАННЯ:</strong>
                                <br/><br/>
                            </div>
                        </div>
                    @foreach(array_chunk($issueYears, 5) as $fiveYears)
                            <div class="row">
                                @foreach($fiveYears as $index => $issueYear)
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-link" onclick="{{{"updateEditions('".$journal->prefix."', ".$issueYear->issue_year.")"}}}"><b>{{{$issueYear->issue_year}}}</b></button> &nbsp;&nbsp;
                                    </div>
                                @endforeach
                            </div>
                    @endforeach

                    {{--@foreach($issueYears as $index => $issueYear)--}}
                       {{--<button type="button" class="btn btn-link" onclick="{{{"updateEditions('".$journal->prefix."', ".$issueYear->issue_year.")"}}}"><b>{{{ $issueYear->issue_year }}}</b></button> &nbsp;&nbsp;--}}
                    {{--@endforeach--}}
                </div>
                <div id="editions_by_year" class="col-md-6">
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-2">
                    Свідоцтво про державну реєстрацію:
                </div>
                <div class="col-md-10">
                    <a target="_blank" href={{{ url('/public/data/'.$journal->prefix.'/'.$journal->gov_registration_file) }}}>{{{ $journal->gov_registration}}}</a>
                </div>
            </div>

            <div class="row top5">
                <div class="col-md-2">
                    Реєстрація у ДАК України:
                </div>
                <div class="col-md-10">
                    {{{ $journal->dak_registration}}}
                </div>
            </div>

            <div class="row top5">
                <div class="col-md-2">
                    Спеціальність ДАК:
                </div>
                <div class="col-md-10">
                    {{{ $journal->dak_spec}}}
                </div>
            </div>

            <div class="row top5">
                <div class="col-md-2">
                    Головний редактор:
                </div>
                <div class="col-md-10">
                    {{{ $journal->chief_editor}}}
                </div>
            </div>

            <div class="row top5">
                <div class="col-md-2">
                    Відповідальні секретарі:
                </div>
                <div class="col-md-10">
                    {{{ $journal->executive_secretary}}}
                </div>
            </div>

            <div class="row top5">
                <div class="col-md-2">
                    Редакційна рада:
                </div>
                <div class="col-md-10">
                    {{{ $journal->editorial_board}}}
                </div>
            </div>
        </div>
    @else
        <p>No journal</p>
    @endif
@stop
