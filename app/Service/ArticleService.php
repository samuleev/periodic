<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use stdClass;

class ArticleService {

    public static function getEnrichedArticle(stdClass $article)
    {
        $articles = array();
        $articles[] = $article;

        $articles = self::getEnrichedArticles($articles);

        return $articles[0];
    }

    public static function enrichFileSize(stdClass $article, stdClass $journal, stdClass $edition)
    {
        $path = self::getFilePath($article, $journal, $edition);

        $bytes = filesize($path);

        $article->file_size = self::formatSizeUnits($bytes);
    }

    public static function getFilePath(stdClass $article, stdClass $journal, stdClass $edition) {
        return public_path().'/data/'.$journal->prefix.'/'.$edition->number.'/'.$article->content_file;
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

    public static function getEnrichedArticles(array $articles)
    {
        $articleIds = self::getArticleIds($articles);
        $articleToAuthors = self::getArticleToAuthors($articleIds);

        $topicIds = self::getGroupedTopicsIds($articles);
        $topics = TopicService::getByIds($topicIds);

        $enrichedArticles = array();
        foreach($articles as $article)
        {
            $enrichedArticle = self::enrichArticle($article, $articleToAuthors, $topics);
            $enrichedArticles[] = $enrichedArticle;
        }
        return $enrichedArticles;
    }

    private static function enrichArticle(stdClass $article, array $articleToAuthors, array $topics)
    {
        $article->authors = array();
        foreach($articleToAuthors as $key => $articleToAuthor)
        {
            if ($article->article_id == $key)
            {
                $article->authors = $articleToAuthor;
            }
        }

        $article->topic = null;
        foreach($topics as $topic) {
            if($article->topic_id == $topic->topic_id)
            {
                $article->topic = $topic;
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
                if($author->author_id == $articleToAuthor->author_id)
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

    public static function getArticleFileName($prefix, $issue_year, $number_in_year, $sort_order)
    {
        return $prefix . '_' . $issue_year . '_'  . $number_in_year . '_' . $sort_order . '.pdf';
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