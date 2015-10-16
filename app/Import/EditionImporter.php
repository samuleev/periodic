<?php

namespace App\Import;

use App\Dao\EditionDao;
use App\Dao\JournalDao;
use Exception;
use stdClass;

class EditionImporter {

    public static function importEdition($line)
    {
        $line = trim($line);
        $parsedEdition = self::parseEditionLine($line);
        $edition = self::createEdition($parsedEdition);
        return EditionDao::persist($edition);
    }

    private static function createEdition(stdClass $parsedEdition) {
        $journal = JournalDao::findByName($parsedEdition->journal_name);
        if(!isset($journal))
        {
            throw new Exception('Журнал с таким именем в базе не существует: '.$parsedEdition->journal_name);
        }

        $edition = new stdClass();
        $edition->journal_id = $journal->journal_id;
        $edition->number = $parsedEdition->number;
        $edition->number_in_year = $parsedEdition->number_in_year;
        $edition->issue_year = $parsedEdition->issue_year;
        return $edition;
    }

    private static function parseEditionLine($line) {
        $parsedEdition = new stdClass;

        $line = trim($line);
        $parsedLine = explode(', ',$line);
        $parsedEdition->journal_name = Util::bomTrim($parsedLine[0]);
        $parsedEdition->issue_year = trim($parsedLine[1]);

        $numberString = trim($parsedLine[2],'№');
        $numberString = trim($numberString,')');
        $numberString = trim($numberString);
        $parsedNumber = explode('(',$numberString);

        $parsedEdition->number_in_year = $parsedNumber[0];
        $parsedEdition->number = $parsedNumber[1];
        return $parsedEdition;
    }

}