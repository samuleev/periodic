<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Dao\ChapterDao;
use App\Dao\JournalDao;
use App\Exceptions\NoElementException;
use Illuminate\Support\Facades\App;

class ChapterController extends Controller {

    const PAGE_SIZE = 50;

    public function index()
    {
        $chapters = ChapterDao::findAll();
        $journals = JournalDao::findAll();
        self::assignChaptersToJournals($chapters, $journals);
        return view('chapter.index')->with(array('journals' => $journals));
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
        $articles = ArticleDao::findByTopicPaginated($chapterId, self::PAGE_SIZE);
        return view('chapter.details')->with(array('chapter' => $chapter,
            'articles' => $articles));
    }
}