<?php

namespace App\Converter;

use App\Model\Article;
use stdClass;

class ArticleConverter {

    static function getArrayFromObject(Article $valueObject)
    {
        $articleArray = array();
        $articleArray['article_id'] = $valueObject->getId();
        $articleArray['topic_id'] = $valueObject->getTopic()->topic_id;
        $articleArray['journal_edition_id'] = $valueObject->getEdition()->getId();
        $articleArray['content_file'] = $valueObject->getContentFile();
        $articleArray['start_page'] = $valueObject->getStartPage();
        $articleArray['end_page'] = $valueObject->getEndPage();
        $articleArray['name'] = $valueObject->getName();
        $articleArray['description'] = $valueObject->getDescription();
        $articleArray['keywords'] = $valueObject->getKeywords();
        $articleArray['sort_order'] = $valueObject->getOrder();
        return $articleArray;
    }

    static function getObjectFromArray(stdClass $array)
    {
        $article = new Article();
        $article->setId($array->article_id);
        $article->setContentFile($array->content_file);
        $article->setStartPage($array->start_page);
        $article->setEndPage($array->end_page);
        $article->setName($array->name);
        $article->setDescription($array->description);
        $article->setKeywords($array->keywords);
        $article->setOrder($array->sort_order);
        return $article;
    }
}