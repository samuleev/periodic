<?php

namespace App\Import;

use App\Dao\AuthorDao;
use Exception;
use Illuminate\Support\Facades\DB;
use stdClass;

class AuthorImporter {

    public static function import($line, $articleId)
    {
        $authorStrings = self::getAuthorNames($line);
        foreach($authorStrings as $index => $authorString)
        {
            $parsedAuthor = self::getParsedAuthor(trim($authorString));
            self::process($parsedAuthor, $articleId, $index);
        }
    }

    private static function getParsedAuthor($authorString)
    {
        $parsedAuthor = new stdClass();
        if (substr_count($authorString, '.') < 1)
        {
            $parsedAuthor->surname = trim($authorString);
            return $parsedAuthor;
        }

        $authorArray = explode(' ', $authorString);

        if(count($authorArray) < 3)
        {
            throw new Exception("Error parsing author(3 parts not found): ".$authorString);
        }

        $parsedAuthor->surname = trim($authorArray[0]);
        if(substr_count($parsedAuthor->surname, '.') > 0)
        {
            throw new Exception("Error parsing author(surname must not contain point): ".$authorString);
        }

        $parsedAuthor->name = trim(trim($authorArray[1], '.'));
        if(mb_strlen($parsedAuthor->name) != 1)
        {
            throw new Exception("Error parsing author(name must contain 1 character): ".$authorString);
        }

        $parsedAuthor->patronymic = trim(trim($authorArray[2], '.'));
        if(mb_strlen($parsedAuthor->patronymic) != 1)
        {
            throw new Exception("Error parsing author(patronymic must contain 1 character): ".$authorString);
        }

        return $parsedAuthor;
    }

    private static function process($parsedAuthor, $articleId, $index)
    {
        if(empty($parsedAuthor->surname)) {
            throw new Exception("Empty author surname");
        }

        $author = AuthorDao::findByFullName($parsedAuthor);
        if(!isset($author))
        {
            $author = self::saveAuthor($parsedAuthor);
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

    private static function saveAuthor($author)
    {
        $authorId = AuthorDao::persist($author);
        return AuthorDao::findById($authorId);
    }

    private static function getAuthorNames($line)
    {
        $authorSubString = trim(substr($line, 0, strpos($line, '[')));
        return explode(',',  $authorSubString);
    }

}