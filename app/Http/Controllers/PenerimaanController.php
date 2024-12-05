<?php

namespace App\Http\Controllers;

use id;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function create($idPengadaan)
{
    // Ambil data barang pengadaan
    $barangPengadaan = DB::select("
    SELECT
        dp.idbarang,
        b.nama AS nama_barang,
        dp.jumlah AS jumlah_pesan,
        b.harga,
        COALESCE(SUM(
            CASE WHEN p.idpengadaan = ? THEN dpr.jumlah_terima ELSE 0 END
        ), 0) AS total_terima
    FROM
        detail_pengadaan dp
    LEFT JOIN detail_penerimaan dpr ON dp.idbarang = dpr.barang_idbarang
    LEFT JOIN penerimaan p ON dpr.idpenerimaan = p.idpenerimaan
    JOIN barang b ON dp.idbarang = b.idbarang
    WHERE
        dp.idpengadaan = ?
    GROUP BY
        dp.idbarang, b.nama, dp.jumlah, b.harga
", [$idPengadaan, $idPengadaan]);



    // Hitung kolom sisa untuk setiap barang
    foreach ($barangPengadaan as &$barang) {
        $barang->sisa = $barang->jumlah_pesan - $barang->total_terima;
    }

    // Ambil history penerimaan
    $historyPenerimaan = DB::select("
        SELECT
            p.idpenerimaan,
            p.created_at,
            dp.barang_idbarang,
            b.nama AS nama_barang,
            dp.jumlah_terima,
            dp.harga_satuan_terima,
            dp.sub_total_terima
        FROM
            penerimaan p
        JOIN
            detail_penerimaan dp ON p.idpenerimaan = dp.idpenerimaan
        JOIN
            barang b ON dp.barang_idbarang = b.idbarang
        WHERE
            p.idpengadaan = ?
        ORDER BY
            p.created_at DESC
    ", [$idPengadaan]);

    return view('penerimaan.create', compact('barangPengadaan', 'idPengadaan', 'historyPenerimaan'));
}

    public function store(Request $request)
    {
        $idPengadaan = $request->input('id_pengadaan');
        $item = $request->input('detail_penerimaan'); // Data satu barang

        // Validasi input
        if (!isset($item['idbarang'], $item['jumlah_terima'], $item['harga_satuan'])) {
            return redirect()->back()->withErrors(['error' => 'Data barang tidak lengkap.']);
        }

        $idBarang = $item['idbarang'];
        $jumlahTerima = (int)$item['jumlah_terima'];
        $hargaSatuan = (int)$item['harga_satuan'];

        // Ambil data barang pengadaan termasuk total diterima
        $barangPengadaan = DB::selectOne("
            SELECT
                dp.idbarang,
                dp.jumlah AS jumlah_pesan,
                COALESCE(SUM(dpr.jumlah_terima), 0) AS total_terima
            FROM
                detail_pengadaan dp
            LEFT JOIN detail_penerimaan dpr ON dp.idbarang = dpr.barang_idbarang
                AND dpr.idpenerimaan IN (
                    SELECT p.idpenerimaan
                    FROM penerimaan p
                    WHERE p.idpengadaan = ?
                )
            WHERE
                dp.idbarang = ? AND dp.idpengadaan = ?
            GROUP BY dp.idbarang, dp.jumlah
        ", [$idPengadaan, $idBarang, $idPengadaan]);

        if (!$barangPengadaan) {
            return redirect()->back()->withErrors(['error' => 'Barang tidak ditemukan dalam pengadaan.']);
        }

        $sisa = $barangPengadaan->jumlah_pesan - $barangPengadaan->total_terima;

        // Validasi sisa
        if ($jumlahTerima > $sisa) {
            return redirect()->back()->withErrors(['error' => 'Jumlah terima melebihi sisa untuk barang ID ' . $idBarang]);
        }

        if ($jumlahTerima <= 0) {
            return redirect()->back()->withErrors(['error' => 'Jumlah terima harus lebih dari 0.']);
        }


        $idUser = $request->input('iduser'); // Ambil dari form input

        // Validasi jika iduser tidak ditemukan
        if (!$idUser) {
            return redirect()->back()->withErrors(['error' => 'ID User tidak ditemukan.']);
        }
        // Insert penerimaan header
        $idPenerimaan = DB::table('penerimaan')->insertGetId([
            'created_at' => now(),
            'status' => '0',
            'idpengadaan' => $idPengadaan,
            'iduser' => $idUser // Asumsikan iduser disimpan di session
        ]);

        // Insert detail penerimaan
        DB::table('detail_penerimaan')->insert([
            'idpenerimaan' => $idPenerimaan,
            'barang_idbarang' => $idBarang,
            'jumlah_terima' => $jumlahTerima,
            'harga_satuan_terima' => $hargaSatuan,
            'sub_total_terima' => $jumlahTerima * $hargaSatuan
        ]);

        // Cek apakah semua barang telah diterima
        $totalBarang = DB::selectOne("
    SELECT
        (SELECT SUM(jumlah) FROM detail_pengadaan WHERE idpengadaan = ?) AS total_pesan,
        COALESCE(SUM(dpr.jumlah_terima), 0) AS total_diterima
    FROM
        detail_pengadaan dp
    LEFT JOIN detail_penerimaan dpr ON dp.idbarang = dpr.barang_idbarang
        AND dpr.idpenerimaan IN (
            SELECT p.idpenerimaan
            FROM penerimaan p
            WHERE p.idpengadaan = ?
        )
    WHERE dp.idpengadaan = ?
", [$idPengadaan, $idPengadaan, $idPengadaan]);


        if ($totalBarang->total_pesan == $totalBarang->total_diterima) {
            // Update status pengadaan menjadi selesai (1)
            DB::table('pengadaan')->where('idpengadaan', $idPengadaan)->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Penerimaan berhasil ditambahkan.');
    }

    public function history()
{
    $historyPenerimaan = DB::select("
        SELECT
            p.idpenerimaan,
            p.created_at AS tanggal_penerimaan,
            dp.barang_idbarang,
            b.nama AS nama_barang,
            dp.jumlah_terima,
            dp.harga_satuan_terima,
            dp.sub_total_terima,
            v.nama_vendor,
            pg.idpengadaan,
            u.username AS nama_user
        FROM
            penerimaan p
        JOIN
            detail_penerimaan dp ON p.idpenerimaan = dp.idpenerimaan
        JOIN
            barang b ON dp.barang_idbarang = b.idbarang
        JOIN
            pengadaan pg ON p.idpengadaan = pg.idpengadaan
        JOIN
            vendor v ON pg.vendor_idvendor = v.idvendor
        JOIN
            user u ON p.iduser = u.iduser
        ORDER BY
            p.created_at DESC
    ");

    return view('penerimaan.historypenerimaan', compact('historyPenerimaan'));
}

}
