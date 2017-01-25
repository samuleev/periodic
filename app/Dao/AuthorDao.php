<?php

namespace App\Dao;

use Illuminate\Support\Facades\DB;

class AuthorDao implements Dao, CustomPaging {

    static function findById($id)
    {
        $author = DB::table('author')->where('author_id', $id)->get();
        return DaoUtil::returnSingleElement($author);
    }

    static function findAll()
    {
        return DB::table('author')->orderby('name_short')->get();
    }

    static function persist($valueObject)
    {
        return DB::table('author')->insertGetId(get_object_vars($valueObject));
    }

    public static function findByFullName($author)
    {
        $query = DB::table('author')
            ->where('surname', $author->surname);

        if (isset($author->name))
        {
            $query = $query->where('name', $author->name);
        } else
        {
            $query = $query->whereNull('name');
        }

        if (isset($author->patronymic))
        {
            $query = $query->where('patronymic', $author->patronymic);
        } else
        {
            $query = $query->whereNull('patronymic');
        }

        $author = $query
            ->orderby('author_id')->get();
        if (count($author) == 0)
        {
            return null;
        }
        return $author[0];
    }

    static function getTop($take) {
        return DB::table('author')
            ->select('author.author_id', 'author.surname', 'author.name', 'author.patronymic',
                DB::raw('count(article_to_author.article_id) as number'))
            ->join('article_to_author', 'author.author_id', '=', 'article_to_author.author_id')
            ->groupby('author.author_id')
            ->orderby(DB::raw('count(article_to_author.article_id)'), 'desc')
            ->orderby('author.surname', 'asc')
            ->skip(0)->take($take)->get();
    }

    static function findByFirstSurnameLetter($letter)
    {
        return DB::table('author')
            ->where('surname', 'like', $letter."%")
            ->orderByRaw("surname COLLATE utf8_unicode_ci ASC")
            ->orderby('name', 'ASC')
            ->orderby('patronymic', 'ASC')
            ->get();
    }

    static function find($skip, $take)
    {
        return DB::table('author')->orderby('author_id')->skip($skip)->take($take)->get();
    }

    static function count()
    {
        return DB::table('author')->count();
    }
}