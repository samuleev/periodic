<?php

namespace App\Http\Controllers;

use App\Dao\JournalDao;
use App\Dao\EditionDao;
use App\Service\EditionService;

class EditionController extends Controller {

    public function show($id)
    {
        //use service!
        $edition = EditionService::findById($id);

        return view('edition.details')->with(array('edition' => $edition));
    }

    public function index($journalId, $selectedYear)
    {
        $journal = JournalDao::findById($journalId);
        $issueYears = EditionDao::listYears($journalId);
        $editions = EditionDao::listNumbersInYear($journalId, $selectedYear);
        return view('journal.details')->with(array('journal' => $journal,
            'issueYears' => $issueYears,
            'editions' => $editions));
    }

}