<?php

namespace App\Import;

use stdClass;

abstract class BaseArticleImporter {

    protected static function generateContentFileName($index)
    {
        return $index.'.pdf';
    }

    protected static function getPages($line)
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

    protected static function getArticleName($line)
    {
        return Util::findSubStringBetween($line, "[", "]");
    }

    protected static function getArticleEngName($line)
    {
        return Util::findSubStringBetween($line, "{", "}");
    }

}