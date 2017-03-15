<?php

namespace App\Dao;

use Illuminate\Support\Facades\DB;

class ChapterDao {

    static function findAll()
    {
        return DB::table('chapter')->orderby('sort_order')->get();
    }

    static function findById($id)
    {
        $chapter = DB::table('chapter')->where('chapter_id', $id)->get();

        return DaoUtil::returnSingleElement($chapter);
    }

}