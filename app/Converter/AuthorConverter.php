<?php

namespace App\Converter;

use App\Model\Author;
use stdClass;

class AuthorConverter {

    static function getArrayFromObject(Author $valueObject)
    {
        $authorArray = array();
        $authorArray['author_id'] = $valueObject->getId();
        $authorArray['name_short'] = $valueObject->getShortName();
        return $authorArray;
    }

    static function getObjectFromArray(stdClass $array)
    {
        $author = new Author();
        $author->setId($array->author_id);
        $author->setShortName($array->name_short);
        return $author;
    }
}