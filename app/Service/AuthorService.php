<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;

class AuthorService {

    static function findByArticleIds(array $articleIds)
    {
        return DB::table('author')
            ->distinct()
            ->join('article_to_author', 'article_to_author.author_id', '=', 'author.author_id')
            ->whereIn('article_to_author.article_id', $articleIds)
            ->orderBy('author.surname')
            ->get();
    }
}