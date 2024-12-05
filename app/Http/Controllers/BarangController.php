<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class BarangController extends Controller
{
    public function index(){
        $barangs = DB::select("
        SELECT
            barang.idbarang,
            barang.nama,
            barang.jenis,
            barang.idsatuan,
            barang.status,
            barang.harga,
            GetLatestStock(barang.idbarang) AS stock -- Panggil fungsi GetLatestStock
        FROM
            barang
        ORDER BY
            barang.idbarang
    ");
        return view('barang.index', compact('barangs'));
    }

    public function create(){
        $barangs = DB::select("SELECT * FROM barang");
        $satuans = DB::select("SELECT * FROM satuan WHERE status = 1");
        return view('barang.create', compact('barangs', 'satuans'));
    }

    public function store(Request $request)
    {
        // Panggil Stored Procedure
        DB::statement("CALL InsertBarang(?, ?, ?, ?, ?)", [
            $request->jenis,
            $request->nama,
            $request->idsatuan,
            $request->status,
            $request->harga,
        ]);

        return redirect('/barang');
    }


    public function inactive($id)
    {
        try {
            DB::unprepared("UPDATE barang SET status = 0 WHERE idbarang = ?", [$id]);
            return redirect('/barang')->with('success', 'Barang berhasil dinonaktifkan.');
        } catch (QueryException $e) {
            return redirect('/barang')->with('error', 'Terjadi kesalahan saat menonaktifkan barang.');
        }
    }

    public function inactiveList()
    {
        $barangs = DB::select("SELECT * FROM barang WHERE status = 0");
        return view('barang.inactive', compact('barangs'));
    }

    public function destroy($idbarang)
    {
        // Menghapus satuan berdasarkan ID menggunakan raw query
        DB::statement('DELETE FROM barang WHERE idbarang = ?', [$idbarang]);

        // Redirect ke halaman daftar satuan dengan pesan sukses
        return redirect('/barang')->with('success', 'Barang berhasil dihapus.');
    }

    public function edit($id)
    {
        $barang = DB::selectOne("SELECT * FROM barang WHERE idbarang = ?", [$id]);
        $satuans = DB::select("SELECT * FROM satuan WHERE status = 1");
        return view('barang.edit', compact('barang', 'satuans'));
    }

    public function update(Request $request, $id) {
        DB::unprepared("UPDATE barang SET jenis = ?, nama = ?, idsatuan = ?, status = ?, harga = ? WHERE idbarang = ?", [
            $request->jenis,
            $request->nama,
            $request->idsatuan,
            $request->status,
            $request->harga,
            $id
        ]);

        return redirect('/barang');
    }

    public function active($id)
    {
        try {
            DB::unprepared("UPDATE barang SET status = 1 WHERE idbarang = ?", [$id]);
            return redirect()->route('barang.inactivelist')->with('success', 'Barang berhasil diaktifkan.');
        } catch (QueryException $e) {
            return redirect()->route('barang.inactivelist')->with('error', 'Terjadi kesalahan saat mengaktifkan barang.');
        }
    }
}

