<?php

namespace App\Import;


use App\Dao\TopicDao;
use App\Service\TopicService;

class TopicImporter {

    const TOPIC_DELIMITER = '/';

    static function getTopic($line)
    {
        $topicName = substr($line, strlen(self::TOPIC_DELIMITER));
        $topic = TopicDao::findByName($topicName);
        if(!isset($topic))
        {
            TopicService::createTopic($topicName);
            $topic = TopicDao::findByName($topicName);
        }
        return $topic;
    }

    static function isTopicLine($line)
    {
        return substr($line, 0, strlen(self::TOPIC_DELIMITER)) == self::TOPIC_DELIMITER;
    }
}