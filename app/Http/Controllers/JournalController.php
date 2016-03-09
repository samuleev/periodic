<?php

namespace App\Http\Controllers;

use App\Dao\JournalDao;
use App\Dao\EditionDao;
use App\Exceptions\NoElementException;
use App\Http\Requests;
use Illuminate\Support\Facades\App;

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
        try {
            $journal = JournalDao::findByPrefix($prefix);
        } catch (NoElementException $e) {
            App::abort(404, 'Journal not found');
        }
        $issueYears = EditionDao::listYears($journal->journal_id);
        return view('journal.details')->with(array('journal' => $journal, 'issueYears' => $issueYears));
    }
}

