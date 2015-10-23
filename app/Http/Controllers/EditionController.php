<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Dao\JournalDao;
use App\Dao\EditionDao;
use App\Service\ArticleService;

class EditionController extends Controller {

    public function show($editionId)
    {
        $edition = EditionDao::findById($editionId);
        $journal = JournalDao::findById($edition->journal_id);
        $articles = ArticleDao::findByEdition($editionId);
        $articles = ArticleService::getEnrichedArticles($articles);

        return view('edition.details')->with(array(
            'edition' => $edition,
            'journal' => $journal,
            'articles' => $articles
            ));
    }

    public function byYear($journalId, $selectedYear)
    {
        $editions = EditionDao::listNumbersInYear($journalId, $selectedYear);
        return view('edition.by_year_ajax')->with(array('editions' => $editions, 'selectedYear' => $selectedYear));
    }

}