<?php

namespace App\Http\Controllers;

use App\Dao\ArticleDao;
use App\Dao\TopicDao;

class TopicController extends Controller {

    const PAGE_SIZE = 50;

    public function show($topicId)
    {
        $topic = TopicDao::findById($topicId);
        $articles = ArticleDao::findByTopicPaginated($topicId, self::PAGE_SIZE);
        return view('topic.details')->with(array('topic' => $topic,
            'articles' => $articles));
    }

    public function index()
    {
        $topics = TopicDao::paginate(self::PAGE_SIZE);
        return view('topic.index')->with(array('topics' => $topics));
    }

}