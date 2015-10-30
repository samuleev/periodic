<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use DateTime;

class SitemapController extends Controller {

    public function article()
    {
        $articles = ArticleDao::findAll();
        $last_mod_date = date(DateTime::ISO8601);
        return view('sitemap.article')->with(array('articles' => $articles, 'last_mod_date' => $last_mod_date));
    }
}