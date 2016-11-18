@if(isset($article->authors))
@if(count($article->authors) > 1)
@foreach($article->authors as $authorIndex => $author){{{str_replace(' ', '&nbsp;', $author)}}}@if($authorIndex < (count($article->authors) - 1)),@endif<wbr>
@endforeach
@elseif(count($article->authors) == 1)
{{{str_replace(' ', '&nbsp;', $article->authors[0])}}}
@endif
@endif