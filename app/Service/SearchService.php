<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;

class SearchService {

    public static function searchArticles($name, $author, $year, $pageSize)
    {
        $baseQuery = DB::table('article')
            ->select('article.article_id', 'article.name', 'article.topic_id', 'journal_edition.issue_year',
                'journal_edition.number_in_year', 'journal.name as journal_name')
            ->distinct()
            ->join('journal_edition', 'journal_edition.journal_edition_id', '=', 'article.journal_edition_id')
            ->join('journal', 'journal.journal_id', '=', 'journal_edition.journal_id');

        if(!empty($author)) {
            $baseQuery = $baseQuery->join('article_to_author', 'article_to_author.article_id', '=', 'article.article_id')
                ->join('author', 'article_to_author.author_id', '=', 'author.author_id')
                ->where('author.surname', 'like', "%" . $author . "%");
        }

        if(!empty($name)) {
            $baseQuery = $baseQuery->where('article.name', 'like', "%" . $name . "%");
        }

        if(!empty($year)) {
            $baseQuery = $baseQuery->where('journal_edition.issue_year', '=', $year);
        }

        $baseQuery = $baseQuery->orderby('journal_edition.issue_year', 'desc')
            ->orderby('journal.sort_order', 'desc')
            ->orderby('journal_edition.number_in_year', 'desc');

        $articlesPaginator = $baseQuery->paginate($pageSize);

        return self::enreachPaginator($articlesPaginator);

    }

    private static function enreachPaginator($articlesPaginator) {
        if( isset($articlesPaginator) && count($articlesPaginator->items()) > 0 ){
            $articlesPaginator->items(ArticleService::getEnrichedArticles($articlesPaginator->items()));
            return $articlesPaginator;
        }
        return null;
    }

}