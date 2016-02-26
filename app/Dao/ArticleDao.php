<?php

namespace App\Dao;

use Exception;
use Illuminate\Support\Facades\DB;

class ArticleDao implements Dao, CustomPaging {

    static function findContentByYear($selectedYear)
    {
        return DB::table('article')
            ->select('article.article_id', 'article.name', 'journal.prefix', 'journal_edition.issue_year',
                'journal_edition.number_in_year', 'article.sort_order')
            ->join('journal_edition', 'journal_edition.journal_edition_id', '=', 'article.journal_edition_id')
            ->join('journal', 'journal.journal_id', '=', 'journal_edition.journal_id')
            ->where('journal_edition.issue_year', $selectedYear)
            ->where(function ($query) {
                $query->where('article.topic_id', '<>', 1) // skip special articles like Титул, Авторы
                    ->orWhere(DB::raw('LENGTH(article.name)'), '>', 70); // some useful articles may not have topic
            })
            ->orderby('article.name')->get();
    }

    static function findByPeriodic($prefix, $issue_year, $number_in_year, $sort_order) {
        $article = DB::table('article')
            ->select('article.article_id', 'article.topic_id', 'article.journal_edition_id',
                'article.content_file', 'article.start_page', 'article.end_page', 'article.name',
                'article.description', 'article.keywords', 'article.sort_order', 'article.name_eng',
                'article.updated', 'article.language', 'article.authors', 'article.udk')
            ->join('journal_edition', 'journal_edition.journal_edition_id', '=', 'article.journal_edition_id')
            ->join('journal', 'journal_edition.journal_id', '=', 'journal.journal_id')
            ->where('journal.prefix', $prefix)
            ->where('journal_edition.issue_year', $issue_year)
            ->where('journal_edition.number_in_year', $number_in_year)
            ->where('article.sort_order', $sort_order)
            ->get();

        if(count($article) != 1) {
            throw new Exception("Multiple articles found by unique criteria!");
        }

        return $article[0];
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