<?php

namespace app\Model;

class Edition {

    private $id;
    private $number;
    private $pictureFile;
    private $visible;
    private $numberInYear;
    private $issueYear;
    private $journal;
    private $articles = array();

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    public function setPictureFile($pictureFile)
    {
        $this->pictureFile = $pictureFile;
    }

    public function getVisible()
    {
        return $this->visible;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    public function getNumberInYear()
    {
        return $this->numberInYear;
    }

    public function setNumberInYear($numberInYear)
    {
        $this->numberInYear = $numberInYear;
    }

    public function getIssueYear()
    {
        return $this->issueYear;
    }

    public function setIssueYear($issueYear)
    {
        $this->issueYear = $issueYear;
    }

    public function getJournal()
    {
        return $this->journal;
    }

    public function setJournal($journal)
    {
        $this->journal = $journal;
    }

    public function getArticles()
    {
        return $this->articles;
    }

    public function setArticles($articles)
    {
        $this->articles = $articles;
    }
}