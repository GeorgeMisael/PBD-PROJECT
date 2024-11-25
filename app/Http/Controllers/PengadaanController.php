<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function index()
    {
        // Ambil data barang dan satuan dari database
        $barangs = DB::select("SELECT * FROM barang WHERE status = 1");
        $satuans = DB::select("SELECT * FROM satuan WHERE status = 1");
        $vendors = DB::select("SELECT * FROM vendor");

        // Ambil data pengadaan yang sudah ada dalam session
        $dataPengadaan = session('dataPengadaan', []);

        return view('pengadaan.index', [
            'barangs' => $barangs,
            'satuans' => $satuans,
            'vendors' => $vendors,
            'dataPengadaan' => $dataPengadaan,  // Kirim data pengadaan yang disimpan dalam session
        ]);
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idbarang' => 'required|exists:barang,idbarang',
            'jumlah' => 'required|numeric|min:1',
            'idsatuan' => 'required|exists:satuan,idsatuan',  // Validasi idsatuan
        ]);
    
        // Ambil data barang dan satuan berdasarkan input pengguna
        $barang = DB::select("SELECT harga, nama FROM barang WHERE idbarang = ?", [$request->idbarang]);
        $satuan = DB::select("SELECT nama_satuan FROM satuan WHERE idsatuan = ?", [$request->idsatuan]);
    
        if (empty($barang) || empty($satuan)) {
            return redirect()->route('pengadaan')->with('error', 'Barang atau satuan tidak ditemukan!');
        }
    
        // Hitung subtotal
        $subtotal = $barang[0]->harga * $request->jumlah;
    
        // Ambil data pengadaan yang sudah ada dalam session
        $dataPengadaan = session('dataPengadaan', []);
    
        // Tambahkan data pengadaan baru ke dalam array
        $dataPengadaan[] = [
            'idbarang' => $request->idbarang, // Tambahkan key idbarang
            'nama_barang' => $barang[0]->nama,
            'harga' => $barang[0]->harga,
            'jumlah' => $request->jumlah,
            'subtotal' => $subtotal,
            'satuan' => $satuan[0]->nama_satuan,
        ];
    
        // Simpan data pengadaan dalam session
        session(['dataPengadaan' => $dataPengadaan]);
    
        // Redirect kembali ke halaman pengadaan
        return redirect()->route('pengadaan')->with('success', 'Data pengadaan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // Ambil data pengadaan dari session
        $dataPengadaan = session('dataPengadaan', []);

        // Periksa apakah indeks ada di array
        if (isset($dataPengadaan[$id])) {
            // Hapus item dari array
            unset($dataPengadaan[$id]);

            // Reset indeks array untuk mencegah masalah dengan indeks tidak berurutan
            $dataPengadaan = array_values($dataPengadaan);

            // Simpan kembali data pengadaan ke session
            session(['dataPengadaan' => $dataPengadaan]);

            return redirect()->route('pengadaan')->with('success', 'Data pengadaan berhasil dihapus!');
        }

        return redirect()->route('pengadaan')->with('error', 'Data pengadaan tidak ditemukan!');
    }

    public function complete(Request $request)
    {
        // Validasi input
        $request->validate([
            'vendor_idvendor' => 'required|exists:vendor,idvendor', // Validasi id vendor
        ]);
    
        $dataPengadaan = session('dataPengadaan', []);
        $subtotal_nilai = array_sum(array_column($dataPengadaan, 'subtotal')); // Hitung subtotal
        $ppn = $subtotal_nilai * 0.1; // Misal PPN 10%
        $total_nilai = $subtotal_nilai + $ppn;
    
        // Masukkan data ke tabel pengadaan tanpa user_iduser
        DB::insert("INSERT INTO pengadaan (timestamp, status, vendor_idvendor, subtotal_nilai, ppn, total_nilai) VALUES (?, ?, ?, ?, ?, ?)", [
            now(),
            1, 
            $request->vendor_idvendor,
            $subtotal_nilai,
            $ppn,
            $total_nilai,
        ]);


        // Ambil idpengadaan terakhir yang baru saja dimasukkan
        $idpengadaan = DB::getPdo()->lastInsertId();
    
        // Masukkan data ke tabel detail_pengadaan
        foreach ($dataPengadaan as $item) {
            DB::insert("INSERT INTO detail_pengadaan (harga_satuan, jumlah, sub_total, idbarang, idpengadaan) VALUES (?, ?, ?, ?, ?)", [
                $item['harga'],
                $item['jumlah'],
                $item['subtotal'],
                $item['idbarang'], 
                $idpengadaan,
            ]);
        }
    
        // Hapus data pengadaan dari session
        session()->forget('dataPengadaan');
    
        return redirect()->route('pengadaan')->with('success', 'Data pengadaan berhasil disimpan!');
    }
}