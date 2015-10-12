<?php

namespace App\Service;

use App\Converter\ArticleConverter;
use App\Dao\ArticleDao;
use App\Model\Article;
use App\Model\Edition;
use Illuminate\Support\Facades\DB;
use stdClass;

class ArticleService {

    public static function getEnrichedArticle(stdClass $articleRow)
    {
        $articleRows = array();
        $articleRows[] = $articleRow;

        $articles = ArticleService::getEnrichedArticles($articleRows);

        return $articles[0];
    }

    public static function enrichFileSize(Article $article, stdClass $journal, stdClass $edition)
    {
        $path = ArticleService::getFilePath($article, $journal, $edition);

        $bytes = filesize($path);

        $article->setFileSize(ArticleService::formatSizeUnits($bytes));
    }

    public static function getFilePath(Article $article, stdClass $journal, stdClass $edition) {
        return public_path().'/data/'.$journal->prefix.'/'.$edition->number.'/'.$article->getContentFile();
    }

    private static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function getEnrichedArticles(array $articleRows)
    {
        $articleIds = ArticleService::getArticleIds($articleRows);
        $articleToAuthors = ArticleService::getArticleToAuthors($articleIds);

        $topicIds = ArticleService::getGroupedTopicsIds($articleRows);
        $topics = TopicService::getByIds($topicIds);

        $articles = array();
        foreach($articleRows as $articleRow)
        {
            $article = ArticleService::enrichArticle($articleRow, $articleToAuthors, $topics);
            $articles[] = $article;
        }
        return $articles;
    }

    private static function enrichArticle(stdClass $articleRow, array $articleToAuthors, array $topics)
    {
        $article = ArticleConverter::getObjectFromArray($articleRow);
        foreach($articleToAuthors as $key => $articleToAuthor)
        {
            if ($article->getId() == $key)
            {
                $article->setAuthors($articleToAuthor);
            }
        }

        foreach($topics as $topic) {
            if($articleRow->topic_id == $topic->topic_id)
            {
                $article->setTopic($topic);
            }
        }

        return $article;
    }

    private static function getGroupedTopicsIds(array $articleRows)
    {
        $topicIds = array();
        foreach($articleRows as $articleRow)
        {
            if (!in_array($articleRow->topic_id, $topicIds)) {
                $topicIds[] = $articleRow->topic_id;
            }
        }
        return $topicIds;
    }

    private static function getArticleToAuthors(array $articleIds)
    {
        $articleToAuthorMaps = DB::table('article_to_author')
            ->whereIn('article_id', $articleIds)->orderBy('sort_order')->get();

        $authors = AuthorService::findByArticleIds($articleIds);

        $articleIdToAuthorsArray = array();

        foreach($articleToAuthorMaps as $articleToAuthor) {

            if (!isset($articleIdToAuthorsArray[$articleToAuthor->article_id])) {
                $newAuthors = array();
                $articleIdToAuthorsArray[$articleToAuthor->article_id] = $newAuthors;
            }

            $foundAuthor = NULL;
            foreach($authors as $author) {
                if($author->getId() == $articleToAuthor->author_id)
                {
                    $foundAuthor = $author;
                }
            }

            if (!is_null($foundAuthor)) {
                $articleIdToAuthorsArray[$articleToAuthor->article_id][] = $foundAuthor;
            }

        }

        return $articleIdToAuthorsArray;
    }

    private static function getArticleIds(array $articleRows)
    {
        $articleIds = array();
        foreach ($articleRows as $articleRow) {
            $articleIds[] = $articleRow->article_id;
        }
        return $articleIds;
    }

}