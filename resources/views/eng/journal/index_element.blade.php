<div class="conrainer">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h4 style="margin:0;">
                        <a href={{{route('eng.journal.details', $journal->prefix)}}}>
                            <span class="glyphicon glyphicon-book" aria-hidden="true" style="font-size:18px; margin-right:10px;"></span>
                            {{{ $journal->name_eng }}}
                        </a>
                    </h4>
                </div>
                <div class="col-md-3 text-right">
                    <small style="font-weight:bold; text-transform:uppercase;">{{{ $journal->type_eng }}}</small>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4 top10 bottom10">
                    <a href={{{route('eng.journal.details', $journal->prefix)}}}><img class="img-thumbnail" src={{{ url('/public/data/'.$journal->prefix.'/'.$journal->picture_file) }}} /> </a>
                </div>
                <div class="col-md-8 top10 bottom10">
                    <div class="col-md-12 ">
                        <strong>Subject area:</strong> <i>{{{ $journal->dak_spec_eng }}}</i>
                    </div>
                    @if($journal->publishing)

                    <div class="col-md-12 top10">
                        <small>The State Registration Certificate of printed mass media - <a target="_blank" href={{{ url('/public/data/'.$journal->prefix.'/'.$journal->gov_registration_file) }}}>{{{ $journal->gov_registration_eng }}}</a></small>
                    </div>
                    <div class="col-md-12 top10">
                        <div class="col-md-12 text-center" style="background: url(/public/img/icon-line.png) repeat-x;"><span style="margin-right:50px;" class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Papers to the following numbers: </strong>
                                <br><br>
                                <small>{!! $journal->materials_accept_eng !!}</small>
                                <br><br>
                                <a target="_blank" href={{{ url('/public/data/submission-guidelines.pdf') }}}>
                                    <img src={{{ url('/public/img/pdf_icon-20.png') }}} />
                                    Requirements for articles
                                </a>
                                <br>
                                <a target="_blank" href={{{ url('/public/data/review_blank_hnups.pdf') }}}>
                                    <img src={{{ url('/public/img/pdf_icon-20.png') }}} />
                                    Review blank
                                </a>
                            </div>
                            <div class="col-md-6">
                                <strong>Scientometric indicators (<i><small>in  {{{ $journal->index_update }}}</small></i>):</strong>
                                <br><br>
                                <small>«quotation» = {{{ $journal->quotation }}} <br> Hirsch index h = {{{ $journal->h_index }}} <br> index i10 = {{{ $journal->i10 }}}</small>

                                @if($journal->icv)
                                    <br><small>ICV (Index Copernicus Value) – {{{ $journal->icv }}}</small>
                                @endif

                                <br><br>
                                <a href="{{{ $journal->google_scholar }}}" target="_blank">
                                    <img src={{{ url('/public/img/google-scholar-20.jpg') }}} />
                                    Distribution «quotation» (Google Scholar)
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                            <div class="col-md-12 top10">
                                <strong>Publication is terminated</strong>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>