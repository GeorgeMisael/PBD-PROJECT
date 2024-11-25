<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function index()
    {
        // Ambil data barang dan satuan dari database
        $barangs = DB::table('barang')->where('status', 1)->get();
        $satuans = DB::table('satuan')->where('status', 1)->get();

        return view('pengadaan.index', [
            'barangs' => $barangs,
            'satuans' => $satuans,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idbarang' => 'required|exists:barang,idbarang',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $barang = DB::table('barang')->where('idbarang', $request->idbarang)->first();
        $subtotal = $barang->harga * $request->jumlah;

        return redirect()->route('pengadaan')->with('success', 'Data pengadaan berhasil ditambahkan!');
    }
}
