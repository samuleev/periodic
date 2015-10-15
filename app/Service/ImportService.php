<?php

namespace App\Service;

use App\Dao\JournalDao;
use Exception;
use stdClass;

class ImportService {

    public static function import()
    {
        $lines = file(public_path().'/data/'.'zmist.txt');
        ImportService::importEdition($lines[0]);
        ImportService::importStartingSpecialArticles(array_slice($lines, 1, 2, true));
        ImportService::importCommonArticles(array_slice($lines, 3, -2, true));
        ImportService::importEndingSpecialArticles(array_slice($lines, -2, 2, true));

//        throw new Exception('Some test exception');
    }

    private static function importEdition($line)
    {
        $line = trim($line);
        $parsedEdition = ImportService::parseEditionLine($line);

        $journal = JournalDao::findByName($parsedEdition->journal_name);
        if(!isset($journal))
        {
            throw new Exception('Журнал с таким именем в базе не существует: '.$parsedEdition->journal_name);
        }

        dd($journal);
    }

    private static function parseEditionLine($line) {
        $parsedEdition = new stdClass;

        $line = trim($line);
        $parsedLine = explode(', ',$line);
        $parsedEdition->journal_name = ImportService::bomTrim($parsedLine[0]);
        $parsedEdition->edition_year = trim($parsedLine[1]);

        $numberString = trim($parsedLine[2],'№');
        $numberString = trim($numberString,')');
        $numberString = trim($numberString);
        $parsedNumber = explode('(',$numberString);

        $parsedEdition->number_in_year = $parsedNumber[0];
        $parsedEdition->number = $parsedNumber[1];
        return $parsedEdition;
    }

    private static final function bomTrim($string)
    {
        if(substr($string,0,3) == pack("CCC",0xef,0xbb,0xbf))
        {
            return trim(substr($string, 3));
        }
        return trim($string);
    }


    private static function importStartingSpecialArticles(array $lines)
    {

    }

    private static function importEndingSpecialArticles(array $lines)
    {

    }

    private static function importCommonArticles(array $lines)
    {

    }

}