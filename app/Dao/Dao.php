<?php

namespace App\Dao;

interface Dao {

    static function findById($id);

    static function findAll();

    static function persist($valueObject);

}