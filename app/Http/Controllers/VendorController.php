<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index(){

        $vendors = DB::table('vendor')->where('status' == 1)->get();
        
        return view('vendor.index', compact('vendors'));
    }

    public function create(){
        return view('vendor.create');
    }
}
