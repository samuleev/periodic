<?php

namespace App\Dao;

use Exception;
use Illuminate\Support\Facades\DB;

class AlternativeDao implements Dao, CustomPaging {

    static function findById($id)
    {
        $alternative = DB::table('alternative')->where('alternative_id', $id)->get();
        return DaoUtil::returnSingleElement($alternative);
    }

    static function find($skip, $take)
    {
        return DB::table('alternative')->orderby('alternative_id')->skip($skip)->take($take)->get();
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

    static function findByEditionAndLanguage($journal_edition_id, $language) {
        return DB::table('alternative')->select('alternative.alternative_id', 'alternative.article_id',
            'alternative.name', 'alternative.authors', 'alternative.description', 'alternative.keywords',
            'alternative.updated', 'alternative.language')
            ->join('article', 'article.article_id', '=', 'alternative.article_id')
            ->where('article.journal_edition_id', $journal_edition_id)
            ->where('alternative.language', $language)->get();
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

    public static function findByArticleId($article_id)
    {
        return DB::table('alternative')
            ->where('article_id', $article_id)
            ->get();
    }

    static function count()
    {
        return DB::table('alternative')->count();
    }
}