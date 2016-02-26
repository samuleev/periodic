<?php

namespace App\Http\Controllers;

use App\Dao\JournalDao;
use App\Dao\EditionDao;
use App\Http\Requests;

class JournalController extends Controller
{

    public function root()
    {
        return redirect(route('journal.index'), 301);
    }

    public function index()
    {
        $journals = JournalDao::findAll();
        return view('journal.index', compact('journals'));
    }

    public function show($prefix)
    {
        $journal = JournalDao::findByPrefix($prefix);
        $issueYears = EditionDao::listYears($journal->journal_id);
        return view('journal.details')->with(array('journal' => $journal, 'issueYears' => $issueYears));
    }
}

