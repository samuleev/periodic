<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Service\ArticleService;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller {

    public function article()
    {
        $articles = ArticleDao::findAll();
        $last_mod_date = date('c',time());
        return Response::view('sitemap.article', compact('articles', 'last_mod_date'))
            ->header('Content-Type', 'application/xml');
    }

    public function pdf()
    {
        $articleInfos = ArticleService::getArticlesAdditionalJournalInfo();
        foreach($articleInfos as $articleInfo)
        {
            $fileName = ArticleService::getArticleFileName($articleInfo->prefix, $articleInfo->issue_year,
                $articleInfo->number_in_year, $articleInfo->sort_order);

            $articleInfo->fileName = $fileName;
        }

        $last_mod_date = date('c',time());
        return Response::view('sitemap.pdf', compact('articleInfos', 'last_mod_date'))
            ->header('Content-Type', 'application/xml');
    }
}