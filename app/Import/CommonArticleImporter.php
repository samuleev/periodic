<?php

namespace App\Import;

use App\Dao\ArticleDao;
use App\Dao\TopicDao;
use Exception;
use stdClass;

class CommonArticleImporter extends BaseArticleImporter {

    private static $TOPIC_DELIMITER = '/';

    public static function import(array $lines, $editionId, $startIndex){
        $index = $startIndex;
        $topic = null;
        foreach ($lines as $line)
        {
            if(self::isTopicLine($line))
            {
                $topic = self::getTopic(trim($line));

            } else
            {
                self::importSingleArticle(trim($line), $editionId, $index, $topic);
                $index++;
            }
        }
        return $index;
    }

    private static function getTopic($line)
    {
        $topicName = substr($line, strlen(self::$TOPIC_DELIMITER));
        $topic = TopicDao::findByName($topicName);
        if(!isset($topic))
        {
            self::createTopic($topicName);
            $topic = TopicDao::findByName($topicName);
        }
        return $topic;
    }

    private static function createTopic($topicName)
    {
        $topic = new stdClass();
        $topic->name = $topicName;
        $topic->visible = 1;
        TopicDao::persist($topic);
    }

    private static function isTopicLine($line)
    {
        return substr($line, 0, strlen(self::$TOPIC_DELIMITER)) == self::$TOPIC_DELIMITER;
    }

    private static function importSingleArticle($line, $editionId, $index, $topic)
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