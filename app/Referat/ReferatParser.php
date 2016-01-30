<?php

namespace App\Referat;

use SpreadsheetReader;
use stdClass;

class ReferatParser {

    const SHEET_INDEX = 0;
    const UKR_LANG = 'ukr';
    const RUS_LANG = 'rus';
    const ENG_LANG = 'eng';
    private static $SKIP_ROWS = array(0, 1);

    public static function parse($excelFileName) {
        $spreadsheet = new SpreadsheetReader($excelFileName);
        $spreadsheet->ChangeSheet(self::SHEET_INDEX);
        $parsedReferats = array();
        foreach ($spreadsheet as $key => $row)
        {
            if ($row && !in_array($key, self::$SKIP_ROWS))
            {
                $parsedReferats[] = self::parseRow($row);
            }
        }
        return $parsedReferats;
    }

    private static function parseRow($row) {
        //$row = self::convertRowEncoding($row);
        $row = self::cleanRow($row);
        $parsedReferat = new ParsedReferat();
        $parsedReferat->setJournalPrefix($row[0]);
        $parsedReferat->setYear($row[1]);
        $parsedReferat->setEditionNumber($row[2]);
        $parsedReferat->setArticleNumber($row[3]);
        $parsedReferat->setUdk($row[4]);

        $articleLanguage = $row[5];

        $alternatives = self::getAlternatives($row);

        $parsedReferat->setMainContent($alternatives[$articleLanguage]);
        unset($alternatives[$articleLanguage]);

        $parsedReferat->setAlterContents($alternatives);

        return $parsedReferat;
    }

    private static function getAlternatives($row) {
        $alternatives = array();

        $alternative = self::parseAlernative(array_slice($row, 6, 4));
        if (!empty($alternative)) {
            $alternatives[self::UKR_LANG] = $alternative;
        }

        $alternative = self::parseAlernative(array_slice($row, 10, 4));
        if (!empty($alternative)) {
            $alternatives[self::RUS_LANG] = $alternative;
        }

        $alternative = self::parseAlernative(array_slice($row, 14, 4));
        if (!empty($alternative)) {
            $alternatives[self::ENG_LANG] = $alternative;
        }

        self::setLanguages($alternatives);

        return $alternatives;
    }

    private static function setLanguages($alternatives) {
        foreach ($alternatives as $language => $alternative) {
            $alternative->language = $language;
        }
    }

//    private static function convertRowEncoding($row) {
//        $newRow = array();
//        foreach ($row as $column_index => $column) {
//            $newRow[$column_index] = mb_convert_encoding($column, 'CP1251', 'UTF-8');
//        }
//        return $newRow;
//    }

    private static function parseAlernative($rowSubArray) {
        if (empty($rowSubArray[0])) {
            return null;
        }
        $alternative = self::createEmptyAlternative();
        $alternative->name = trim($rowSubArray[0], '.');

        if (!empty($rowSubArray[1])) {
            $alternative->authors = $rowSubArray[1];
        }

        if (!empty($rowSubArray[2])) {
            $alternative->description = $rowSubArray[2];
        }

        if (!empty($rowSubArray[3])) {
            $alternative->keywords = $rowSubArray[3];
        }

        return $alternative;
    }

    private static function createEmptyAlternative(){
        $alternative = new stdClass();
        $alternative->name = "";
        $alternative->authors = "";
        $alternative->description = "";
        $alternative->keywords = "";
        return $alternative;
    }

    private static function cleanRow($row) {
        $newRow = array();
        foreach ($row as $column_index => $column) {
            $column = trim($row[$column_index]);
            $column = str_replace('-/n', '', $column);
            $column = str_replace('/n', ' ', $column);
            $column = str_replace('  ', ' ', $column);
            $newRow[$column_index] = trim($column);
        }
        return $newRow;
    }
}