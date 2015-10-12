<?php

namespace App\Http\Controllers;

use App\Dao\JournalDao;
use App\Dao\EditionDao;
use Illuminate\Http\Request;
use App\Http\Requests;

class JournalController extends Controller
{
    public function index()
    {
        $journals = JournalDao::findAll();
        return view('journal.index', compact('journals'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $journal = JournalDao::findById($id);
        $issueYears = EditionDao::listYears($id);
        return view('journal.details')->with(array('journal' => $journal, 'issueYears' => $issueYears));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

