<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function index(){

        $barangs = DB::table('barang')->get();

        return view('pengadaan.index', compact('barangs'));
    }
}
