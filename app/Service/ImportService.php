<?php

namespace App\Service;

use App\Dao\EditionDao;
use App\Dao\JournalDao;
use Exception;
use Illuminate\Support\Facades\DB;
use stdClass;

class ImportService {

    public static function import()
    {
        DB::transaction(function() {
            $lines = file(public_path().'/data/'.'zmist.txt');
            $editionId = self::importEdition($lines[0]);
            self::importStartingSpecialArticles(array_slice($lines, 1, 2, true), $editionId);
            self::importCommonArticles(array_slice($lines, 3, -2, true), $editionId);
            self::importEndingSpecialArticles(array_slice($lines, -2, 2, true), $editionId);
            //throw new Exception('Some test exception');
        });
    }

    private static function importEdition($line)
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
        $parsedEdition->journal_name = self::bomTrim($parsedLine[0]);
        $parsedEdition->issue_year = trim($parsedLine[1]);

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


    private static function importStartingSpecialArticles(array $lines, $editionId)
    {
        foreach ($lines as $index => $line)
        {
            self::importStartingSpecialArticle(trim($line), $editionId, $index);
        }
    }

    private static function importStartingSpecialArticle($line, $editionId, $index)
    {
        $articleName = self::getArticleName($line);
        if (!isset($articleName))
        {
            throw new Exception("Can not find article name in line: ".$line);
        }

        $engName = self::getArticleEngName($line);

        $pages = self::getPages($line);

        dd($pages);
    }

    private static function getPages($line)
    {
        $pages = new stdClass();

        $start = strrpos($line, ' ');
        if($start === FALSE)
        {
            $pages->start = null;
            $pages->end = null;
            return $pages;
        }

        $pagesString = substr($line, $start + 1, strlen($line) - $start);

        if (strrpos($pagesString, '-'))
        {
            $elements = explode('-', $pagesString);
            $pages->start = $elements[0];
            $pages->end = $elements[1];
        }
        else
        {
            $pages->start = $pagesString;
            $pages->end = null;
        }
        return $pages;
    }

    private static function getArticleName($line)
    {
        return self::findSubStringBetween($line, "[", "]");
    }

    private static function getArticleEngName($line)
    {
        return self::findSubStringBetween($line, "{", "}");
    }

    private static function findSubStringBetween($string, $openingString, $closingSting)
    {
        $start = stripos($string, $openingString);
        $end = stripos($string, $closingSting);
        if ($start === FALSE || $end === FALSE)
        {
            return null;
        }
        $startCount = strlen($openingString);
        return substr($string, $start + $startCount, $end - $start - $startCount);
    }

    private static function importEndingSpecialArticles(array $lines, $editionId)
    {

    }

    private static function importCommonArticles(array $lines, $editionId)
    {

    }

}