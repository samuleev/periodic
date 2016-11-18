<?php

namespace App\Http\Controllers;

use App\Dao\AlternativeDao;
use App\Dao\ArticleDao;
use App\Dao\JournalDao;
use App\Dao\EditionDao;
use App\Exceptions\NoElementException;
use App\Service\ArticleService;
use App\Service\EnglishService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class EditionController extends Controller {

    public function show($prefix, $selectedYear, $number)
    {
        try {
            $journal = JournalDao::findByPrefix($prefix);
            $edition = EditionDao::findByJournalIdAndYearNumber($journal->journal_id, $selectedYear, $number);
        } catch (NoElementException $e) {
            App::abort(404, 'Edition not found');
        }

        $articles = ArticleDao::findByEdition($edition->journal_edition_id);
        $articles = ArticleService::getEnrichedArticles($articles);

        return view('edition.details')->with(array(
            'edition' => $edition,
            'journal' => $journal,
            'articles' => $articles
            ));
    }

    public function showEng($prefix, $selectedYear, $number)
    {
        try {
            $journal = JournalDao::findByPrefix($prefix);
            $edition = EditionDao::findByJournalIdAndYearNumber($journal->journal_id, $selectedYear, $number);
        } catch (NoElementException $e) {
            App::abort(404, 'Edition not found');
        }

        $articles = ArticleDao::findByEdition($edition->journal_edition_id);
        $alternatives = AlternativeDao::findByEditionAndLanguage($edition->journal_edition_id, "eng");

        EnglishService::mapAlternativesToArticles($articles, $alternatives);
        EnglishService::renameCommonTitles($articles);
        $engArticles = EnglishService::removeNonEnglish($articles);
        EnglishService::mapEngArticleAuthors($engArticles);

        return view('eng.edition.details')->with(array(
            'edition' => $edition,
            'journal' => $journal,
            'articles' => $engArticles
        ));
    }

    public function raw($prefix, $selectedYear, $number)
    {
        try {
            $journal = JournalDao::findByPrefix($prefix);
            $edition = EditionDao::findByJournalIdAndYearNumber($journal->journal_id, $selectedYear, $number);
        } catch (NoElementException $e) {
            App::abort(404, 'Edition not found');
        }

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
        return self::byYearPattern($prefix, $selectedYear, 'edition.by_year_ajax');
    }

    public function byYearEng($prefix, $selectedYear)
    {
        return self::byYearPattern($prefix, $selectedYear, 'eng.edition.by_year_ajax');
    }

    private function byYearPattern($prefix, $selectedYear, $view)
    {
        $editions = EditionDao::listNumbersInYear($prefix, $selectedYear);
        return view($view)->with(array(
            'prefix' => $prefix,
            'editions' => $editions,
            'selectedYear' => $selectedYear));
    }

}