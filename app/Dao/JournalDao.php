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