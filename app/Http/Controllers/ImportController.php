<?php

namespace App\Http\Controllers;

use App\Import\MainImporter;
use Exception;

class ImportController extends Controller {

    public function import()
    {
        $message = "Import successful";
        $trace = null;
        try
        {
            MainImporter::import();
        } catch (Exception $e) {
            $message = 'Import problem: '. $e->getMessage(). "\n";
            $trace = $e->getTraceAsString();
        }

        return view('import.main')->with(array('message' => $message, 'trace' => $trace));
    }

}