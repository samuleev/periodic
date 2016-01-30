<?php

namespace App\Http\Controllers;

use App\Referat\ReferatImporter;
use Exception;

class ReferatController extends Controller {
    public function import()
    {
        $message = "Import successful";
        $trace = null;
        try
        {
            ReferatImporter::import();
        } catch (Exception $e) {
            $message = 'Import problem: '. $e->getMessage(). "\n";
            $trace = $e->getTraceAsString();
        }

        return view('import.main')->with(array('message' => $message, 'trace' => $trace));
    }
}