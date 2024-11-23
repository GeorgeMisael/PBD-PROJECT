<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(){

        $barangs = DB::table('data_barang')->get();

        return view('barang.index', compact('barangs'));
    }

    public function create(){

        $barangs = DB::table('barang')->get();
        $satuans = DB::table('satuan')->get();

        return view('barang.create', compact('barangs', 'satuans')); 
    }

    public function store(Request $request)
    {

        // $request->validate([
        //     'username' => 'required|string|max:255',
        //     'password' => 'required|string|min:6',
        //     'idrole'   => 'required|exists:role,idrole',
        // ]);

        DB::table('barang')->insert([
            'jenis' => $request->jenis,
            'nama' => $request->nama,
            'idsatuan'=> $request->idsatuan,
            'status'=> $request->status,
            'harga'=> $request->harga,
        ]);
    
        return redirect('/barang');

    }

}
