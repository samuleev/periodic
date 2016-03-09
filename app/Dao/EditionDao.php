<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 06.10.2015
 * Time: 10:23
 */

namespace App\Dao;

use Illuminate\Support\Facades\DB;

class EditionDao implements Dao {

    static function listAllYears()
    {
        $issue_years = DB::table('journal_edition')
            ->select('issue_year')->distinct()->orderby('issue_year')->get();
        return $issue_years;
    }

    static function listYears($journalId)
    {
        //DB::enableQueryLog();
        $issue_years = DB::table('journal_edition')
            ->select('issue_year')->distinct()->where('journal_id', $journalId)->orderby('issue_year')->get();
        //dd(DB::getQueryLog());
        return $issue_years;
    }

    static function listNumbersInYear($prefix, $issueYear)
    {
        $editions = DB::table('journal_edition')
            ->join('journal', 'journal.journal_id', '=', 'journal_edition.journal_id')
            ->where('journal.prefix', $prefix)->where('journal_edition.issue_year', $issueYear)
            ->orderby('number_in_year')->get();
        return $editions;
    }

    static function findByJournalIdAndYearNumber($journalId, $year, $number)
    {
        $journal = DB::table('journal_edition')
            ->where('journal_id', $journalId)
            ->where('issue_year', $year)
            ->where('number_in_year', $number)
            ->get();

        return DaoUtil::returnSingleElement($journal);
    }

    static function findById($id)
    {
        $edition = DB::table('journal_edition')->where('journal_edition_id', $id)->get();

        return DaoUtil::returnSingleElement($edition);
    }

    static function findAll()
    {
        return DB::table('journal_edition')->orderby('journal_id', 'number')->get();
    }

    static function persist($valueObject)
    {
        return DB::table('journal_edition')->insertGetId(get_object_vars($valueObject));
    }
}