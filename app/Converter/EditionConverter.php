<?php

namespace App\Converter;

use App\Model\Edition;
use stdClass;

class EditionConverter {

    static function getArrayFromObject(Edition $valueObject)
    {
        $editionArray = array();
        $editionArray['journal_edition_id'] = $valueObject->getId();
        $editionArray['journal_id'] = $valueObject->getJournal()->journal_id;
        $editionArray['number'] = $valueObject->getNumber();
        $editionArray['picture_file'] = $valueObject->getPictureFile();
        $editionArray['visible'] = $valueObject->getVisible();
        $editionArray['number_in_year'] = $valueObject->getNumberInYear();
        $editionArray['issue_year'] = $valueObject->getIssueYear();

        return $editionArray;
    }

    static function getObjectFromArray(stdClass $array)
    {
        $edition = new Edition();
        $edition->setId($array->journal_edition_id);
        $edition->setNumber($array->number);
        $edition->setPictureFile($array->picture_file);
        $edition->setVisible($array->visible);
        $edition->setNumberInYear($array->number_in_year);
        $edition->setIssueYear($array->issue_year);
        return $edition;
    }
}