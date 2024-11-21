<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KartuStokController extends Controller
{
    public function index(){
        return view('kartustok.index');
    }
}
