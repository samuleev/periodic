<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Dao\JournalDao;
use App\Dao\EditionDao;
use App\Service\ArticleService;
use Illuminate\Support\Facades\Response;

class EditionController extends Controller {

    public function show($prefix, $selectedYear, $number)
    {
        $journal = JournalDao::findByPrefix($prefix);
        $edition = EditionDao::findByJournalIdAndYearNumber($journal->journal_id, $selectedYear, $number);
        $articles = ArticleDao::findByEdition($edition->journal_edition_id);
        $articles = ArticleService::getEnrichedArticles($articles);

        return view('edition.details')->with(array(
            'edition' => $edition,
            'journal' => $journal,
            'articles' => $articles
            ));
    }

    public function raw($prefix, $selectedYear, $number)
    {
        $journal = JournalDao::findByPrefix($prefix);
        $edition = EditionDao::findByJournalIdAndYearNumber($journal->journal_id, $selectedYear, $number);
        $articles = ArticleDao::findByEdition($edition->journal_edition_id);

        foreach($articles as $article)
        {
            $fileName = ArticleService::getArticleFileName($prefix, $selectedYear,
                $number, $article->sort_order);

            $article->fileName = $fileName;
        }

        return Response::view('edition.raw', compact('articles'))
            ->header('Content-Type', 'text/plain');
    }

    public function byYear($prefix, $selectedYear)
    {
        $editions = EditionDao::listNumbersInYear($prefix, $selectedYear);
        return view('edition.by_year_ajax')->with(array(
            'prefix' => $prefix,
            'editions' => $editions,
            'selectedYear' => $selectedYear));
    }

}