<?php

namespace App\Dao;

use Exception;
use Illuminate\Support\Facades\DB;

class JournalDao implements Dao, CustomPaging {

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
        $journal = DB::table('journal')->where('name', $name)->get();
        if (count($journal) == 0)
        {
            return null;
        }
        return $journal[0];
    }

    static function findByPrefix($prefix)
    {
        $journal = DB::table('journal')->where('prefix', $prefix)->get();
        if (count($journal) == 0)
        {
            return null;
        }
        return $journal[0];
    }

    static function persist($valueObject)
    {
        throw new Exception('Not implemented yet');
    }

    static function find($skip, $take)
    {
        return DB::table('journal')->orderby('journal_id')->skip($skip)->take($take)->get();
    }

    static function count()
    {
        return DB::table('journal')->count();
    }
}