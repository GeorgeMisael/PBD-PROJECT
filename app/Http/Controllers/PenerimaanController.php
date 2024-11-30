<?php

namespace App\Http\Controllers;

use id;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idpengadaan' => 'required|exists:pengadaan,idpengadaan',
            'barang' => 'required|array',
            'barang.*.idbarang' => 'required|exists:barang,idbarang',
            'barang.*.jumlah' => 'required|numeric|min:1',
        ]);

        // Simpan data penerimaan baru
        $idpenerimaan = DB::table('penerimaan')->insertGetId([
            'created_at' => now(),
            'status' => 1, // Status default, misal 1 untuk aktif
            'idpengadaan' => $request->idpengadaan,
        ]);

        // Proses data barang
        $barangDiterima = $request->barang;

        foreach ($barangDiterima as $item) {
            // Tambahkan data ke tabel penerimaan
            DB::table('detail_penerimaan')->insert([
                'idpenerimaan' => $idpenerimaan,
                'barang_idbarang' => $item['idbarang'],
                'jumlah_terima' => $item['jumlah'],
                'harga_satuan_terima' => $item['harga_satuan'], // Asumsikan harga_satuan dikirim
                'sub_total_terima' => $item['harga_satuan'] * $item['jumlah'],
            ]);
        }

        return redirect()->route('pengadaan')->with('success', 'Data penerimaan berhasil disimpan!');
    }

}