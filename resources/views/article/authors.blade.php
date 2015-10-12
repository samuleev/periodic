@foreach($article->getAuthors() as $authorIndex => $author)
    {{{ $author->getShortName() }}}@if($authorIndex < (count($article->getAuthors()) - 1)),@endif
@endforeach