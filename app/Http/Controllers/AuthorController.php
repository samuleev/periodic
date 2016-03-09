<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Dao\AuthorDao;
use App\Exceptions\NoElementException;
use App\Service\ArticleService;
use Illuminate\Support\Facades\App;

class AuthorController extends Controller {

    public function show($authorId)
    {
        try {
            $author = AuthorDao::findById($authorId);
        } catch (NoElementException $e) {
            App::abort(404, 'Author not found');
        }
        $articles = ArticleDao::findByAuthor($authorId);
        $articles = ArticleService::getEnrichedArticles($articles);

        return view('author.details')->with(array('author' => $author, 'articles' => $articles));
    }

    public function showByFirstSurnameLetter($letter)
    {
        $authors = AuthorDao::findByFirstSurnameLetter($letter);
        $sub_authors = self::getSubAuthors($authors);
        $COLUMN_COUNT = 4; //Должно быть делителем 12
        $sub_authors = self::rotateSubAuthors($sub_authors, $COLUMN_COUNT);
        return view('author.by_letter')->with(array(
            'sub_authors' => $sub_authors,
            'column_count' => $COLUMN_COUNT,
            'letter' => $letter
        ));
    }

    private function rotateSubAuthors($sub_authors, $columnCount)
    {
        $newSubAuthors = array();
        foreach($sub_authors as $sub => $authors)
        {
            $modulo = floor(count($authors) / $columnCount);
            $quotient = count($authors) - $modulo*$columnCount;
            $columns = array();
            $authorIndex = 0;
            for($column_index = 0; $column_index < $columnCount; $column_index++)
            {
                $column = array();
                $columnSize = null;
                if ($quotient > 0)
                {
                    $columnSize = $modulo + 1;
                    $quotient--;
                } else {
                    $columnSize = $modulo;
                }

                for($i = 0; $i < $columnSize; $i++)
                {
                    $column[] = $authors[$authorIndex];
                    $authorIndex++;
                }

                $columns[] = $column;
            }

            $newAuthors = array();
            $newAuthorsIndex = 0;
            for($i = 0; $i < $modulo+1; $i++)
            {
                for($column_index = 0; $column_index < $columnCount; $column_index++)
                {
                    if(isset($columns[$column_index][$i])) {
                        $newAuthors[$newAuthorsIndex] = $columns[$column_index][$i];
                        $newAuthorsIndex++;
                    }
                }
            }

            $newSubAuthors[$sub] = $newAuthors;
        }

        return $newSubAuthors;
    }



    private static function getSubAuthors($authors)
    {
        $sub_authors = array();
        $sub = '';

        foreach($authors as $author)
        {
            if (mb_strtoupper(mb_substr($author->surname, 0, 2, 'UTF-8'), 'UTF-8') != $sub)
            {
                $sub = mb_strtoupper(mb_substr($author->surname, 0, 2, 'UTF-8'), 'UTF-8');

                $sub_authors[$sub] = array();
            }
            $sub_authors[$sub][] = $author;
        }

        return $sub_authors;
    }

    public function index()
    {
        return view('author.index');
    }
}