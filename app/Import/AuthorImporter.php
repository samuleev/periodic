<?php

namespace App\Import;

use App\Dao\AuthorDao;
use Illuminate\Support\Facades\DB;
use stdClass;

class AuthorImporter {

    public static function import($line, $articleId)
    {
        $authorNames = self::getAuthorNames($line);
        foreach($authorNames as $index => $authorName)
        {
            self::process(trim($authorName), $articleId, $index);
        }
    }

    private static function process($authorName, $articleId, $index)
    {
        $author = AuthorDao::findByName($authorName);
        if(!isset($author))
        {
            $author = self::saveAuthor($authorName);
        }

        self::linkAuthorToArticle($author, $articleId, $index);
    }

    private static function linkAuthorToArticle($author, $articleId, $index)
    {
        $articleToAuthor = new stdClass();
        $articleToAuthor->author_id = $author->author_id;
        $articleToAuthor->article_id = $articleId;
        $articleToAuthor->sort_order = $index;

        DB::table('article_to_author')->insert(get_object_vars($articleToAuthor));
    }

    private static function saveAuthor($authorName)
    {
        $author = new stdClass();
        $author->name_short = $authorName;
        AuthorDao::persist($author);
        return AuthorDao::findByName($authorName);
    }

    private static function getAuthorNames($line)
    {
        $authorSubString = trim(substr($line, 0, strpos($line, '[')));
        return explode(',',  $authorSubString);
    }

}