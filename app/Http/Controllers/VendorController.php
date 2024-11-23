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
        $vendors = DB::table('vendor')->where('status', 1)->get();
        
        return view('vendor.index', compact('vendors'));
    }

    public function create(){

        $vendors = DB::table('vendor')->get();

        return view('vendor.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        DB::table('vendor')->insert([
            'nama_vendor' => $request->nama_vendor,
            'badan_hukum' => $request->badan_hukum,  
            'status' => $request->status,
        ]);
    
        return redirect('/vendor');
    }


    public function inactive($id)
    {
        try {
            // Ubah status vendor menjadi 0 (non-aktif)
            DB::table('vendor')->where('idvendor', $id)->update(['status' => 0]);
            
            // Redirect kembali ke halaman vendor dengan pesan sukses
            return redirect('/vendor')->with('success', 'Vendor berhasil dinonaktifkan.');
        } catch (QueryException $e) {
            // Redirect dengan pesan error jika terjadi kesalahan
            return redirect('/vendor')->with('error', 'Terjadi kesalahan saat menonaktifkan vendor.');
        }
    }

    public function inactiveList()
    {
        // Ambil data vendor dengan status = 0 (non-aktif)
        $vendors = DB::table('vendor')->where('status', 0)->get();
        
        return view('vendor.inactive', compact('vendors'));
    }

    public function edit($id)
    {
        // Ambil satu data user berdasarkan iduser
        $vendors = DB::table('vendor')->where('idvendor', $id)->first();
    
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
            DB::table('vendor')
                ->where('idvendor', $id)
                ->update([
                    'nama_vendor' => $request->nama_vendor,
                    'badan_hukum' => $request->badan_hukum,
                    'status' => $request->status,
                ]);
    
            // Redirect dengan pesan sukses
            return redirect('/vendor/inactive')->with('success', 'Data vendor berhasil diperbarui.');
    
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return redirect('/vendor/inactive')->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }
    

    public function active($id)
    {
        try {
            // Ubah status vendor menjadi 1 (aktif)
            DB::table('vendor')->where('idvendor', $id)->update(['status' => 1]);
    
            // Redirect ke halaman daftar vendor non-aktif dengan pesan sukses
            return redirect()->route('vendor.inactive.list')->with('success', 'Vendor berhasil diaktifkan.');
        } catch (QueryException $e) {
            // Redirect dengan pesan error jika terjadi kesalahan
            return redirect()->route('vendor.inactive.list')->with('error', 'Terjadi kesalahan saat mengaktifkan vendor.');
        }
    }
}
