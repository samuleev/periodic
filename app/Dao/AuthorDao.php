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
        // TODO: Implement persist() method.
    }

    static function update($valueObject)
    {
        // TODO: Implement update() method.
    }

    static function delete($valueObject)
    {
        // TODO: Implement delete() method.
    }
}