<?php

namespace App\Http\Controllers;

class AuthorController extends Controller {

    public function show($articleId)
    {

    }

    public function index()
    {
        return view('author.index');
    }
}