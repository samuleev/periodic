<?php

namespace App\Dao;


use Illuminate\Support\Facades\DB;

class AuthorDao implements Dao {

    static function findById($id)
    {
        $author = DB::table('author')->where('author_id', $id)->get();
        return $author[0];
    }

    static function findAll()
    {
        return DB::table('author')->orderby('name_short')->get();
    }

    static function persist($valueObject)
    {
        return DB::table('author')->insertGetId(get_object_vars($valueObject));
    }

    public static function findByName($name)
    {
        $author = DB::table('author')
            ->where('name_short', $name)
            ->orderby('author_id')->get();
        if (count($author) == 0)
        {
            return null;
        }
        return $author[0];
    }
}