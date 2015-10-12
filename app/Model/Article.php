<?php

namespace app\Model;

class Article {

    private $id;
    private $topic;
    private $edition;
    private $contentFile;
    private $startPage;
    private $endPage;
    private $order;
    private $name;
    private $description;
    private $keywords;
    private $authors = array();
    private $fileSize;

    public function getFileSize()
    {
        return $this->fileSize;
    }

    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function setTopic($topic)
    {
        $this->topic = $topic;
    }

    public function getEdition()
    {
        return $this->edition;
    }

    public function setEdition($edition)
    {
        $this->edition = $edition;
    }

    public function getContentFile()
    {
        return $this->contentFile;
    }

    public function setContentFile($contentFile)
    {
        $this->contentFile = $contentFile;
    }

    public function getStartPage()
    {
        return $this->startPage;
    }

    public function setStartPage($startPage)
    {
        $this->startPage = $startPage;
    }

    public function getEndPage()
    {
        return $this->endPage;
    }

    public function setEndPage($endPage)
    {
        $this->endPage = $endPage;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }
}