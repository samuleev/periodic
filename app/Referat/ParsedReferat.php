<?php

namespace App\Referat;

class ParsedReferat {
    private $journalPrefix;
    private $year;
    private $editionNumber;
    private $articleNumber;
    private $udk;
    private $mainContent;
    private $alterContents;

    public function getJournalPrefix()
    {
        return $this->journalPrefix;
    }

    public function setJournalPrefix($journalPrefix)
    {
        $this->journalPrefix = $journalPrefix;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getEditionNumber()
    {
        return $this->editionNumber;
    }

    public function setEditionNumber($editionNumber)
    {
        $this->editionNumber = $editionNumber;
    }

    public function getArticleNumber()
    {
        return $this->articleNumber;
    }

    public function setArticleNumber($articleNumber)
    {
        $this->articleNumber = $articleNumber;
    }

    public function getUdk()
    {
        return $this->udk;
    }

    public function setUdk($udk)
    {
        $this->udk = $udk;
    }

    public function getMainContent()
    {
        return $this->mainContent;
    }

    public function setMainContent($mainContent)
    {
        $this->mainContent = $mainContent;
    }

    public function getAlterContents()
    {
        return $this->alterContents;
    }

    public function setAlterContents($alterContents)
    {
        $this->alterContents = $alterContents;
    }
}

