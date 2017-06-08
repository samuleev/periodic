<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Dao\JournalDao;
use App\Dao\EditionDao;
use App\Exceptions\NoElementException;
use App\Http\Requests;
use Illuminate\Support\Facades\App;

class JournalController extends Controller
{

    public function root()
    {
        return redirect(route('journal.index'), 301);
    }

    public function index()
    {
        $journals = JournalDao::findAll();
        $articleCount = ArticleDao::countContent();
        return view('journal.index')->with(array('journals' => $journals, 'articleCount' => $articleCount->article_count));
    }

    public function indexEng()
    {
        $journals = JournalDao::findAll();
        $articleCount = ArticleDao::countContent();
        return view('eng.journal.index')->with(array('journals' => $journals, 'articleCount' => $articleCount->article_count));
    }

    public function show($prefix)
    {
        return self::showPattern($prefix, 'journal.details');
    }

    public function showEng($prefix)
    {
        return self::showPattern($prefix, 'eng.journal.details');
    }

    private function showPattern($prefix, $view)
    {
        $journal = self::getJournal($prefix);
        $issueYears = EditionDao::listYears($journal->journal_id);
        return view($view)->with(array('journal' => $journal, 'issueYears' => $issueYears));
    }

    public function editor($prefix)
    {
        $journal = self::getJournal($prefix);
        return view('journal.editor')->with(array('journal' => $journal));
    }

    public function editorEng($prefix)
    {
        $journal = self::getJournal($prefix);
        return view('eng.journal.editor')->with(array('journal' => $journal));
    }

    public static function getJournal($prefix)
    {
        try {
            return JournalDao::findByPrefix($prefix);
        } catch (NoElementException $e) {
            App::abort(404, 'Journal not found');
        }
    }

}

