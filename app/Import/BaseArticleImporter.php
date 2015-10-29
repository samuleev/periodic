<?php

namespace App\Import;

use stdClass;



abstract class BaseArticleImporter {

    const ARTICLE_START_DELIMITER = "[";
    const ARTICLE_END_DELIMITER = "]";

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
        return Util::findSubStringBetween($line, self::ARTICLE_START_DELIMITER, self::ARTICLE_END_DELIMITER);
    }

    protected static function getArticleEngName($line)
    {
        return Util::findSubStringBetween($line, "{", "}");
    }

}