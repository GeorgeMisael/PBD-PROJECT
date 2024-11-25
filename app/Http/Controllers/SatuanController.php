<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class SatuanController extends Controller
{
    public function index()
    {
        // Ambil data satuan dengan status = 1 (aktif)
        $satuans = DB::select("SELECT * FROM satuan WHERE status = ?", [1]);

        return view('satuan.index', compact('satuans'));
    }

    public function create()
    {
        // Ambil semua data satuan
        $satuans = DB::select("SELECT * FROM satuan");

        return view('satuan.create', compact('satuans'));
    }

    public function store(Request $request)
    {
        // Insert data baru ke tabel satuan
        DB::insert("
            INSERT INTO satuan (nama_satuan, status) 
            VALUES (?, ?)", 
            [$request->nama_satuan, $request->status]
        );

        return redirect('/satuan');
    }

    public function inactive($id)
    {
        try {
            // Ubah status satuan menjadi 0 (non-aktif)
            DB::update("UPDATE satuan SET status = ? WHERE idsatuan = ?", [0, $id]);

            return redirect('/satuan')->with('success', 'Satuan berhasil dinonaktifkan.');
        } catch (QueryException $e) {
            return redirect('/satuan')->with('error', 'Terjadi kesalahan saat menonaktifkan satuan.');
        }
    }

    public function inactiveList()
    {
        // Ambil data satuan dengan status = 0 (non-aktif)
        $satuans = DB::select("SELECT * FROM satuan WHERE status = ?", [0]);

        return view('satuan.inactive', compact('satuans'));
    }

    public function edit($id)
    {
        // Ambil satu data satuan berdasarkan idsatuan
        $result = DB::select("SELECT * FROM satuan WHERE idsatuan = ?", [$id]);

        // Jika data tidak ditemukan, redirect dengan pesan error
        if (empty($result)) {
            return redirect('/satuan')->with('error', 'Satuan tidak ditemukan.');
        }

        // Ambil elemen pertama dari hasil query
        $satuans = (object)$result[0];

        return view('satuan.edit', compact('satuans'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'nama_satuan' => 'required|string|max:255',
                'status' => 'required|integer|max:1',
            ]);

            // Update data satuan
            DB::update("
                UPDATE satuan 
                SET nama_satuan = ?, status = ? 
                WHERE idsatuan = ?", 
                [$request->nama_satuan, $request->status, $id]
            );

            return redirect('/satuan/inactive')->with('success', 'Data satuan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect('/satuan/inactive')->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function active($id)
    {
        try {
            // Ubah status satuan menjadi 1 (aktif)
            DB::update("UPDATE satuan SET status = ? WHERE idsatuan = ?", [1, $id]);

            return redirect()->route('satuan.inactive.list')->with('success', 'Satuan berhasil diaktifkan.');
        } catch (QueryException $e) {
            return redirect()->route('satuan.inactive.list')->with('error', 'Terjadi kesalahan saat mengaktifkan satuan.');
        }
    }
}
