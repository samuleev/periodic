<div class="conrainer">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h4 style="margin:0;">
                        <a href={{{route('journal.details', $journal->prefix)}}}>
                            <span class="glyphicon glyphicon-book" aria-hidden="true" style="font-size:18px; margin-right:10px;"></span>
                            {{{ $journal->name }}}
                        </a>
                    </h4>
                </div>
                <div class="col-md-3 text-right">
                    <small style="font-weight:bold; text-transform:uppercase;">{{{ $journal->type }}}</small>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4 top10 bottom10">
                    <a href={{{route('journal.details', $journal->prefix)}}}><img class="img-thumbnail" src={{{ url('/public/data/'.$journal->prefix.'/'.$journal->picture_file) }}} /> </a>
                </div>
                <div class="col-md-8 top10 bottom10">
                    <div class="col-md-12 ">
                        <strong>Галузь:</strong> <i>{{{ $journal->dak_spec }}}</i>
                    </div>
                    <div class="col-md-12 top10">
                        <small>Свідоцтво про державну реєстрацію друкованого засобу масової інформації - <a target="_blank" href={{{ url('/public/data/'.$journal->prefix.'/'.$journal->gov_registration_file) }}}>{{{ $journal->gov_registration }}}</a></small>
                    </div>
                    <div class="col-md-12 top10">
                        <div class="col-md-12 text-center" style="background: url(/public/img/icon-line.png) repeat-x;"><span style="margin-right:50px;" class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Прийом статей до наступних номерів: </strong>
                                <br><br>
                                <small>{!! $journal->materials_accept !!}</small>
                                <br><br>
                                <a target="_blank" href="/public/data/submission-guidelines.pdf">
                                    <img src={{{ url('/public/data/pdf_icon-20.png') }}} />
                                    Вимоги до оформлення статей
                                </a>
                            </div>
                            <div class="col-md-6">
                                <strong>Наукометричні показники (<i><small>на  {{{ $journal->index_update }}}</small></i>):</strong>
                                <br><br>
                                <small>«quotation» = {{{ $journal->quotation }}} <br> індекс Хірша h = {{{ $journal->h_index }}} <br> індекс i10 = {{{ $journal->i10 }}}</small>

                                @if($journal->icv)
                                    <br><small>ICV (Index Copernicus Value) – {{{ $journal->icv }}}</small>
                                @endif

                                <br><br>
                                <a href="{{{ $journal->google_scholar }}}" target="_blank">
                                    <img src={{{ url('/public/data/google-scholar-20.jpg') }}} />
                                    Розподіл «quotation» (Google Scholar)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>