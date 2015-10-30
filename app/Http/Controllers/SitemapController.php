<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use DateTime;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller {

    public function article()
    {
        $articles = ArticleDao::findAll();
        $last_mod_date = date(DateTime::ISO8601);
        return Response::view('sitemap.article', compact('articles', 'last_mod_date'))
//            ->with(array('articles' => $articles, 'last_mod_date' => $last_mod_date))
            ->header('Content-Type', 'application/xml');
    }
}