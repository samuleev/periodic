<?php

namespace App\Import;

use Exception;
use Illuminate\Support\Facades\DB;

class MainImporter {

    public static function import()
    {
        DB::transaction(function() {
            $lines = file(public_path().'/data/'.'zmist.txt');
            $lines = self::clean($lines);
            $editionId = EditionImporter::importEdition($lines[0]);
            $index = 1;
            $index = SpecialArticleImporter::import(array_slice($lines, 1, 2, true), $editionId, $index);
            $index = CommonArticleImporter::import(array_slice($lines, 3, -2, true), $editionId, $index);
            SpecialArticleImporter::import(array_slice($lines, -2, 2, true), $editionId, $index);
            //throw new Exception('Some test exception');
        });
    }

    private static function clean($lines)
    {
        $newLines = array();
        foreach($lines as $line)
        {
            $newLines[] = Util::remove_utf8_bom($line);
        }
        return $newLines;
    }

}