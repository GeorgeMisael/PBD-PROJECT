<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class VendorController extends Controller
{
    public function index()
    {
        // Ambil data vendor dengan status = 1 (aktif)
        $vendors = DB::select("SELECT * FROM vendor WHERE status = ?", [1]);
        
        return view('vendor.index', compact('vendors'));
    }

    public function create()
    {
        $vendors = DB::select("SELECT * FROM vendor");

        return view('vendor.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        DB::insert("
            INSERT INTO vendor (nama_vendor, badan_hukum, status) 
            VALUES (?, ?, ?)", 
            [$request->nama_vendor, $request->badan_hukum, $request->status]
        );
    
        return redirect('/vendor');
    }

    public function inactive($id)
    {
        try {
            // Ubah status vendor menjadi 0 (non-aktif)
            DB::update("UPDATE vendor SET status = ? WHERE idvendor = ?", [0, $id]);
            
            return redirect('/vendor')->with('success', 'Vendor berhasil dinonaktifkan.');
        } catch (QueryException $e) {
            return redirect('/vendor')->with('error', 'Terjadi kesalahan saat menonaktifkan vendor.');
        }
    }

    public function inactiveList()
    {
        // Ambil data vendor dengan status = 0 (non-aktif)
        $vendors = DB::select("SELECT * FROM vendor WHERE status = ?", [0]);
        
        return view('vendor.inactive', compact('vendors'));
    }

    public function edit($id)
    {
        // Ambil satu data vendor berdasarkan idvendor
        $result = DB::select("SELECT * FROM vendor WHERE idvendor = ?", [$id]);
    
        // Jika vendor tidak ditemukan, redirect dengan pesan error
        if (empty($result)) {
            return redirect('/vendor')->with('error', 'Vendor tidak ditemukan.');
        }
    
        // Ambil elemen pertama dari hasil query
        $vendors = (object)$result[0];
    
        // Kirim data ke view
        return view('vendor.edit', compact('vendors'));
    }
    

    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'nama_vendor' => 'required|string|max:255',
                'badan_hukum' => 'required|string|max:2',
                'status' => 'required|integer|max:1',
            ]);
    
            // Update data vendor
            DB::update("
                UPDATE vendor 
                SET nama_vendor = ?, badan_hukum = ?, status = ? 
                WHERE idvendor = ?", 
                [$request->nama_vendor, $request->badan_hukum, $request->status, $id]
            );
    
            return redirect('/vendor/inactive')->with('success', 'Data vendor berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect('/vendor/inactive')->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function active($id)
    {
        try {
            // Ubah status vendor menjadi 1 (aktif)
            DB::update("UPDATE vendor SET status = ? WHERE idvendor = ?", [1, $id]);
    
            return redirect()->route('vendor.inactive.list')->with('success', 'Vendor berhasil diaktifkan.');
        } catch (QueryException $e) {
            return redirect()->route('vendor.inactive.list')->with('error', 'Terjadi kesalahan saat mengaktifkan vendor.');
        }
    }
}
