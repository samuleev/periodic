<?php

namespace App\Service;


use App\Converter\AuthorConverter;
use App\Dao\AuthorDao;
use Illuminate\Support\Facades\DB;

class AuthorService {

    static function findByArticleIds(array $articleIds)
    {
        $authorRows = DB::table('author')
            ->distinct()
            ->join('article_to_author', 'article_to_author.author_id', '=', 'author.author_id')
            ->whereIn('article_to_author.article_id', $articleIds)
            ->orderBy('author.name_short')
            ->get();

        $authors = array();
        foreach($authorRows as $authorRow) {
            $authors[] = AuthorConverter::getObjectFromArray($authorRow);
        }
        return $authors;
    }

    static function findById($authorId)
    {
        $authorArray = AuthorDao::findById($authorId);
        return AuthorConverter::getObjectFromArray($authorArray);
    }

}