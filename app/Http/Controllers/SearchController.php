<?php

namespace App\Http\Controllers;

use App\Service\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{

    const PAGE_SIZE = 50;

    public function index()
    {
        $name = Session::get('name');
        $author = Session::get('author');
        $year = Session::get('year');

        if(!empty($name) || !empty($author) || !empty($year)) {
            return self::getContentView($name, $author, $year);
        }

        return view('search.index');
    }

    public function process(Request $request)
    {
        $name = $request->input('name');
        $author = $request->input('author');
        $year = $request->input('year');

        $errors = self::checkForErrors($name, $author, $year);

        if (count($errors) > 0) {
            return self::getBaseResposeView($name, $author, $year)->withErrors($errors);
        }

        Session::set('name', $request->input('name'));
        Session::set('author', $request->input('author'));
        Session::set('year', $request->input('year'));

        return self::getContentView($name, $author, $year);
    }

    private function getContentView($name, $author, $year)
    {
        $articles = SearchService::searchArticles($name, $author, $year, self::PAGE_SIZE);

        return self::getBaseResposeView($name, $author, $year)->with(array('articles' => $articles));
    }

    private function getBaseResposeView($name, $author, $year)
    {
        return  view('search.index')->with(array('name' => $name,
            'author' => $author,
            'year' => $year));
    }

    private function checkForErrors($name, $author, $year)
    {
        $errors = array();
        if(empty($name) && empty($author) && empty($year)) {
            $errors[] = 'Для пошуку потрібно заповнити хоча б одне з полів.';
        }

        if(!empty($name) && mb_strlen($name) < 4) {
            $errors[] = "Довжина зпиту 'Назва публікації' має складати мінімум 4 символи.";
        }

        if(!empty($author) && mb_strlen($author) < 2) {
            $errors[] = "Довжина зпиту 'Прізвище автора' має складати мінімум 2 символи.";
        }

        if(!empty($year) && (mb_strlen($year) != 4 || !is_numeric($year))) {
            $errors[] = "'Рік видання' має складатись з 4-х цифр.";
        }

        return $errors;
    }
}