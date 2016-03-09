<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.03.2016
 * Time: 11:00
 */

namespace App\Dao;


use Illuminate\Support\Facades\DB;

class ErrorUriDao {

    static function uriExists($uri)
    {
        $count = DB::table('error_uri')->where('uri', $uri)->count();
        return $count > 0;
    }

}