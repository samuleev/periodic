<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Dao\AuthorDao;
use App\Dao\JournalDao;
use App\Dao\TopicDao;
use App\Service\ArticleService;
use App\Service\ArticleWithJournalInfoService;
use App\Service\EditionWithJournalInfoService;
use Illuminate\Support\Facades\Response;


class SitemapController extends Controller {

    const SITEMAP_SIZE = 20000;
    const BASE_URL = 'http://www.hups.mil.gov.ua/periodic-app/';

    public function main()
    {
        $sitemaps = array();
        $sitemaps = array_merge($sitemaps, self::getItems(ArticleDao::class, 'sitemap-article'));
        $sitemaps = array_merge($sitemaps, self::getItems(ArticleWithJournalInfoService::class, 'sitemap-pdf'));
        $sitemaps = array_merge($sitemaps, self::getItems(AuthorDao::class, 'sitemap-author'));
        $sitemaps[] = "sitemap-misc.xml";
        $last_mod_date = date('c',time());
        return Response::view('sitemap.main', compact('sitemaps', 'last_mod_date'))
            ->header('Content-Type', 'text/plain');
    }

    private function getItems($customPaging, $prefix)
    {
        $count = $customPaging::count();
        $pages = ceil($count / self::SITEMAP_SIZE);
        $items = array();
        for ($i = 1; $i < $pages + 1; $i++)
        {
            $items[] = $prefix . $i . '.xml';
        }
        return $items;
    }

    public function article($page)
    {
        $articles = ArticleDao::find(($page - 1) * self::SITEMAP_SIZE, self::SITEMAP_SIZE);
        return Response::view('sitemap.article', compact('articles'))
            ->header('Content-Type', 'application/xml');
    }

    public function pdf($page)
    {
        $articleInfos = ArticleWithJournalInfoService::find(($page - 1) * self::SITEMAP_SIZE, self::SITEMAP_SIZE);
        foreach($articleInfos as $articleInfo)
        {
            $fileName = ArticleService::getArticleFileName($articleInfo->prefix, $articleInfo->issue_year,
                $articleInfo->number_in_year, $articleInfo->sort_order);

            $articleInfo->fileName = $fileName;
        }

        return Response::view('sitemap.pdf', compact('articleInfos'))
            ->header('Content-Type', 'application/xml');
    }

    public function misc()
    {
        $topics = TopicDao::findAll();
        $editions = EditionWithJournalInfoService::findAll();
        $journals = JournalDao::findAll();

        return Response::view('sitemap.misc', compact('topics', 'editions', "journals"))
            ->header('Content-Type', 'application/xml');
    }

    public function author($page)
    {
        $authors = AuthorDao::find(($page - 1) * self::SITEMAP_SIZE, self::SITEMAP_SIZE);

        return Response::view('sitemap.author', compact('authors'))
            ->header('Content-Type', 'application/xml');
    }

}