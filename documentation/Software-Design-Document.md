# Software Design Document (SDD): VocaTIonal

**Project Name:** VocaTIonal - Platform Aspirasi Terintegrasi Mahasiswa Teknologi Informasi

**Version:** 0.0.5

**Stack:** Docker, PHP Native, MySQL

**Architecture:** S5-Layered Modular System

## 1. Project Overview

VocaTIonal adalah platform digital yang dirancang untuk menggantikan metode pengumpulan aspirasi konvensional (seperti Google Forms) menjadi sistem ticketing yang diharapkan profesional, transparan, dan aman. Sistem ini fokus pada validasi identitas berbasis NPM dan manajemen status laporan secara real-time.

---

## 2. System Architecture (S5 Model)

Sistem ini dibangun menggunakan pendekatan 5 lapis (S1-S5) untuk memisahkan tanggung jawab setiap komponen dan memastikan keamanan data.

* **S5: Interface Layer (Navigasi & UI)**
* Fungsi: Menangani tampilan (HTML/Tailwind) dan feedback ke user.


* **S4: Security Layer (Middleware Configuration)**
* Fungsi: Validasi sesi, pengecekan role, dan sanitasi input mentah.


* **S3: Business Logic Layer (Internal Process)**
* Fungsi: Inti aplikasi (CRUD Aspirasi, Upload Bukti).


* **S2: Service Layer (Validation & Utilities)**
* Fungsi: Validasi spesifik (Format NPM) dan helper (Pagination).


* **S1: Infrastructure Layer (Data Persistence)**
* Fungsi: Koneksi database PDO dan Query Builder.



---

## 3. Module Specification (The 15 Modules)

| ID | Module Name | Responsibility | Layer |
| --- | --- | --- | --- |
| **M1** | DB Connection | Singleton PDO instance untuk efisiensi koneksi. | S1 |
| **M2** | NPM Validator | Cek format & Whitelist mahasiswa TI di database. | S2 |
| **M3** | Admin Auth | Verifikasi `password_hash` untuk akses pengurus. | S2 |
| **M4** | Session Manager | Manajemen `session_start` & `session_regenerate_id`. | S4 |
| **M5** | Input Sanitizer | Proteksi XSS & SQL Injection (Cleaning $_POST). | S4 |
| **M6** | Aspirasi Engine | Logika utama penyimpanan data laporan ke MySQL. | S3 |
| **M7** | File Uploader | Validasi mime-type, size, dan move_uploaded_file. | S3 |
| **M8** | Status Controller | Logic transisi status: Pending > Proses > Selesai. | S3 |
| **M9** | Response Handler | Logika penyimpanan tanggapan resmi dari Admin. | S3 |
| **M10** | Query Builder | Helper untuk mempermudah query SELECT/JOIN. | S1 |
| **M11** | Notif Logic | Feedback UI (Toast/Alert) setelah eksekusi fungsi. | S5 |
| **M12** | Role Guard | Middleware pengecekan hak akses tiap halaman. | S4 |
| **M13** | Pagination Logic | Membagi data tabel aspirasi agar tidak lag. | S2 |
| **M14** | Report Generator | Fungsi agregasi untuk statistik laporan bulanan. | S2 |
| **M15** | Redirect & Router | Manajemen header location & query strings. | S5 |

---

## 4. Data Design (Database Schema)

### 4.1 Tabel `mhs_whitelist`

Menyimpan daftar mahasiswa TI yang berhak memberikan aspirasi.

* `npm` (PK, VARCHAR 15)
* `nama` (VARCHAR 100)

### 4.2 Tabel `aspirasi`

Penyimpanan utama laporan.

* `id_aspirasi` (PK, AUTO_INC)
* `npm_pelapor` (FK, VARCHAR 15)
* `judul` (VARCHAR 255)
* `deskripsi` (TEXT)
* `kategori` (ENUM: Akademik, Fasilitas, UKT, Lainnya)
* `foto` (VARCHAR 255)
* `status` (ENUM: Pending, Proses, Selesai)
* `created_at` (TIMESTAMP)

### 4.3 Tabel `tanggapan`

Tanggapan resmi dari pihak advokasi.

* `id_tanggapan` (PK)
* `id_aspirasi` (FK)
* `isi_tanggapan` (TEXT)
* `admin_id` (FK)

---

## 5. Security Protocols (Zero Trust Approach)

1. **Input Filtering:** Semua data dari user wajib melewati modul **M5** sebelum diproses.
2. **Access Control:** Setiap file di folder admin wajib menyertakan modul **M12** (Role Guard) di baris paling atas.
3. **No Direct Access:** Menggunakan `.htaccess` untuk memblokir akses langsung ke folder `/includes` dan `/config`.
4. **Prepared Statements:** Seluruh interaksi database wajib menggunakan PDO Prepared Statements (Modul **M10**).

---

## 6. Directory Structure

```text
Web-VocaTIonal/
├── .github/                   # GitHub configuration directory
│   └── workflows/             # Directory for automated pipeline scripts
│       └── ci.yml             # DevSecOps: Linting, Secret Scan, and Docker Build Test [cite: 2026-02-27]
├── vocational/                # Main application source directory
│   ├── app/                   # Core application logic (MVC-ish pattern) [cite: 2025-12-23]
│   │   ├── Config/            # System & Database configurations
│   │   │   ├── Database.php   # Singleton PDO connection handler
│   │   │   └── Migration.php  # Automated database schema sync tool [cite: 2026-02-27]
│   │   ├── Controllers/       # Traffic controllers (Logics between Model & View)
│   │   ├── Core/              # Base classes and system kernel
│   │   │   ├── Controller.php # Main base controller class
│   │   │   └── Env.php        # Environment variable loader for security [cite: 2026-02-27]
│   │   ├── Models/            # Database abstraction and data handling
│   │   └── Views/             # UI Templates and presentation layer
│   ├── docker/                # Infrastructure-as-Code (IaC) configurations
│   │   └── apache/
│   │       └── vhost.conf     # Virtual host config for Apache server
│   ├── documentation/         # Technical documentation & project blueprints [cite: 2025-12-23]
│   │   ├── PanduanOperasionalDocker/ # Assets for docker operations guide
│   │   ├── panduan-Operasional-Docker.md # Manual for running the dev environment
│   │   └── Software-Design-Document.md # High-level system architecture documentation
│   ├── public/                # Web server root (The only folder accessible by users)
│   │   ├── assets/            # Static files: images, logos, etc.
│   │   │   └── img/           # Image repository (e.g., logo-himatif.svg)
│   │   ├── css/               # Tailwind or custom CSS stylesheets
│   │   ├── js/                # Client-side JavaScript logic
│   │   └── index.php          # Front Controller: Entry point of the app
│   ├── vendor/                # Composer dependencies (Ignored by Git)
│   ├── .env                   # Sensitive credentials (Zero-Trust approach) [cite: 2026-01-19]
│   ├── .htaccess              # Apache URL rewriting and security rules
│   ├── docker-compose.yml     # Multi-container orchestration config [cite: 2026-02-27]
│   └── Dockerfile             # Blueprint for building the app's container
├── README.md                  # Project landing page and quick-start guide
└── .gitignore                 # Files and folders to be excluded from VCS
```
