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

            <div class="row">
                <div class="col-md-9">
                    <h3>{{{ $journal->name }}}</h3>
                </div>
                <div class="col-md-3 text-right" style="padding-top:22px">
                    <small style="font-weight:bold; text-transform:uppercase;">{{{ $journal->type }}}</small>
                </div>
                <div class="col-md-12" style="background:rgba(86,86,124,.2); width:100%; height:1px; margin: 0 0 21px 0;"></div>
                <div class="col-md-6" style="width: 390px">
                    <img class="img-thumbnail" src={{{ url('/public/data/'.$journal->prefix.'/'.$journal->picture_file) }}} />
                </div>
                <div class="col-md-6">
                    <strong>Видавництво:</strong><br>
                    {{{ $journal->founders}}}, {{{ $journal->founded}}}.
                    <br><br>
                    @if($journal->publishing)
                    <strong>Періодичність видання:</strong><br>
                    Виходить {{{ $journal->period}}}
                    <br><br>
                    <strong>ISSN:</strong><br>
                    {{{ $journal->issn}}}
                    <br><br>
                    @else
                        <strong>Видання припинено</strong>
                        <br><br>
                    @endif
                    <strong>Тематика:</strong><br>
                    <i>{{{ $journal->subject}}}</i>
                 </div>
            </div>

            <div class="row" style="margin-top:31px;">
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <thead>
                                <th>
                                    <strong>Роки видання:</strong><br>
                                </th>
                            </thead>
                            <tr>
                                <td>
                                    @foreach(array_chunk($issueYears, 5) as $fiveYears)
                                        @foreach($fiveYears as $index => $issueYear)
                                            <button type="button" class="btn btn-link" onclick="{{{"updateEditions('".$journal->prefix."', ".$issueYear->issue_year.")"}}}"><b>{{{$issueYear->issue_year}}}</b></button>
                                        @endforeach
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </div>
                {{--@foreach($issueYears as $index => $issueYear)--}}
                   {{--<button type="button" class="btn btn-link" onclick="{{{"updateEditions('".$journal->prefix."', ".$issueYear->issue_year.")"}}}"><b>{{{ $issueYear->issue_year }}}</b></button> &nbsp;&nbsp;--}}
                {{--@endforeach--}}
                <div id="editions_by_year" class="col-md-6">
                    <table class="table table-striped">
                        <thead>
                        <th>
                            <strong>Номери за ... рік:</strong><br>
                        </th>
                        </thead>
                        <tr>
                            <td style="height:51px; line-height: 33px;">
                                <i><small>Будь ласка оберіть рік видання журналу для відображення номеру публікації.</small></i>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row" style="margin-top:21px;">
                <div class="col-md-12">
                    <table class="table">
                        @if($journal->publishing)
                        <tr>
                            <td style="width:30%;">
                                <strong>Свідоцтво про державну реєстрацію:</strong>
                            </td>
                            <td>
                                <a target="_blank" href={{{ url('/public/data/'.$journal->prefix.'/'.$journal->gov_registration_file) }}}>{{{ $journal->gov_registration}}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%;">
                                <strong>Реєстрація у ДАК України:</strong>
                            </td>
                            <td>
                                {{{ $journal->dak_registration}}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%;">
                                <strong>Спеціальність ДАК:</strong>
                            </td>
                            <td>
                                {{{ $journal->dak_spec}}}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td style="width:30%;">
                                <strong>Головний редактор:</strong>
                            </td>
                            <td>
                                {{{ $journal->chief_editor}}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%;">
                                <strong>Відповідальні секретарі:</strong>
                            </td>
                            <td>
                                {{{ $journal->executive_secretary}}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%;">
                                <strong>Редакційна рада:</strong>
                            </td>
                            <td>
                                <i>{{{ $journal->editorial_board}}}</i>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @else
        <p>No journal</p>
    @endif
@stop
