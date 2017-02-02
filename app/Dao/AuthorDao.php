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

    static function getTopCombined($take) {
        $query = DB::table('author')
            ->select('author.author_id', 'author.surname', 'author.name', 'author.patronymic',
                DB::raw('count(article_to_author.article_id) + COALESCE(lang.number_lang ,0) as number'))
            ->join('article_to_author', 'author.author_id', '=', 'article_to_author.author_id')
            ->leftJoin(DB::raw('(select author_lang.author_id, count(article_to_author.article_id) as number_lang '.
                                'from author '.
		                        'inner join article_to_author on author.author_id = article_to_author.author_id '.
		                        'inner join author_lang on author.author_id = author_lang.author_lang_id '.
		                        'group by author_lang.author_id) lang'), function($join)
            {
                $join->on('author.author_id', '=', 'lang.author_id');
            })
            ->whereRaw('author.author_id not in (select author_lang.author_lang_id from author_lang)')
            ->groupby('author.author_id')
            ->orderby('number', 'desc')
            ->orderby('author.surname', 'asc')
            ->skip(0)->take($take);
        return $query->get();
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