<?php

namespace App\Import;

class Util {

    public static final function remove_utf8_bom($text)
    {
        //remove_utf8_bom
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        //remove NO-BREAK SPACE
        $text = str_replace("\xc2\xa0", ' ', $text);
        //replace double space
        $text = str_replace('  ', ' ', $text);
        return trim($text);
    }

    public static function findSubStringBetween($string, $openingString, $closingSting)
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

}