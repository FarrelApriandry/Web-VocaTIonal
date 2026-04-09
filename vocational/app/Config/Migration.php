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
        npm VARCHAR(10) PRIMARY KEY,
        nama VARCHAR(100)
    )",
    
    // Versi 1.0: Tabel aspirasi
    "CREATE TABLE IF NOT EXISTS aspirasi (
        id_aspirasi INT AUTO_INCREMENT PRIMARY KEY,
        npm_pelapor VARCHAR(10),
        judul VARCHAR(255),
        deskripsi TEXT,
        kategori ENUM('Akademik', 'Fasilitas', 'Sarpras', 'Layanan', 'UKT', 'Lainnya'),
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
        admin_id INT AUTO_INCREMENT PRIMARY KEY,
        usn_adm VARCHAR(50) NOT NULL UNIQUE,
        pw_adm VARCHAR(255) NOT NULL,
        role_adm ENUM('Kaprodi','Advokasi','Admin')
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

    // Versi 2.0: Add bulletin board fields to aspirasi
    "ALTER TABLE aspirasi ADD COLUMN show_on_board BOOLEAN DEFAULT FALSE",
    "ALTER TABLE aspirasi ADD COLUMN board_approved BOOLEAN DEFAULT FALSE",

    // Versi 2.1: Tabel aspirasi reactions (likes)
    "CREATE TABLE IF NOT EXISTS aspirasi_reactions (
        id_reaction INT AUTO_INCREMENT PRIMARY KEY,
        id_aspirasi INT NOT NULL,
        npm_reactor VARCHAR(15) NOT NULL,
        reaction_type VARCHAR(50) DEFAULT 'like',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_aspirasi) REFERENCES aspirasi(id_aspirasi) ON DELETE CASCADE,
        FOREIGN KEY (npm_reactor) REFERENCES mhs_whitelist(npm) ON DELETE CASCADE,
        UNIQUE KEY unique_reaction (id_aspirasi, npm_reactor)
    )",

    // Versi 2.2: Tabel aspirasi reports
    "CREATE TABLE IF NOT EXISTS aspirasi_reports (
        id_report INT AUTO_INCREMENT PRIMARY KEY,
        id_aspirasi INT NOT NULL,
        npm_reporter VARCHAR(15) NOT NULL,
        reason ENUM('inappropriate', 'spam', 'offensive') DEFAULT 'inappropriate',
        message TEXT,
        status ENUM('pending', 'reviewed') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_aspirasi) REFERENCES aspirasi(id_aspirasi) ON DELETE CASCADE,
        FOREIGN KEY (npm_reporter) REFERENCES mhs_whitelist(npm) ON DELETE CASCADE
    )",

    // Versi 2.3: Modify kategori ENUM - add Sarpras & Layanan
    "ALTER TABLE aspirasi MODIFY COLUMN kategori ENUM('Akademik', 'Fasilitas', 'Sarpras', 'Layanan', 'UKT', 'Lainnya')",

    // Versi 2.4: Auto-approve aspirasi untuk testing (production: needs manual approval)
    "UPDATE aspirasi SET board_approved = 1 WHERE show_on_board = 1 AND board_approved = 0",

    // Versi 3.0: Update aspirasi_reports status ENUM untuk reporting system
    "ALTER TABLE aspirasi_reports MODIFY COLUMN status ENUM('pending', 'confirmed', 'processing', 'resolved', 'dismissed') DEFAULT 'pending'",

    // Versi 3.1: Add timestamps untuk tracking status changes
    "ALTER TABLE aspirasi_reports ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",

    // Versi 1.4: Insert default admin & whitelist with default hashing password php (PASSWORD_BCRYPT)
    "INSERT IGNORE INTO admin_web (admin_id, usn_adm, pw_adm, role_adm) VALUES (1, 'admin-prod', '" . $defaultAdminPass . "', 'Admin')",

    // Versi 1.4: Insert data whitelist
    "INSERT IGNORE INTO mhs_whitelist (npm, nama) VALUES 
        ('2430506056', 'Farrel Apriandry Ciu'), 
        ('2420506026', 'Nofiya Millatina'), 
        ('2420506029', 'Hakkan Azrul Suseno'), 
        ('2420506030', 'Yasabuana Athallahaufa Natawijaya'), 
        ('2430506058', 'Nabila Syafiqah Zahran Firlina'),
        ('2410506016', 'Dzakii Luqman Faid'),
        ('2420506047', 'Muhammad Asyrof'),
        ('2410506001', 'Julioez Candita Haga Figo Latupeirissa')
    ",

    // Versi 2.5: Insert anonim record for anonymized aspirations
    "INSERT IGNORE INTO mhs_whitelist (npm, nama) VALUES ('anonim', 'anonim')",
];

try {
    echo("\n");
    echo "\n--- Menjalankan Migrasi ---\n";
    
    foreach ($migrations as $index => $sql) {
        try {
            $pdo->exec($sql);
            echo "Step $index executed successfully.\n";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { 
                echo "Step $index skipped (Data sudah ada).\n";
                continue;
            }
            // Handle column already exists error (1060)
            if (strpos($e->getMessage(), '1060') !== false || strpos($e->getMessage(), 'Duplicate column') !== false) {
                echo "Step $index skipped (Column sudah ada).\n";
                continue;
            }
            throw $e;
        }
    }

    echo "Database sinkron dengan versi terbaru\n";
} catch (PDOException $e) {
    die("Gagal migrasi: " . $e->getMessage() . "\n");
}