@foreach($article->authors as $authorIndex => $author)
    {{{ $author->name_short }}}@if($authorIndex < (count($article->authors) - 1)),@endif
@endforeach