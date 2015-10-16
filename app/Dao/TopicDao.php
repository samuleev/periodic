<?php

namespace App\Dao;

use Exception;
use Illuminate\Support\Facades\DB;

class TopicDao implements Dao {

    static function findById($id)
    {
        $topic = DB::table('topic')->where('topic_id', $id)->get();
        return $topic[0];
    }

    static function findAll()
    {
        return DB::table('topic')->orderby('topic_id')->get();
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
}