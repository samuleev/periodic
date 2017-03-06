@extends('eng.layouts.default')

@section('seo_headers')
    <title>{{{ $journal->name_eng }}} - {{{ $journal->type_eng }}}</title>
    <meta name="keywords" content="{{{ $journal->dak_spec_eng}}}" >
    <meta name="description" content="{{{ $journal->subject_eng}}}" >
@stop

@section('bread_crumbs')
        <li>@include('eng.crumbs.journal_list')</li>
        <li class="active">{{{ $journal->name_eng }}}</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{route('journal.details', array($journal->prefix))}}}" alt="Українська версія">
        <img src={{{ url('/public/img/ukr.png') }}}>
        УКР
    </a>
@stop

@section('content')
    @if(isset($journal))

        <script type="text/javascript">
            function updateEditions(prefix, selectedYear) {
                $('#editions_by_year').load('/periodic-app/journal/' + prefix + '/' + selectedYear + '/eng');
            }
        </script>

        <div class="container">

            <div class="row">
                <div class="col-md-9">
                    <h3>{{{ $journal->name_eng }}}</h3>
                </div>
                <div class="col-md-3 text-right" style="padding-top:22px">
                    <small style="font-weight:bold; text-transform:uppercase;">{{{ $journal->type_eng }}}</small>
                </div>
                <div class="col-md-12" style="background:rgba(86,86,124,.2); width:100%; height:1px; margin: 0 0 21px 0;"></div>
                <div class="col-md-6" style="width: 390px">
                    <img class="img-thumbnail" src={{{ url('/public/data/'.$journal->prefix.'/'.$journal->picture_file) }}} />
                </div>
                <div class="col-md-6">
                    <strong>Founders:</strong><br>
                    {{{ $journal->founders_eng}}}, {{{ $journal->founded}}}.
                    <br><br>
                    @if($journal->publishing)
                    <strong>Publication frequency:</strong><br>
                        Published {{{ $journal->period_eng}}}
                    <br><br>
                    <strong>ISSN:</strong>&nbsp
                    {{{ $journal->issn}}}
                        @if(isset($journal->eissn))
                            &nbsp&nbsp
                            <strong>ISSN(Online):</strong>&nbsp
                            {{{ $journal->eissn}}}
                        @endif
                    <br><br>
                    @else
                        <strong>Publication is terminated</strong>
                        <br><br>
                    @endif
                    <strong>Subject:</strong><br>
                    <i>{{{ $journal->subject_eng}}}</i>
                 </div>
            </div>

            <div class="row" style="margin-top:31px;">
                    <div class="col-md-4">
                        <table class="table table-striped">
                            <thead>
                                <th>
                                    <strong>Imprint date:</strong><br>
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
                <div id="editions_by_year" class="col-md-8">
                    <table class="table table-striped">
                        <thead>
                        <th>
                            <strong>Numbers for:</strong><br>
                        </th>
                        </thead>
                        <tr>
                            <td style="height:51px; line-height: 33px;">
                                <i><small>Please select the journal imprint date  to reflect the number of publication.</small></i>
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
                                <td style="width:33%;">
                                    <strong>Annotative systems and databases:</strong>
                                </td>
                                <td>
                                    <?php include public_path() . '/data/'.$journal->prefix.'/static-include.html'; ?>
                                </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>The State Registration Certificate:</strong>
                            </td>
                            <td>
                                <a target="_blank" href={{{ url('/public/data/'.$journal->prefix.'/'.$journal->gov_registration_file) }}}>{{{ $journal->gov_registration_eng}}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>MES of Ukraine Registration:</strong>
                            </td>
                            <td>
                                {{{ $journal->dak_registration_eng}}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>Speciality:</strong>
                            </td>
                            <td>
                                {{{ $journal->dak_spec_eng}}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>Editor-in-Chief:</strong>
                            </td>
                            <td>
                                {{{ $journal->chief_editor_eng}}}
                            </td>
                        </tr>
                        <tr>
                                <td style="width:33%;">
                                    <strong>Deputy Editor-in-Chief:</strong>
                                </td>
                                <td>
                                    {{{ $journal->deputy_editor_eng}}}
                                </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>Executive Secretary:</strong>
                            </td>
                            <td>
                                {{{ $journal->executive_secretary_eng}}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>Editorial Board:</strong>
                            </td>
                            <td>
                                <i>{!! $journal->editorial_board_eng !!}</i>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    @else
        <p>No journal</p>
    @endif
@stop
