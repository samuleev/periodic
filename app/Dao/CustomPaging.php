<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13.12.2015
 * Time: 17:11
 */

namespace App\Dao;


interface CustomPaging {

    static function find($skip, $take);

    static function count();

}