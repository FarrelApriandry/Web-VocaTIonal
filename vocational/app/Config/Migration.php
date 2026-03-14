<?php

// vocational/app/Config/Migration.php 

require_once __DIR__ . '/Database.php';

// AMBIL KONEKSI DARI STATIC METHOD
$pdo = Database::getConnection();

$migrations = [
    // Versi 1.0: Initial Tables
    "CREATE TABLE IF NOT EXISTS mhs_whitelist (
        npm VARCHAR(15) PRIMARY KEY,
        nama VARCHAR(100)
    )",
    
    // Versi 1.0: Tabel aspirasi
    "CREATE TABLE IF NOT EXISTS aspirasi (
        id_aspirasi INT AUTO_INCREMENT PRIMARY KEY,
        npm_pelapor VARCHAR(15),
        judul VARCHAR(255),
        deskripsi TEXT,
        kategori ENUM('Akademik', 'Fasilitas', 'UKT', 'Lainnya'),
        status ENUM('Pending', 'Proses', 'Selesai') DEFAULT 'Pending',
        anonim BOOLEAN,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (npm_pelapor) REFERENCES mhs_whitelist(npm)
    )",

    // Versi 1.1: Tambah tabel tanggapan
    "CREATE TABLE IF NOT EXISTS tanggapan (
        id_tanggapan INT AUTO_INCREMENT PRIMARY KEY,
        id_aspirasi INT,
        isi_tanggapan TEXT,
        admin_id INT,
        FOREIGN KEY (id_aspirasi) REFERENCES aspirasi(id_aspirasi) ON DELETE CASCADE
    )",

    "CREATE TABLE IF NOT EXISTS admin_web (
        id_admin INT AUTO_INCREMENT PRIMARY KEY,
        pw_adm VARCHAR(30) NOT NULL,
        role_adm ENUM('Kaprodi','Advokasi','Super_Admin')
        )"
]

try {
    echo("\n");
    echo "\n--- Menjalankan Migrasi ---\n";
    
    foreach ($migrations as $sql) {
        $pdo->exec($sql);
    }
    echo "Database sinkron dengan versi terbaru\n";
} catch (PDOException $e) {
    die("Gagal migrasi: " . $e->getMessage() . "\n");
}