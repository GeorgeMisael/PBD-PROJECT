<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class SatuanController extends Controller
{
    public function index(){
        $satuans = DB::table('satuan')->where('status', 1)->get();

        return view('satuan.index', compact('satuans'));
    }

    public function create(){

        $satuans = DB::table('satuan')->get();

        return view('satuan.create', compact('satuans'));
    }

    public function store(Request $request)
    {
        DB::table('satuan')->insert([
            'nama_satuan' => $request->nama_satuan, 
            'status' => $request->status,
        ]);
    
        return redirect('/satuan');
    }

    public function inactive($id)
    {
        try {
            // Ubah status vendor menjadi 0 (non-aktif)
            DB::table('satuan')->where('idsatuan', $id)->update(['status' => 0]);
            
            // Redirect kembali ke halaman vendor dengan pesan sukses
            return redirect('/satuan')->with('success', 'Vendor berhasil dinonaktifkan.');
        } catch (QueryException $e) {
            // Redirect dengan pesan error jika terjadi kesalahan
            return redirect('/satuan')->with('error', 'Terjadi kesalahan saat menonaktifkan vendor.');
        }
    }

    public function inactiveList()
    {
        // Ambil data vendor dengan status = 0 (non-aktif)
        $satuans = DB::table('satuan')->where('status', 0)->get();
        
        return view('satuan.inactive', compact('satuans'));
    }

    public function edit($id)
    {
        // Ambil satu data satuan berdasarkan iduser
        $satuans = DB::table('satuan')->where('idsatuan', $id)->first();
    
        // Kirim data ke view
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
    
            // Update data vendor
            DB::table('satuan')
                ->where('idsatuan', $id)
                ->update([
                    'nama_satuan' => $request->nama_satuan,
                    'status' => $request->status,
                ]);
    
            // Redirect dengan pesan sukses
            return redirect('/satuan/inactive')->with('success', 'Data satuan berhasil diperbarui.');
    
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return redirect('/satuan/inactive')->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function active($id)
    {
        try {
            // Ubah status vendor menjadi 1 (aktif)
            DB::table('satuan')->where('idsatuan', $id)->update(['status' => 1]);
    
            // Redirect ke halaman daftar satuan non-aktif dengan pesan sukses
            return redirect()->route('satuan.inactive.list')->with('success', 'Satuan berhasil diaktifkan.');
        } catch (QueryException $e) {
            // Redirect dengan pesan error jika terjadi kesalahan
            return redirect()->route('satuan.inactive.list')->with('error', 'Terjadi kesalahan saat mengaktifkan satuan.');
        }
    }
    
}
