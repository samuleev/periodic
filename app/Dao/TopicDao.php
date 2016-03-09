<?php

namespace App\Dao;

use Exception;
use Illuminate\Support\Facades\DB;

class TopicDao implements Dao, CustomPaging {

    static function findById($id)
    {
        $topic = DB::table('topic')->where('topic_id', $id)->get();

        return DaoUtil::returnSingleElement($topic);
    }

    static function findAll()
    {
        return DB::table('topic')->orderby('topic_id')->get();
    }

    static function paginate($pageSize)
    {
        return DB::table('topic')->select('topic.topic_id', 'topic.name', DB::raw('COUNT(article.article_id) as article_count'))
            ->join('article', 'article.topic_id', '=', 'topic.topic_id')
            ->where('visible', 1)
            ->groupBy('topic.topic_id')
            ->orderByRaw("topic.name COLLATE utf8_unicode_ci ASC")
            ->paginate($pageSize);
    }

    static function countVisible()
    {
        return DB::table('topic')
        ->where('visible', 1)->count();
    }

    static function persist($topic)
    {
        self::checkTopicExists($topic->name);
        return DB::table('topic')->insertGetId(get_object_vars($topic));
    }

    private static function checkTopicExists($name)
    {
        if (count(self::findByName($name)) != 0)
        {
            throw new Exception("Topic '" .$name. "' already exists.");
        }
    }

    public static function findByName($name)
    {
        $topic = DB::table('topic')
            ->where('name', $name)
            ->orderby('topic_id')->get();
        if (count($topic) == 0)
        {
            return null;
        }
        return $topic[0];
    }

    static function find($skip, $take)
    {
        return DB::table('topic')->orderby('topic_id')->skip($skip)->take($take)->get();
    }

    static function count()
    {
        return DB::table('topic')->count();
    }
}