<?php

namespace App\Import;

use App\Dao\ArticleDao;
use Exception;
use stdClass;

class CommonArticleImporter extends BaseArticleImporter {

    public static function importSingleArticle($line, $editionId, $index, $topic)
    {
        $article = self::createArticle($line, $editionId, $index, $topic);
        $articleId = ArticleDao::persist($article);
        AuthorImporter::import($line, $articleId);
    }

    private static function createArticle($line, $editionId, $index, $topic)
    {
        $articleName = self::getArticleName($line);
        if (!isset($articleName))
        {
            throw new Exception("Can not find article name in line: ".$line);
        }

        $engName = self::getArticleEngName($line);

        $pages = self::getPages($line);

        $article = new stdClass();
        $article->topic_id = $topic->topic_id;
        $article->journal_edition_id = $editionId;
        $article->start_page = $pages->start;
        $article->end_page = $pages->end;
        $article->name = $articleName;
        $article->sort_order = $index;
        $article->name_eng = $engName;
        $article->content_file = self::generateContentFileName($index);
        return $article;
    }
}