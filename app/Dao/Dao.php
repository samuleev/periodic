<?php

namespace App\Dao;

interface Dao {

    static function findById($id);

    static function findAll();

    static function persist($valueObject);

    static function update($valueObject);

    static function delete($valueObject);

}