<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;

class EditionWithJournalInfoService {

    static function findAll()
    {
        return DB::table('journal_edition')
            ->select('journal_edition.journal_edition_id', 'journal_edition.issue_year',
                'journal_edition.number_in_year', 'journal_edition.updated', 'journal.prefix')
            ->join('journal', 'journal.journal_id', '=', 'journal_edition.journal_id')
            ->orderby('journal_edition.journal_edition_id')
            ->get();
    }

}