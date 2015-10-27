@foreach($article->authors as $authorIndex => $author)
    @if(isset($author->name)){{{$author->name}}}.
    @if(isset($author->patronymic)){{{$author->patronymic}}}.@endif
    @endif
    {{{$author->surname}}}@if($authorIndex < (count($article->authors) - 1)),@endif
@endforeach