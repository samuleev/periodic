

<ul class="nav nav-pills">
    <?php
    $currentLanguage = $article->language;
    ?>
    @if(empty($alternative))
        <li role="presentation" class="active"><a
                    href={{{route('article.details', array($article->article_id))}}}>@include('article.language_translate_small')</a></li>
    @else
        <li role="presentation"><a
                    href={{{route('article.details', array($article->article_id))}}}>@include('article.language_translate_small')</a></li>
    @endif
    @foreach($alternatives as $iteratedAlternative)
            <?php
            $currentLanguage = $iteratedAlternative->language;
            ?>
        @if(!empty($alternative) && $iteratedAlternative == $alternative)
            <li role="presentation" class="active"><a
                        href={{{route('alternative.details', array($article->article_id, $iteratedAlternative->language))}}}>@include('article.language_translate_small')</a>
            </li>
        @else
            <li role="presentation"><a
                        href={{{route('alternative.details', array($article->article_id, $iteratedAlternative->language))}}}>@include('article.language_translate_small')</a>
            </li>
        @endif
    @endforeach
</ul>