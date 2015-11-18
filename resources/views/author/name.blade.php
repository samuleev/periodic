<?php
    $authorName = $author->surname;
    if(isset($author->name))
    {
        $authorName = $authorName." ".$author->name.".";
        if(isset($author->patronymic))
        {
            $authorName = $authorName." ".$author->patronymic.".";
        }
    }
?>{{{$authorName}}}