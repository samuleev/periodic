<?php

namespace App\Import;

use App\Service\TopicService;
use Exception;
use Illuminate\Support\Facades\DB;

class MainImporter {

    public static function import()
    {
        DB::transaction(function() {
            $lines = file(public_path().'/data/'.'zmist.txt');
            $lines = self::clean($lines);
            $editionId = EditionImporter::importEdition($lines[0]);
            self::process(array_slice($lines, 1), $editionId, 1);
            //throw new Exception('Some test exception');
        });
    }

    private static function process(array $lines, $editionId, $startIndex){
        $index = $startIndex;
        $topic = TopicService::getDefaultTopic();
        foreach ($lines as $line)
        {
            if(TopicImporter::isTopicLine($line))
            {
                $topic = TopicImporter::getTopic(trim($line));

            } else
            {
                if (self::isSpecialArticle($line))
                {
                    SpecialArticleImporter::importSingleArticle($line, $editionId, $index);

                } else
                {
                    CommonArticleImporter::importSingleArticle($line, $editionId, $index, $topic);
                }
                $index++;
            }
        }
    }

    private static function isSpecialArticle($line) {
        return substr($line, 0, strlen(BaseArticleImporter::ARTICLE_START_DELIMITER)) == BaseArticleImporter::ARTICLE_START_DELIMITER;
    }

    private static function clean($lines)
    {
        $newLines = array();
        foreach($lines as $line)
        {
            $cleanedLine = Util::remove_utf8_bom($line);
            if( strlen($cleanedLine) > 1) {
                $newLines[] = $cleanedLine;
            }
        }
        return $newLines;
    }

}