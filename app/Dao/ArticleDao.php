<?php

namespace App\Dao;

use Exception;
use Illuminate\Support\Facades\DB;

class ArticleDao implements Dao {

    static function findByEdition($editionId)
    {
        return DB::table('article')->where('journal_edition_id', $editionId)->orderby('sort_order')->get();
    }

    static function findById($id)
    {
        $article = DB::table('article')->where('article_id', $id)->get();
        return $article[0];
    }

    static function findAll()
    {
        return DB::table('article')->orderby('article_id')->get();
    }

    static function persist($article)
    {
        self::checkArticleExists($article->journal_edition_id, $article->name);
        return DB::table('article')->insertGetId(get_object_vars($article));
    }

    private static function checkArticleExists($editionId, $name)
    {
        if (count(self::findByEditionAndName($editionId, $name)) != 0)
        {
            throw new Exception("Article '" .$name. "' already exists in edition: '" .$editionId);
        }
    }

    private static function findByEditionAndName($editionId, $name)
    {
        return DB::table('article')
            ->where('journal_edition_id', $editionId)
            ->where('name', $name)
            ->orderby('sort_order')->get();
    }
}