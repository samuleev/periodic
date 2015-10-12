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

    static function listYears($journalId)
    {
        //DB::enableQueryLog();
        $issue_years = DB::table('journal_edition')
            ->select('issue_year')->distinct()->where('journal_id', $journalId)->orderby('issue_year')->get();
        //dd(DB::getQueryLog());
        return $issue_years;
    }

    static function listNumbersInYear($journalId, $issueYear)
    {
        //DB::enableQueryLog();
        $editions = DB::table('journal_edition')->
        where('journal_id', $journalId)->where('issue_year', $issueYear)->orderby('number_in_year')->get();
        //dd(DB::getQueryLog());
        return $editions;
    }

    static function findById($id)
    {
        $edition = DB::table('journal_edition')->where('journal_edition_id', $id)->get();
        return $edition[0];
    }

    static function findAll()
    {
        return DB::table('journal_edition')->orderby('journal_id', 'number')->get();
    }

    static function persist($valueObject)
    {
        // TODO: Implement persist() method.
    }

    static function update($valueObject)
    {
        // TODO: Implement update() method.
    }

    static function delete($valueObject)
    {
        // TODO: Implement delete() method.
    }
}