<?php

namespace App\Http\Controllers;

use App\Service\ImportService;
use Exception;

class ImportController extends Controller {

    public function import()
    {
        $message = "Import successful";
        try
        {
            ImportService::import();
        } catch (Exception $e) {
            $message = 'Import problem: '. $e->getMessage(). "\n";
        }

        return view('import.main')->with(array('message' => $message));
    }

}