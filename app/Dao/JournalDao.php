<?php

namespace App\Dao;

use Illuminate\Support\Facades\DB;

class JournalDao implements Dao
{

    static function findById($id)
    {
        $journal = DB::table('journal')->where('journal_id', $id)->get();
        return $journal[0];
    }

    static function findAll()
    {
        return DB::table('journal')->orderby('sort_order')->get();
    }

    static function findByName($name)
    {
        DB::enableQueryLog();
        $journal = DB::table('journal')->where('name', $name)->get();
        //dd(DB::getQueryLog());
        if (count($journal) == 0)
        {
            return null;
        }
        return $journal[0];
    }

    static function persist($valueObject)
    {
        // TODO: Implement persist() method.
    }

}