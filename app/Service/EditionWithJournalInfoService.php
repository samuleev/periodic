<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use App\Dao\CustomPaging;

class EditionWithJournalInfoService implements CustomPaging {

    static function find($skip, $take)
    {
        return DB::table('journal_edition')
            ->select('journal_edition.journal_edition_id', 'journal_edition.issue_year',
                'journal_edition.number_in_year', 'journal.prefix')
            ->join('journal', 'journal.journal_id', '=', 'journal_edition.journal_id')
            ->orderby('journal_edition.journal_edition_id')
            ->skip($skip)->take($take)->get();
    }

    static function count()
    {
        return DB::table('journal_edition')->count();
    }
}