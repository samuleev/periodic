<?php

namespace App\Http\Controllers;

use App\Dao\AlternativeDao;
use App\Dao\ArticleDao;
use App\Dao\EditionDao;
use App\Dao\JournalDao;
use App\Service\ArticleService;
use Exception;

class ArticleController extends Controller {

    public function show($articleId)
    {
        $articleData = self::getArticleData($articleId);
        return view('article.details')->with($articleData);
    }

    public function alternative($articleId, $language) {
        $articleData = self::getArticleData($articleId);
        $alternative = self::findAlternativeByLanguage($articleData['alternatives'], $language);
        $articleData['alternative'] = $alternative;
        return view('article.alternative')->with($articleData);
    }

    private function findAlternativeByLanguage($alternatives, $language) {
        foreach ($alternatives as $alternative) {
            if ($alternative->language == $language) {
                return $alternative;
            }
        }
        throw new Exception("Alternative not found for language: " . $language);
    }

    private function getArticleData($articleId) {
        $articleRow = ArticleDao::findById($articleId);
        $article = ArticleService::getEnrichedArticle($articleRow);

        $edition = EditionDao::findById($articleRow->journal_edition_id);
        $journal = JournalDao::findById($edition->journal_id);

        ArticleService::enrichFileSize($article, $journal, $edition);

        $fileName = ArticleService::getArticleFileName($journal->prefix, $edition->issue_year,
            $edition->number_in_year, $article->sort_order);

        $alternatives = AlternativeDao::findByArticleId($articleId);

        return array('article' => $article,
            'edition' => $edition,
            'journal' => $journal,
            'fileName' => $fileName,
            'alternatives' => $alternatives);
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