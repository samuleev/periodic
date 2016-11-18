<?php

namespace App\Service;

class EnglishService {

    private static $titleTranslation = array(
        'Титул' => 'Title',
        'Зміст' => 'Contents',
        'Наші автори' => 'Authors',
        'Алфавітний покажчик' => 'Index',
        'Реферати' => 'Abstracts',
        'Хроніка та інформація' => 'Chronicle and information',
        'Вихідні дані' => 'Issue information'
    );


    public static function mapAlternativesToArticles($articles, $alternatives) {
        foreach($articles as $article)
        {
            foreach($alternatives as $alternative) {
                if ($article->article_id == $alternative->article_id) {
                    $article->alternative = $alternative;
                    $article->authors = explode(', ', $alternative->authors);
                }
            }
        }
    }

    public static function renameCommonTitles($articles) {
        foreach($articles as $article) {
            foreach(EnglishService::$titleTranslation as $key => $value) {
                if($article->name == $key) {
                    $article->name = $value;
                    $article->language = 'eng';
                }
            }
        }
    }
}