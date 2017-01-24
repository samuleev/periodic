<?php

namespace App\Service;

use App\Dao\JournalDao;
use Illuminate\Support\Facades\DB;

class ScholarUpdateService {

    private static $opts = array(
        'http'=>array(
            "method" => "GET",
            "header" => "Accept: xml/*, text/*, */*\r\n",
            "ignore_errors" => false,
            "timeout" => 50
        ));

    public static function updateScholar() {
        $context = stream_context_create(self::$opts);
        ini_set("user_agent" , "Mozilla/3.0\r\nAccept: */*\r\nX-Padding: Foo");

        $journals = JournalDao::findAll();

        foreach($journals as $journal) {
            if (empty($journal->google_scholar)) {
                continue;
            }
            $statdata = self::getStatData($journal->google_scholar, $context);

            echo $journal->name;
            echo '<br>';
            echo $statdata->quotation;
            echo '<br>';
            echo $statdata->h_index;
            echo '<br>';
            echo $statdata->i10;
            echo '<br>';

            echo '<hr>';

            self::updateJournal($journal, $statdata);
        }

    }

    private static function updateJournal($journal, $statdata) {
        DB::table('journal')
            ->where('journal_id', $journal->journal_id)
            ->update(['quotation' => $statdata->quotation,
                'h_index' => $statdata->h_index,
                'i10' => $statdata->i10,
                'index_update' => date('Y-m-d')]);
    }

    public static function getStatData($url, $context) {
        $content = self::file_get_contents_utf8($url, false, $context);

        $statTable = self::findElement($content, 'table', 'id', 'gsc_rsb_st');

        $statdata = new StatData();
        $statdata->quotation = self::getValue($statTable, 'Статистика цитирования');
        $statdata->h_index = self::getValue($statTable, 'h-индекс');
        $statdata->i10 = self::getValue($statTable, 'i10-индекс');
        return $statdata;
    }

    public static function file_get_contents_utf8($fn) {
        $content = file_get_contents($fn);
        $result = mb_convert_encoding($content, "utf-8", "windows-1251");
        return $result;
    }

    public static function getValue($source, $leftHeader) {
        $startLeftHeader = stripos($source, $leftHeader);
        if ($startLeftHeader === false) {
            echo 'Start of left header not found: ' . $leftHeader;
            return false;
        }

        $tdClosing = stripos($source, '</td>', $startLeftHeader);
        if ($tdClosing === false) {
            echo 'td closing not found: ' . $leftHeader;
            return false;
        }

        $tdClosing = $tdClosing + 5; // add </td> size

        $subString = substr($source, $tdClosing);

        return self::findElement($subString, 'td', 'class', 'gsc_rsb_std');
    }

    public static function findElement($source, $tag, $propertyName, $propertyValue) {
        $startStr = '<' .  $tag . ' '. $propertyName .'="' . $propertyValue .'"';
        $startOfOpenTag = stripos($source, $startStr);
        if ($startOfOpenTag === false) {
            echo 'The open tag start not found: ' . $tag . ' ' . $propertyValue;
            return false;
        }

        $endOfOpenTag = stripos($source, '>', $startOfOpenTag);
        if ($endOfOpenTag === false) {
            echo 'The open tag end not found: ' . $tag . ' ' . $propertyValue;
            return false;
        }

        $endOfOpenTag = $endOfOpenTag + 1; // add length of '>'

        $endStr = '</' . $tag  . '>';
        $endPos = stripos($source, $endStr, $endOfOpenTag);

        if ($endPos === false) {
            echo 'The closing tag not found: ' . $tag . ' ' . $propertyValue;
            return false;
        }

        $result = substr($source, $endOfOpenTag, $endPos - $endOfOpenTag);

        return $result;
    }

}

class StatData {

    public $quotation;
    public $h_index;
    public $i10;

}