<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Dao\AuthorDao;
use App\Service\ArticleService;

class AuthorController extends Controller {

    public function show($authorId)
    {
        $author = AuthorDao::findById($authorId);
        $articles = ArticleDao::findByAuthor($authorId);
        $articles = ArticleService::getEnrichedArticles($articles);

        return view('author.details')->with(array('author' => $author, 'articles' => $articles));
    }

    public function index()
    {
        return view('author.index');
    }
}