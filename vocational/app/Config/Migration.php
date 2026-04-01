<?php

// vocational/app/Config/Migration.php 

require_once __DIR__ . '/Database.php';

// AMBIL KONEKSI DARI STATIC METHOD
$pdo = Database::getConnection();

// Hash password default admin menggunakan PASSWORD_BCRYPT
$defaultAdminPass = password_hash('admin123', PASSWORD_BCRYPT);

$migrations = [
    // Versi 1.0: Initial Tables
    "CREATE TABLE IF NOT EXISTS mhs_whitelist (
        npm CHAR(10) PRIMARY KEY,
        nama CHAR(100)
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

    // Versi 1.2: Tambah tabel admin_web
    "CREATE TABLE IF NOT EXISTS admin_web (
        id_admin INT AUTO_INCREMENT PRIMARY KEY,
        pw_adm VARCHAR(255) NOT NULL,
        role_adm ENUM('Kaprodi','Advokasi','Super_Admin')
    )",

    // Versi 1.5: Tabel user sessions untuk tracking
    "CREATE TABLE IF NOT EXISTS user_sessions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        npm VARCHAR(10) NOT NULL,
        session_token VARCHAR(255),
        ip_address VARCHAR(45),
        user_agent TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (npm) REFERENCES mhs_whitelist(npm) ON DELETE CASCADE
    )",


    // Versi 1.4: Insert data whitelist
    "INSERT IGNORE INTO mhs_whitelist (npm, nama) VALUES 
        ('2430506056', 'Farrel Apriandry Ciu'), 
        ('2420506026', 'Nofiya Millatina'), 
        ('2420506029', 'Hakkan Azrul Suseno'), 
        ('2420506030', 'Yasabuana Athallahaufa Natawijaya'), 
        ('2430506058', 'Nabila Syafiqah Zahran Firlina')
    ",
];

try {
    echo("\n");
    echo "\n--- Menjalankan Migrasi ---\n";
    
    foreach ($migrations as $index => $sql) {
        try {
            $pdo->exec($sql);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { 
                echo "Step $index skipped (Data sudah ada).\n";
                continue;
            }
            throw $e;
        }
    }
    
    // Insert default admin dengan prepared statement (aman dari SQL injection)
    echo "Step " . count($migrations) . ": Inserting default admin...\n";
    $stmt = $pdo->prepare("INSERT IGNORE INTO admin_web (id_admin, pw_adm, role_adm) VALUES (1, ?, 'Super_Admin')");
    $stmt->execute([$defaultAdminPass]);
    echo "Default admin inserted successfully.\n";

    echo "Database sinkron dengan versi terbaru\n";
} catch (PDOException $e) {
    die("Gagal migrasi: " . $e->getMessage() . "\n");
}