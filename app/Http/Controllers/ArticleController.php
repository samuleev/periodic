<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Dao\EditionDao;
use App\Dao\JournalDao;
use App\Service\ArticleService;

class ArticleController extends Controller {

    public function show($articleId)
    {
        $articleRow = ArticleDao::findById($articleId);
        $article = ArticleService::getEnrichedArticle($articleRow);

        $edition = EditionDao::findById($articleRow->journal_edition_id);
        $journal = JournalDao::findById($edition->journal_id);

        ArticleService::enrichFileSize($article, $journal, $edition);

        $fileName = ArticleService::getArticleFileName($journal->prefix, $edition->issue_year,
            $edition->number_in_year, $article->sort_order);

        return view('article.details')->with(array('article' => $article,
            'edition' => $edition,
            'journal' => $journal,
            'fileName' => $fileName));
    }

    public function download($articleId, $fileName) {
        $articleRow = ArticleDao::findById($articleId);
        $article = ArticleService::getEnrichedArticle($articleRow);

        $edition = EditionDao::findById($articleRow->journal_edition_id);
        $journal = JournalDao::findById($edition->journal_id);

        $original_filename = ArticleService::getFilePath($article, $journal, $edition);
        $new_filename = ArticleService::getArticleFileName($journal->prefix, $edition->issue_year,
            $edition->number_in_year, $article->sort_order);

        if($fileName != $new_filename) {
            return redirect(route('article.download', [$articleId, $new_filename]), 301);
        }

        $headers = array(
            "Content-Type: application/pdf"
        );

        return response()->download($original_filename,  $new_filename, $headers);
    }

    public function byYear($selectedYear)
    {
        $articles = ArticleDao::findContentByYear($selectedYear);
        return view('year.details')->with(array('selectedYear' => $selectedYear,
            'articles' => $articles));
    }

}