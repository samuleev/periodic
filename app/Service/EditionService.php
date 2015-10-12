<?php

namespace App\Service;


use App\Converter\EditionConverter;
use App\Dao\ArticleDao;
use App\Dao\EditionDao;
use App\Dao\JournalDao;
use App\Model\Edition;

class EditionService {

    static function findById($editionId)
    {
        $editionRow = EditionDao::findById($editionId);
        $edition = EditionConverter::getObjectFromArray($editionRow);

        $journalRow = JournalDao::findById($editionRow->journal_id);
        $edition->setJournal($journalRow);

        $articleRows = ArticleDao::findByEdition($editionId);
        $articles = ArticleService::getEnrichedArticles($articleRows);
        $edition->setArticles($articles);

        return $edition;
    }

}