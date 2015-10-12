@extends('layouts.default')

@section('content')
    @if(isset($journal))
        <div class="container">

            <div class="row top10">
                <div class="col-md-6" style="width: 390px">
                    <img src={{{ url('/data/'.$journal->prefix.'/'.$journal->picture_file) }}} />
                </div>
                <div class="col-md-6">
                         <div class="row">
                            <div class="col-md-12">
                                {{{ $journal->type}}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5> {{{ $journal->name}}} </h5>
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
                    <strong>РОКИ ВИДАННЯ:</strong>
                    <br/> <br/>
                    @foreach($issueYears as $index => $issueYear)
                       <a href="{{{ route('journal.details.editions', array($journal->journal_id, $issueYear->issue_year)) }}}"><b> {{{ $issueYear->issue_year }}}</b></a> &nbsp;&nbsp;
                    @endforeach
                </div>
                <div class="col-md-6">
                    @if(isset($editions))
                    <strong>НОМЕРИ ЗА ОБРАНИЙ РІК:</strong>
                    <br/> <br/>
                    @foreach($editions as $index => $edition)
                        <a href="{{{ route('edition.details', array($edition->journal_edition_id)) }}}">
                            <b>{{{ $edition->number_in_year.'('.$edition->number.')' }}}</b></a> &nbsp;&nbsp;
                    @endforeach
                    @endif
                </div>
            </div>

            <div class="row top10">
                <div class="col-md-2">
                    Свідоцтво про державну реєстрацію:
                </div>
                <div class="col-md-10">
                    <a href={{{ url('/data/'.$journal->prefix.'/'.$journal->gov_registration_file) }}}>{{{ $journal->gov_registration}}}</a>
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
