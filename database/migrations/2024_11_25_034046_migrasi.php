<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Create role table
        DB::unprepared("
            CREATE TABLE role (
                idrole INT PRIMARY KEY AUTO_INCREMENT,
                nama_role VARCHAR(100) NOT NULL
            );
        ");

        // Create user table
        DB::unprepared("
            CREATE TABLE user (
                iduser INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(45) NOT NULL,
                password VARCHAR(100) NOT NULL,
                idrole INT NOT NULL,
                FOREIGN KEY (idrole) REFERENCES role(idrole)
            );
        ");

        // Create satuan table
        DB::unprepared("
            CREATE TABLE satuan (
                idsatuan INT PRIMARY KEY AUTO_INCREMENT,
                nama_satuan VARCHAR(45) NOT NULL,
                status TINYINT NOT NULL DEFAULT 1
            );
        ");

        // Create vendor table
        DB::unprepared("
            CREATE TABLE vendor (
                idvendor INT PRIMARY KEY AUTO_INCREMENT,
                nama_vendor VARCHAR(100) NOT NULL,
                badan_hukum CHAR(1) NOT NULL,
                status CHAR(1) NOT NULL
            );
        ");

        // Create barang table
        DB::unprepared("
            CREATE TABLE barang (
                idbarang INT PRIMARY KEY AUTO_INCREMENT,
                nama VARCHAR(45) NOT NULL,
                jenis CHAR(1) NOT NULL,
                idsatuan INT NOT NULL,
                status TINYINT NOT NULL DEFAULT 1,
                harga INT NOT NULL,
                FOREIGN KEY (idsatuan) REFERENCES satuan(idsatuan)
            );
        ");

        // Create pengadaan table
        DB::unprepared("
            CREATE TABLE pengadaan (
                idpengadaan INT PRIMARY KEY AUTO_INCREMENT,
                timestamp TIMESTAMP,
                user_iduser INT,
                status CHAR(1),
                vendor_idvendor INT,
                subtotal_nilai INT,
                ppn INT,
                total_nilai INT,
                FOREIGN KEY (user_iduser) REFERENCES user(iduser),
                FOREIGN KEY (vendor_idvendor) REFERENCES vendor(idvendor)
            );
        ");

        // Create detail_pengadaan table
        DB::unprepared("
            CREATE TABLE detail_pengadaan (
                iddetail_pengadaan INT PRIMARY KEY AUTO_INCREMENT,
                harga_satuan INT NOT NULL,
                jumlah INT NOT NULL,
                sub_total INT NOT NULL,
                idbarang INT NOT NULL,
                idpengadaan INT NOT NULL,
                FOREIGN KEY (idbarang) REFERENCES barang(idbarang),
                FOREIGN KEY (idpengadaan) REFERENCES pengadaan(idpengadaan)
            );
        ");

        // Create penerimaan table
        DB::unprepared("
            CREATE TABLE penerimaan (
                idpenerimaan BIGINT PRIMARY KEY AUTO_INCREMENT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                status CHAR(1) NOT NULL,
                idpengadaan INT NOT NULL,
                iduser INT NOT NULL,
                FOREIGN KEY (idpengadaan) REFERENCES pengadaan(idpengadaan),
                FOREIGN KEY (iduser) REFERENCES user(iduser)
            );
        ");

        // Create detail_penerimaan table
        DB::unprepared("
            CREATE TABLE detail_penerimaan (
                iddetail_penerimaan BIGINT PRIMARY KEY,
                idpenerimaan BIGINT,
                barang_idbarang INT,
                jumlah_terima INT,
                harga_satuan_terima INT,
                sub_total_terima INT,
                FOREIGN KEY (idpenerimaan) REFERENCES penerimaan(idpenerimaan),
                FOREIGN KEY (barang_idbarang) REFERENCES barang(idbarang)
            );
        ");

        // Create kartu_stok table
        DB::unprepared("
            CREATE TABLE kartu_stok (
                idkartu_stok BIGINT PRIMARY KEY AUTO_INCREMENT,
                jenis_transaksi CHAR(1) NOT NULL,
                masuk INT NOT NULL DEFAULT 0,
                keluar INT NOT NULL DEFAULT 0,
                stock INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                idtransaksi INT NOT NULL,
                idbarang INT NOT NULL,
                FOREIGN KEY (idbarang) REFERENCES barang(idbarang)
            );
        ");

        // Create margin_penjualan table
        DB::unprepared("
            CREATE TABLE margin_penjualan (
                idmargin_penjualan INT PRIMARY KEY,
                created_at TIMESTAMP,
                persen DOUBLE,
                status TINYINT,
                iduser INT,
                updated_at TIMESTAMP,
                FOREIGN KEY (iduser) REFERENCES user(iduser)
            );
        ");

        // Create penjualan table
        DB::unprepared("
            CREATE TABLE penjualan (
                idpenjualan INT AUTO_INCREMENT PRIMARY KEY,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                subtotal_nilai INT NOT NULL,
                ppn INT NOT NULL,
                total_nilai INT NOT NULL,
                iduser INT NOT NULL,
                idmargin_penjualan INT NOT NULL,
                FOREIGN KEY (iduser) REFERENCES user(iduser),
                FOREIGN KEY (idmargin_penjualan) REFERENCES margin_penjualan(idmargin_penjualan)
            );
        ");

        // Create detail_penjualan table
        DB::unprepared("
            CREATE TABLE detail_penjualan (
                iddetail_penjualan BIGINT PRIMARY KEY AUTO_INCREMENT,
                harga_satuan INT NOT NULL,
                jumlah INT NOT NULL,
                subtotal INT NOT NULL,
                penjualan_idpenjualan INT NOT NULL,
                idbarang INT NOT NULL,
                FOREIGN KEY (penjualan_idpenjualan) REFERENCES penjualan(idpenjualan),
                FOREIGN KEY (idbarang) REFERENCES barang(idbarang)
            );
        ");

        // Create retur table
        DB::unprepared("
            CREATE TABLE retur (
                idretur BIGINT PRIMARY KEY AUTO_INCREMENT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                idpenerimaan BIGINT NOT NULL,
                iduser INT NOT NULL,
                FOREIGN KEY (idpenerimaan) REFERENCES penerimaan(idpenerimaan),
                FOREIGN KEY (iduser) REFERENCES user(iduser)
            );
        ");

        // Create detail_retur table
        DB::unprepared("
            CREATE TABLE detail_retur (
                iddetail_retur INT PRIMARY KEY AUTO_INCREMENT,
                jumlah INT NOT NULL,
                alasan VARCHAR(200) NOT NULL,
                idretur BIGINT NOT NULL,
                iddetail_penerimaan BIGINT NOT NULL,
                FOREIGN KEY (idretur) REFERENCES retur(idretur),
                FOREIGN KEY (iddetail_penerimaan) REFERENCES detail_penerimaan(iddetail_penerimaan)
            );
        ");

        // Create triggers for stock management
        DB::unprepared("
            CREATE TRIGGER after_penerimaan_insert AFTER INSERT ON detail_penerimaan
            FOR EACH ROW
            BEGIN
                INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, idtransaksi, idbarang)
                SELECT 'M', NEW.jumlah_terima, 0, 
                    COALESCE((SELECT stock FROM kartu_stok WHERE idbarang = NEW.barang_idbarang ORDER BY idkartu_stok DESC LIMIT 1), 0) + NEW.jumlah_terima,
                    NEW.iddetail_penerimaan, NEW.barang_idbarang;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER after_penjualan_insert AFTER INSERT ON detail_penjualan
            FOR EACH ROW
            BEGIN
                INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, idtransaksi, idbarang)
                SELECT 'K', 0, NEW.jumlah,
                    COALESCE((SELECT stock FROM kartu_stok WHERE idbarang = NEW.idbarang ORDER BY idkartu_stok DESC LIMIT 1), 0) - NEW.jumlah,
                    NEW.iddetail_penjualan, NEW.idbarang;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER after_retur_insert AFTER INSERT ON detail_retur
            FOR EACH ROW
            BEGIN
                INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, idtransaksi, idbarang)
                SELECT 'R', 0, dr.jumlah,
                    COALESCE((SELECT stock FROM kartu_stok WHERE idbarang = dp.barang_idbarang ORDER BY idkartu_stok DESC LIMIT 1), 0) - dr.jumlah,
                    NEW.iddetail_retur, dp.barang_idbarang
                FROM detail_retur dr
                JOIN detail_penerimaan dp ON dr.iddetail_penerimaan = dp.iddetail_penerimaan
                WHERE dr.iddetail_retur = NEW.iddetail_retur;
            END;
        ");
    }

    public function down()
    {
        // Drop tables in reverse order
        DB::unprepared("
            DROP TRIGGER IF EXISTS after_retur_insert;
            DROP TRIGGER IF EXISTS after_penjualan_insert;
            DROP TRIGGER IF EXISTS after_penerimaan_insert;
            DROP TABLE IF EXISTS detail_retur;
            DROP TABLE IF EXISTS retur;
            DROP TABLE IF EXISTS detail_penjualan;
            DROP TABLE IF EXISTS margin_penjualan;
            DROP TABLE IF EXISTS penjualan;
            DROP TABLE IF EXISTS kartu_stok;
            DROP TABLE IF EXISTS detail_penerimaan;
            DROP TABLE IF EXISTS penerimaan;
            DROP TABLE IF EXISTS detail_pengadaan;
            DROP TABLE IF EXISTS pengadaan;
            DROP TABLE IF EXISTS barang;
            DROP TABLE IF EXISTS vendor;
            DROP TABLE IF EXISTS satuan;
            DROP TABLE IF EXISTS user;
            DROP TABLE IF EXISTS role;
        ");
    }
};

