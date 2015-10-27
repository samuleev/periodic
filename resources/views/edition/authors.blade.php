@foreach($article->authors as $authorIndex => $author)
    {{{$author->surname}}}
    @if(isset($author->name)){{{$author->name}}}.
        @if(isset($author->patronymic)){{{$author->patronymic}}}.@endif
    @endif
    @if($authorIndex < (count($article->authors) - 1)),@endif
@endforeach