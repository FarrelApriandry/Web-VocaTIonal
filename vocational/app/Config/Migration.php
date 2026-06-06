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
        ('2410506001', 'Julioez Candita Haga Figo Latupeirissa'),
        ('2410506002', 'Nawang Riyana Putri'),
        ('2410506003', 'Kartika Salsabila'),
        ('2410506004', 'Apfia Dian Setianingrum'),
        ('2410506005', 'David Nazal Farihin'),
        ('2410506006', 'Muhammad Yogi Istianto Wibowo'),
        ('2410506007', 'Ferdiyanto'),
        ('2410506008', 'Rahma Dwi Kartika Sari'),
        ('2410506009', 'Rayfal Mayvandra Aurora Akbar'),
        ('2410506010', 'Fadlika Alfi Nurrochmah'),
        ('2410506011', 'Setiasih'),
        ('2410506012', 'Nadhifatus Zalfa Az Zanirah'),
        ('2410506013', 'Septiana Diyah Ayu Wulandari'),
        ('2410506014', 'Ida Ayu Sita Maheswari Arianti'),
        ('2410506015', 'Evellyn Liena'),
        ('2420506017', 'Muhammad Abdillah Aziz'),
        ('2420506018', 'Hammam Al Rosyid Mudhoffar'),
        ('2420506019', 'Salwa Fijri Rahayu'),
        ('2420506020', 'Akmal Firdaus'),
        ('2420506021', 'Kanahaya Meilia Sakti'),
        ('2420506022', 'Faiz Difa Kurniawan'),
        ('2420506023', 'Azzahra Febia Mufida'),
        ('2420506024', 'Zahra Nibras Hanilatifa'),
        ('2420506025', 'Achmad Chanif Rahmatullah'),
        ('2420506027', 'Muhammad Ramdhan'),
        ('2420506028', 'Assep Wahid'),
        ('2420506031', 'Aldian Setyo Nugroho'),
        ('2420506032', 'Ronald Zuni Bachtiar'),
        ('2420506033', 'Mayza Lutfi Setyaji'),
        ('2420506034', 'Lu''luatina Zakiyatal Fikri'),
        ('2420506035', 'Ilyasa Abiyyu Wicaksono'),
        ('2430506050', 'Senandung Marimby Zahira Malika'),
        ('2430506057', 'Zurich Sabil'),
        ('2430506067', 'Erlyn Nur Rizqi Maulidya'),
        ('2420506036', 'Zulfa Nashihin'),
        ('2420506037', 'Aditya Setyo Prabowo'),
        ('2420506038', 'Rasyad Lintang Wahyunindar'),
        ('2420506039', 'Yofi Widiyanto'),
        ('2420506040', 'Novela Eka Saputri'),
        ('2420506041', 'Hanif Abdillah Alatas'),
        ('2420506042', 'Falikha Sulfiyah'),
        ('2420506043', 'Gayuh Senoaji'),
        ('2420506044', 'Muhammad Fikrie Ath Thahiru'),
        ('2420506045', 'Salwa Aurelia'),
        ('2420506046', 'Bagus Mukhammad Muslim'),
        ('2420506048', 'Muhammad Dafa Falah Labib'),
        ('2440506049', 'Filbert Wibowo'),
        ('2440506051', 'Ahmad Syauqy Wardani'),
        ('2440506052', 'Nayla Izza Arzatie'),
        ('2440506053', 'Muhammad Andra Firdaus'),
        ('2440506054', 'Widyadana Hussin Firmansyah'),
        ('2440506055', 'Zulfikar Akbar'),
        ('2440506059', 'Navista Andara Putri'),
        ('2440506060', 'Naufal Miftakhul Siddiq'),
        ('2440506061', 'Rino Ahmad Raga'),
        ('2440506062', 'Muhammad Amsyal Ikhsan'),
        ('2440506063', 'Satrio Putro Utomo'),
        ('2440506064', 'Shofwan Syamil Asysyauqy'),
        ('2440506065', 'Ines Anindiyta'),
        ('2440506066', 'Ilham Khalid Putra Ambalan'),
        ('2440506068', 'Galang Ahmad Ghifari'),
        ('2440506069', 'Ahmada Nur Maulana Bafakih'),
        ('2440506070', 'Muhammad Ardine Icasia'),
        ('2440506071', 'Nadine Rachma Wijaya'),
        ('2440506072', 'Akhnaz Malik Firmansyah'),
        ('2440506073', 'Muafifi Daffa Firmansyah'),
        ('2440506074', 'Jabbar Hakim'),
        ('2440506075', 'Robby Ade Pratama'),
        ('2440506076', 'Tio Restu Pambudi'),
        ('2440506077', 'Aulia Nidya Kusuma Dewati'),
        ('2440506078', 'Galang Dwi Santoso'),
        ('2440506079', 'Muhamad Ridwansah');

        -- ('2505060001', 'Albani Hafiz Innopha'),
        -- ('2505060002', 'Oktarina Putri'),
        -- ('2505060003', 'Poppy Fridayana'),
        -- ('2505060004', 'Erny Kurniawati'),
        -- ('2505060005', 'Rayhan Aditya Putra'),
        -- ('2505060006', 'Vandra Noprianus Sembiring'),
        -- ('2505060007', 'Bunga Talenta Cindikia'),
        -- ('2505060008', 'Ziffy Hilya'),
        -- ('2505060009', 'Emmanuel Revan Hendri Wijaya'),
        -- ('2505060010', 'Florania Ayodya Firdyaziz'),
        -- ('2505060011', 'Muhammad Fauza Asfadani'),
        -- ('2505060012', 'Emannuel Henji Pratama Putra'),
        -- ('2505060013', 'Siti Azimah Izzana'),
        -- ('2505060014', 'Kenji Muhammad Adisusilo'),
        -- ('2505060015', 'Fahma Aulia Fadilla'),
        -- ('2505060016', 'Siva Nur Aini'),
        -- ('2505060017', 'Muhammad Aufa Nabil Dhiaulhaq'),
        -- ('2505060018', 'Muhammad Satryana Rasyidin'),
        -- ('2505060019', 'Syifa Rahma Rasendriya'),
        -- ('2505060020', 'Angger Naufal Abror'),
        -- ('2505060021', 'Marcello Krisdaryanto Putro'),
        -- ('2505060022', 'Wildan Maulana Habibi'),
        -- ('2505060023', 'Dimas Galih Prakoso'),
        -- ('2505060024', 'Muhammad Zulfikar Arkan'),
        -- ('2505060025', 'Ramudya Fuji Pratama'),
        -- ('2505060026', 'Pangestu Ilham Dwi Prastyo'),
        -- ('2505060027', 'Bara Paramarta Widanoto'),
        -- ('2505060028', 'Munada Athof Fahlafi'),
        -- ('2505060029', 'Muhammad Sava Alfarisy'),
        -- ('2505060030', 'Aqila Nafisa Salma'),
        -- ('2505060031', 'Ilma Imama Anggun Wijayanti'),
        -- ('2505060032', 'Jauhara Putri Al Hasna'),
        -- ('2505060033', 'Rizkia Devi Nur Chairinnisa'),
        -- ('2505060034', 'Cahyo Adi Nugroho'),
        -- ('2505060035', 'Imam Ghozali'),
        -- ('2505060036', 'Putri Senja Nuril Azizah'),
        -- ('2505060037', 'Mohammad Maula Alyandi'),
        -- ('2505060038', 'Maulana Yusuf'),
        -- ('2505060039', 'Dian Khaerunia Azzahra'),
        -- ('2505060040', 'Faiz Naufal Hersorgama'),
        -- ('2505060041', 'zuyina m. irkham'),
        -- ('2505060042', 'Sahrul Indra Safani'),
        -- ('2505060043', 'Gilang Fastya Wijaya'),
        -- ('2505060044', 'Kristian Agung Nugroho'),
        -- ('2505060045', 'Muhammad Syafiq Azizi'),
        -- ('2505060046', 'Hilmi Mufid'),
        -- ('2505060047', 'Imelda Safira Putri'),
        -- ('2505060048', 'Fahmi Ridho Wiratama'),
        -- ('2505060049', 'Euaggelion Purnomo'),
        -- ('2505060050', 'Rindani Ayu Larasati'),
        -- ('2505060051', 'Salwa JJ Saputri'),
        -- ('2505060052', 'Nafis Rabbani'),
        -- ('2505060053', 'Fatkhan Maulana Atmaja'),
        -- ('2505060054', 'Zidane Arrizqi Akmal'),
        -- ('2505060055', 'Aufa Abid Rahman Nashir'),
        -- ('2505060056', 'Excel Bagus Herlambang'),
        -- ('2505060057', 'Bagus Manggala Yudha'),
        -- ('2505060058', 'Dewi Satiti Ningrum'),
        -- ('2505060059', 'Nabilla Dwi Putri Paraswati'),
        -- ('2505060060', 'M. Gustav Zaydan Nawfal'),
        -- ('2505060061', 'Pardede Putra Anjasmara'),
        -- ('2505060062', 'Dany Akhdan Imaduddin'),
        -- ('2505060063', 'Muhammad Zhio Affarel'),
        -- ('2505060064', 'Ibrahim Adnan Tsaqif'),
        -- ('2505060065', 'Aghnia Azka Dhiya'''), -- Fixed escaping if uncommented
        -- ('2505060066', 'Meila Dewin Khayarsya'),
        -- ('2505060067', 'Fauzan Fahmi Basyir'),
        -- ('2505060068', 'Naufal Arkan El Rochim'),
        -- ('2505060069', 'Rosifa Aulia Qodrun Nada'),
        -- ('2505060070', 'Sholahuddin Ahmad'),
        -- ('2505060071', 'Muhammad Banyu Legowo'),
        -- ('2505060072', 'Muhammad Raka Mushaddaq'),
        -- ('2505060073', 'Gavin Frederick Purnomo'),
        -- ('2505060074', 'Muhammad Hanif Raharjo'),
        -- ('2505060075', 'Nayla Rahmadani'),
        -- ('2505060076', 'Radja Harismansyah'),
        -- ('2505060077', 'Fachri Azizzul Akbar'),
        -- ('2505060078', 'Muhamad Dimas Adji Saputra'),
        -- ('2505060079', 'Areta Nasywa')
    ",

    // Versi 2.5: Insert anonim record for anonymized aspirations
    "INSERT IGNORE INTO mhs_whitelist (npm, nama) VALUES ('anonim', 'anonim')",

    // Versi 4.0: Add password column to mhs_whitelist
    "ALTER TABLE mhs_whitelist ADD COLUMN password VARCHAR(255) DEFAULT NULL",
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

    // Versi 4.0: Seed default passwords (NPM hashed) for users without password
    $stmt = $pdo->query("SELECT npm FROM mhs_whitelist WHERE password IS NULL AND npm != 'anonim'");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($users) > 0) {
        $update = $pdo->prepare("UPDATE mhs_whitelist SET password = ? WHERE npm = ?");
        foreach ($users as $u) {
            $update->execute([password_hash($u['npm'], PASSWORD_BCRYPT), $u['npm']]);
        }
        echo "Seeded default passwords for " . count($users) . " users.\n";
    }
} catch (PDOException $e) {
    die("Gagal migrasi: " . $e->getMessage() . "\n");
}