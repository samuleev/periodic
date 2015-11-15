<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 15.11.2015
 * Time: 16:25
 */

namespace App\Http\Controllers;

use App\Dao\EditionDao;

class YearController extends Controller
{
    public function index()
    {
        $years = EditionDao::listAllYears();
        return view('year.index')->with(array('years' => $years));
    }
}