<?php

namespace App\Import;

class Util {

    public static final function bomTrim($string)
    {
        if(substr($string,0,3) == pack("CCC",0xef,0xbb,0xbf))
        {
            return trim(substr($string, 3));
        }
        return trim($string);
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