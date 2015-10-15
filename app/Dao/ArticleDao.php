<?php

namespace App\Dao;

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

    static function persist($valueObject)
    {
        // TODO: Implement persist() method.
    }

}