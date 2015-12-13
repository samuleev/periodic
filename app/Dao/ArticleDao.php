<?php

namespace App\Dao;

use Exception;
use Illuminate\Support\Facades\DB;

class ArticleDao implements Dao, CustomPaging {

    static function findContentByYear($selectedYear)
    {
        return DB::table('article')
            ->join('journal_edition', 'journal_edition.journal_edition_id', '=', 'article.journal_edition_id')
            ->where('journal_edition.issue_year', $selectedYear)
            ->where(function ($query) {
                $query->where('article.topic_id', '<>', 1) // skip special articles like Титул, Авторы
                    ->orWhere(DB::raw('LENGTH(name)'), '>', 70); // some useful articles may not have topic
            })
            ->orderby('article.name')->get();
    }

    static function findByEdition($editionId)
    {
        return DB::table('article')->where('journal_edition_id', $editionId)->orderby('sort_order')->get();
    }

    static function findByTopicPaginated($topicId, $pageSize)
    {
        return DB::table('article')->where('topic_id', $topicId)
            ->orderByRaw("name COLLATE utf8_unicode_ci ASC")->paginate($pageSize);
    }

    static function findByAuthor($authorId)
    {
        return DB::table('article')
            ->join('article_to_author', 'article_to_author.article_id', '=', 'article.article_id')
            ->where('article_to_author.author_id', $authorId)
            ->orderByRaw("name COLLATE utf8_unicode_ci ASC")->get();
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

    static function find($skip, $take)
    {
        return DB::table('article')->orderby('article_id')->skip($skip)->take($take)->get();
    }

    static function count()
    {
        return DB::table('article')->count();
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