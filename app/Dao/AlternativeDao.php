<?php

namespace app\Dao;

use Exception;
use Illuminate\Support\Facades\DB;

class AlternativeDao implements Dao {

    static function findById($id)
    {
        $alternative = DB::table('alternative')->where('alternative_id', $id)->get();
        return $alternative[0];
    }

    static function findAll()
    {
        return DB::table('alternative')->orderby('alternative_id')->get();
    }

    static function persist($alternative)
    {
        self::checkAlternativeExists($alternative->article_id, $alternative->language);
        return DB::table('alternative')->insertGetId(get_object_vars($alternative));
    }

    public static function update($alternative) {
        DB::table('alternative')
            ->where('article_id', $alternative->article_id)
            ->where('language', $alternative->language)
            ->update(['name' => $alternative->name,
                'authors' => $alternative->authors,
                'description' => $alternative->description,
                'keywords' => $alternative->keywords]);
    }

    private static function checkAlternativeExists($article_id, $language)
    {
        if (count(self::findByArticleIdAndLanguage($article_id, $language)) != 0)
        {
            throw new Exception("Alternative '" .$language. "' already exists for article: '" . $article_id);
        }
    }

    public static function findByArticleIdAndLanguage($article_id, $language)
    {
        return DB::table('alternative')
            ->where('article_id', $article_id)
            ->where('language', $language)
            ->get();
    }
}