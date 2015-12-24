@if(isset($editions))
    <table class="table table-striped">
        <thead>
        <th>
            <strong>Номери за {{{$selectedYear}}} рік:</strong><br>
        </th>
        </thead>
        <tr>
            <td style="height:51px;">
                @foreach($editions as $index => $edition)
                    <a href="{{{route('edition.details', array($prefix, $edition->issue_year, $edition->number_in_year))}}}" style="line-height: 33px;">
                        <b>{{{ $edition->number_in_year.'('.$edition->number.')' }}}</b></a> &nbsp;&nbsp;
                @endforeach
            </td>
        </tr>
    </table>
@endif