<?php

namespace App\Dao;

use App\Exceptions\NoElementException;
use Exception;

class DaoUtil {

    public static function returnSingleElement($result) {
        if(count($result) > 1) {
            throw new Exception("Multiple results found by unique criteria!");
        }

        if (count($result) == 0) {
            throw new NoElementException();
        }

        return $result[0];
    }

}