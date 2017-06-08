<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Dao\ChapterDao;
use App\Dao\JournalDao;
use App\Exceptions\NoElementException;
use Illuminate\Support\Facades\App;

class ChapterController extends Controller {

    const PAGE_SIZE = 50;

    public function index() {
        return self::baseIndex('chapter.index');
    }

    public function indexEng() {
        return self::baseIndex('eng.chapter.index');
    }

    private function baseIndex($viewName) {
        $chapters = ChapterDao::findAll();
        $journals = JournalDao::findAll();
        self::assignChaptersToJournals($chapters, $journals);
        return view($viewName)->with(array('journals' => $journals));
    }

    private function assignChaptersToJournals($chapters, $journals) {
        foreach($journals as $journal) {
            foreach($chapters as $chapter) {
                if($journal->journal_id == $chapter->journal_id) {
                    $journal->chapters[] = $chapter;
                }
            }
        }
    }

    public function show($chapterId) {
        try {
            $chapter = ChapterDao::findById($chapterId);
        } catch (NoElementException $e) {
            App::abort(404, 'Topic not found');
        }
        $articles = ArticleDao::findByChapterPaginated($chapterId, self::PAGE_SIZE);
        return view('chapter.details')->with(array('chapter' => $chapter,
            'articles' => $articles));
    }

    public function byJournal($prefix) {
        return self::baseByJournal('chapter.journal', $prefix);
    }

    public function byJournalEng($prefix) {
        return self::baseByJournal('eng.chapter.journal', $prefix);
    }

    private function baseByJournal($viewName, $prefix) {
        $journal = JournalController::getJournal($prefix);
        $journals = array();
        $journals[] = $journal;

        $chapters = ChapterDao::findByJournal($journal->journal_id);

        self::assignChaptersToJournals($chapters, $journals);
        return view($viewName)->with(array('journal' => $journals[0]));
    }

}