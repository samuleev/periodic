@extends('layouts.default')

@section('seo_headers')
    <title>{{{ $journal->name }}} - {{{ $journal->type }}}</title>
    <meta name="keywords" content="{{{ $journal->dak_spec}}}" >
    <meta name="description" content="{{{ $journal->subject}}}" >
@stop

@section('bread_crumbs')
        <li>@include('crumbs.journal_list')</li>
        <li class="active">{{{ $journal->name }}}</li>
@stop

@section('lang_switch')
    <a style="color:#FFFFFF;text-decoration: none;" href="{{{route('eng.journal.details', array($journal->prefix))}}}" alt="English version">
        <img src={{{ url('/public/img/eng.png') }}}>
        ENG
    </a>
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
                    <strong>Періодичність видання:</strong>
                    Виходить {{{ $journal->period}}}
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
                        <strong>Видання припинено</strong>
                        <br><br>
                    @endif
                    <strong>Тематика:</strong>
                    <i>{{{ $journal->subject}}}&nbsp;(<a href={{{route('chapter.journal', $journal->prefix)}}}>перелік тематик</a>);</i>

                    <br><br>

                    <a target="_blank" href={{{ url('/public/data/submission-guidelines.pdf') }}}>
                        <img src={{{ url('/public/img/pdf_icon.ico') }}} />
                        Вимоги до оформлення статей
                    </a>

                 </div>
            </div>

            <div class="row" style="margin-top:31px;">
                    <div class="col-md-4">
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
                <div id="editions_by_year" class="col-md-8">
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
                                <td style="width:33%;">
                                    <strong>Анотаційні системи та бази даних:</strong>
                                </td>
                                <td>
                                    <?php include public_path() . '/data/'.$journal->prefix.'/static-include.html'; ?>
                                </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>Свідоцтво про державну реєстрацію:</strong>
                            </td>
                            <td>
                                <a target="_blank" href={{{ url('/public/data/'.$journal->prefix.'/'.$journal->gov_registration_file) }}}>{{{ $journal->gov_registration}}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>Реєстрація у МОН України:</strong>
                            </td>
                            <td>
                                {{{ $journal->dak_registration}}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>Галузь науки:</strong>
                            </td>
                            <td>
                                {{{ $journal->dak_spec}}}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td style="width:33%;">
                                <strong>Головний редактор:</strong>
                            </td>
                            <td>
                                <a href="{{{route('journal.editor', array($journal->prefix))}}}">{{{ $journal->chief_editor}}}</a>
                            </td>
                        </tr>
                            <tr>
                                <td style="width:33%;">
                                    <strong>Заступник головного редактора:</strong>
                                </td>
                                <td>
                                    <a href="{{{route('journal.deputy-editor', array($journal->prefix))}}}">{{{ $journal->deputy_editor}}}</a>
                                </td>
                            </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>Відповідальний секретар:</strong>
                            </td>
                            <td>
                                {{{ $journal->executive_secretary}}}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>Редакційна колегія:</strong>
                            </td>
                            <td>
                                <i>{!! $journal->editorial_board !!}</i>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <strong>Зовнішні рецензенти:</strong>
                            </td>
                            <td>
                                <i>{!! $journal->external_reviewers !!}</i>
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
