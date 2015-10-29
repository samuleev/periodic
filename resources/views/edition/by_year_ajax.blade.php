@if(isset($editions))
    <strong>НОМЕРИ ЗА {{{$selectedYear}}} РІК:</strong>
    <br/> <br/>
    @foreach($editions as $index => $edition)
        <a href="{{{route('edition.details', array($prefix, $edition->issue_year, $edition->number_in_year))}}}">
            <b>{{{ $edition->number_in_year.'('.$edition->number.')' }}}</b></a> &nbsp;&nbsp;
    @endforeach
@endif