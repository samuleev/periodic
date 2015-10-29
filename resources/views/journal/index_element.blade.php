<div class="conrainer padding15 border" style="width: 450px">
<div class="row">
    <div class="col-md-12 pl-text">
        {{{ $journal->type }}}
    </div>
</div>

<div class="row">
    <div class="col-md-12 ">
        <h4>{{{ $journal->name }}}</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-12 top10 bottom10">
       <a href={{{route('journal.details', $journal->prefix)}}}> <img src={{{ url('/public/data/'.$journal->prefix.'/'.$journal->picture_file) }}} /> </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12 ">
        галузь - {{{ $journal->dak_spec }}}
    </div>
</div>

<div class="row">
    <div class="col-md-12 ">
        Свідоцтво про державну реєстрацію друкованого засобу масової інформації - {{{ $journal->gov_registration }}}
    </div>
</div>

<div class="row">
    <div class="col-md-12 top10">
        <p><strong>Прийом статей до наступних номерів: </strong><p/>
        {!! $journal->materials_accept !!}
    </div>
</div>

<div class="row">
    <div class="col-md-12 ">
        <strong>Наукометричні показники журналу (на  {{{ $journal->index_update }}} ):</strong>
        <br/>
        «quotation» = {{{ $journal->quotation }}} / індекс Хірша h = {{{ $journal->h_index }}} / індекс i10 = {{{ $journal->i10 }}}
        @if($journal->icv)
        <br/>ICV (Index Copernicus Value) – {{{ $journal->icv }}}
        @endif

    </div>
</div>

<div class="row">
    <div class="col-md-12 top10">
        <a href="{{{ $journal->google_scholar }}}">Розподіл «quotation» (Google Scholar)</a>
    </div>
</div>

</div>