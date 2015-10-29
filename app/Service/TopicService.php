<?php

namespace App\Service;

use App\Dao\TopicDao;
use Illuminate\Support\Facades\DB;
use stdClass;

class TopicService {

    static function getByIds(array $topicIds)
    {
        return DB::table('topic')
            ->whereIn('topic_id', $topicIds)->get();
    }

    static function getDefaultTopic()
    {
        $topic = TopicDao::findByName('special');
        if (!isset($topic)) {
            throw new Exception("'special' topic not found!");
        }
        return $topic;
    }

    static function createTopic($topicName)
    {
        $topic = new stdClass();
        $topic->name = $topicName;
        $topic->visible = 1;
        TopicDao::persist($topic);
    }
}