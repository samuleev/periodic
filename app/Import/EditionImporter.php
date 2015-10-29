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
        $editionId = null;
        try {
            $editionId = EditionDao::persist($edition);
        } catch (Exception $e) {
            if(strrpos($e->getMessage(), 'Duplicate entry'))
            {
                throw new Exception('Номер данного журнала уже имортирован');
            }
            throw $e;
        }
        return $editionId;
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
        $parsedEdition->journal_name =trim($parsedLine[0]);
        $parsedEdition->issue_year = trim($parsedLine[1]);

        $parsedNumber = self::getParsedNumbers($parsedLine[2]);

        $parsedEdition->number_in_year = $parsedNumber[0];
        $parsedEdition->number = $parsedNumber[1];
        return $parsedEdition;
    }

    private static function getParsedNumbers($numberString)
    {
        $numberString = trim($numberString);
        $lastSpacePos = strpos($numberString, ' ');
        $numberString = substr($numberString, $lastSpacePos + 1);
        $numberString = trim($numberString,')');
        $numberString = trim($numberString);

        $numberString = str_replace(' ', '', $numberString);
        $parsedNumbers = explode('(',$numberString);

        if (count($parsedNumbers) != 2 || !is_numeric($parsedNumbers[0]) || !is_numeric($parsedNumbers[1]))
        {
            throw new Exception("error parsing edition number!");
        }

        return $parsedNumbers;
    }

}