<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class BarangController extends Controller
{
    public function index(){

        $barangs = DB::table('data_barang')->where('status_barang', 1)->get();

        return view('barang.index', compact('barangs'));
    }

    public function create(){

        $barangs = DB::table('barang')->get();
        $satuans = DB::table('satuan')->where('status', 1)->get();

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

    public function inactive($id)
    {
        try {
            DB::table('barang')->where('idbarang', $id)->update(['status' => 0]);
            return redirect('/barang')->with('success', 'Barang berhasil dinonaktifkan.');
        } catch (QueryException $e) {
            return redirect('/barang')->with('error', 'Terjadi kesalahan saat menonaktifkan barang.');
        }
    }

    public function inactiveList()
    {
        $barangs = DB::table('data_barang')->where('status_barang', 0)->get();
        
        return view('barang.inactive', compact('barangs'));
    }

    public function destroy($id)
    {
        try{
            // Mencoba menghapus user dengan idrole tertentu
            DB::table('barang')->where('idbarang', $id)->delete();
            return redirect('/barang')->with('success', 'Barang berhasil dihapus!');
        } catch ( QueryException $e ){
            // Redirect dengan pesan sukses jika penghapusan berhasil
            return redirect('/barang')->with('error', 'Barang tidak berhasil dihapus!');
        }
    }

    public function edit($id)
    {
        $barang = DB::table('barang')->where('idbarang', $id)->first();
        $satuans = DB::table('satuan')->where('status', 1)->get();
    
        // Kirim data ke view
        return view('barang.edit', compact('barang', 'satuans'));
    }

    public function update(Request $request, $id) {

        // $request->validate([
        //     'username' => 'required|string|max:255',
        //     'password' => 'required|string|max:255',
        //     'idrole' => 'required|integer|exists:role,idrole', // Pastikan idrole valid
        // ]);
    
        // Update data pengguna
        DB::table('barang')
            ->where('idbarang', $id)
            ->update([
                'jenis' => $request->jenis,
                'nama' => $request->nama,
                'idsatuan'=> $request->idsatuan,
                'status'=> $request->status,
                'harga'=> $request->harga,
            ]);
    
        return redirect('/barang');
    }

    public function active($id)
    {
        try {
            // Ubah status vendor menjadi 1 (aktif)
            DB::table('barang')->where('idbarang', $id)->update(['status' => 1]);
    
            // Redirect ke halaman daftar vendor non-aktif dengan pesan sukses
            return redirect()->route('barang.inactivelist')->with('success', 'Barang berhasil diaktifkan.');
        } catch (QueryException $e) {
            // Redirect dengan pesan error jika terjadi kesalahan
            return redirect()->route('barang.inactivelist')->with('error', 'Terjadi kesalahan saat mengaktifkan barang.');
        }
    }
}
