<div class="container">

    @if(count($sub_authors) == 0)
        <div class="row top10">
            <div class="col-md-12">
                <h3>В базі даних немає авторів, прізвище яких починається з літери '{{{$letter}}}'</h3>
            </div>
        </div>
    @else

    @foreach($sub_authors  as $sub => $authors)
        <div class="row top10">
            <div class="col-md-12">
                <b>{{{$sub}}}</b>
            </div>
        </div>

        @foreach(array_chunk($authors, $column_count) as $fourAuthors)
            <div class="row">
                @foreach($fourAuthors as $author)
                    <div class="col-md-{{{12/$column_count}}}">
                        <a href="{{{route('author.details', array($author->author_id))}}}">@include('author.name')</a>
                    </div>
                @endforeach
            </div>
        @endforeach

    @endforeach

    @endif

</div>