<?php

namespace App\Referat;

use App\Dao\AlternativeDao;
use App\Dao\ArticleDao;
use Exception;
use Illuminate\Support\Facades\DB;

class ReferatImporter {

    public static function import() {
        DB::transaction(function() {
            $referats = ReferatParser::parse(public_path().'/data/'.'abstracts_import.xlsx');
            self::process($referats);
            //throw new Exception('Some test exception');
        });
    }

    private static function process($referats) {
        foreach ($referats as $referat) {
            self::processSingleReferat($referat);
        }
    }

    private static function processSingleReferat($referat) {
        $article = ArticleDao::findByPeriodic($referat->getJournalPrefix(), $referat->getYear(),
            $referat->getEditionNumber(), $referat->getArticleNumber());

        if($article->name != $referat->getMainContent()->name){
            throw new Exception('Article names not match:' . $article->name . ' --- '
                . $referat->getMainContent()->name);
            //echo $article->name . ' --- <br> ' . $referat->getMainContent()->name. '<br><br>';
        }

        self::upadateArticle($article, $referat);
        self::processAlternatives($article, $referat->getAlterContents());
    }

    private static function upadateArticle($article, $referat) {
        DB::table('article')
            ->where('article_id', $article->article_id)
            ->update(['udk' => $referat->getUdk(),
                'authors' => $referat->getMainContent()->authors,
                'description' => $referat->getMainContent()->description,
                'keywords' => $referat->getMainContent()->keywords,
                'language' => $referat->getMainContent()->language ]);
    }

    private static function processAlternatives($article, $alternatives) {
        foreach ($alternatives as $alternative) {
            self::processSingleAlternative($article, $alternative);
        }
    }

    private static function processSingleAlternative($article, $alternative) {
        $alternative->article_id = $article->article_id;
        $existingAlternative = AlternativeDao::findByArticleIdAndLanguage($alternative->article_id, $alternative->language);
        if (count($existingAlternative) != 0) {
            AlternativeDao::update($alternative);
        } else {
            AlternativeDao::persist($alternative);
        }
    }
}