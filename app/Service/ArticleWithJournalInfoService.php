<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use App\Dao\ArticleDao;
use App\Dao\CustomPaging;

class ArticleWithJournalInfoService implements CustomPaging {

    static function find($skip, $take)
    {
        return DB::table('article')
            ->select('article.article_id', 'article.sort_order', 'article.updated', 'journal_edition.issue_year',
                'journal_edition.number_in_year', 'journal.prefix')
            ->join('journal_edition', 'journal_edition.journal_edition_id', '=', 'article.journal_edition_id')
            ->join('journal', 'journal.journal_id', '=', 'journal_edition.journal_id')
            ->orderby('article.article_id')
            ->skip($skip)->take($take)->get();
    }

    static function count()
    {
        return ArticleDao::count();
    }
}