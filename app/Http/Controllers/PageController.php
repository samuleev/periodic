<?php

namespace App\Http\Controllers;

use App\Service\ScholarUpdateService;

class PageController extends Controller {

    public function cooperation()
    {
        return view('page.cooperation');
    }

    public function scholar_update()
    {
        ScholarUpdateService::updateScholar();
    }
}