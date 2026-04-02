# Panduan Setup Docker

Proyek ini mencakup konfigurasi Docker untuk pengembangan lokal yang mudah dengan Apache, PHP 8.2, MySQL 8.0, dan phpMyAdmin.

## Mulai Cepat

### Menggunakan Script docker-start (Direkomendasikan)

Proyek ini mencakup skrip mudah guna untuk mengelola container Docker:

#### Linux/macOS (Bash)
```bash
# Mulai semua layanan
./docker-start.sh start

# Hentikan semua layanan
./docker-start.sh stop

# Lihat status layanan
./docker-start.sh status

# Lihat log
./docker-start.sh logs

# Restart layanan
./docker-start.sh restart

# Tampilkan bantuan
./docker-start.sh help
```

#### Windows (Batch)
```cmd
REM Mulai semua layanan
docker-start.bat start

REM Hentikan semua layanan
docker-start.bat stop

REM Lihat status layanan
docker-start.bat status

REM Lihat log
docker-start.bat logs

REM Restart layanan
docker-start.bat restart

REM Tampilkan bantuan
docker-start.bat help
```

### Perintah Docker Manual

Jika Anda lebih suka menggunakan perintah Docker secara langsung:

```bash
# Mulai semua layanan
docker-compose up -d

# Hentikan semua layanan
docker-compose down

# Lihat status layanan
docker-compose ps

# Lihat log
docker-compose logs -f

# Restart layanan
docker-compose restart
```

## Layanan

Setup Docker mencakup tiga layanan utama:

### 1. Server Web (Apache + PHP 8.2)
- **Nama Container**: `vocational-web`
- **Port**: 80
- **URL Akses**: http://localhost:80
- **Fitur**:
  - PHP 8.2 dengan ekstensi PDO MySQL
  - Apache dengan mod_rewrite diaktifkan
  - Pemetaan volume untuk pengembangan langsung

### 2. Database (MySQL 8.0)
- **Nama Container**: `vocational-db`
- **Port**: 3306
- **Nama Database**: `vocational` (dapat dikonfigurasi melalui `.env`)
- **Password Root**: `rootpassword` (dapat dikonfigurasi melalui `.env`)

### 3. phpMyAdmin
- **Nama Container**: `vocational-pma`
- **Port**: 8081
- **URL Akses**: http://localhost:8081
- **Kredensial**: root / rootpassword

## Konfigurasi

### Variabel Lingkungan

Proyek ini menggunakan file `.env` untuk mengkonfigurasi variabel lingkungan:

```env
DB_HOST=db
DB_NAME=****
DB_USER=****
DB_PASS=****
```

### Konfigurasi Port

Port default dikonfigurasi sebagai berikut:
- Aplikasi Web: 80
- phpMyAdmin: 8081
- Database: 3306

Untuk mengubah port ini, modifikasi file `docker-compose.yml`.

## Penggunaan Lanjutan

### Menjalankan Perintah dalam Container

#### Menggunakan Skrip
```bash
# Masuk ke shell container web
./docker-start.sh exec web bash

# Terhubung ke MySQL
./docker-start.sh exec db mysql -u root -p
```

#### Perintah Docker Manual
```bash
# Masuk ke shell container web
docker-compose exec web bash

# Terhubung ke MySQL
docker-compose exec db mysql -u root -p
```

### Melihat Log

#### Menggunakan Skrip
```bash
# Lihat semua log
./docker-start.sh logs

# Lihat log layanan tertentu
./docker-start.sh logs web
./docker-start.sh logs db
./docker-start.sh logs phpmyadmin
```

#### Perintah Docker Manual
```bash
# Lihat semua log
docker-compose logs -f

# Lihat log layanan tertentu
docker-compose logs -f web
docker-compose logs -f db
docker-compose logs -f phpmyadmin
```

### Persistensi Data

Data database dipertahankan menggunakan volume Docker. Volume `db_data` menyimpan data MySQL dan akan tetap ada antara restart container.

### Pembersihan

Untuk sepenuhnya menghapus semua container, volume, dan gambar yang tidak digunakan:

#### Menggunakan Skrip
```bash
./docker-start.sh cleanup
```

#### Perintah Docker Manual
```bash
# Hentikan dan hapus container dengan volume
docker-compose down -v

# Hapus gambar yang tidak digunakan
docker image prune -f
```

## Pemecahan Masalah

### Docker Tidak Berjalan
Jika Anda mendapatkan error tentang Docker tidak berjalan, pastikan Docker Desktop sudah terinstal dan berjalan.

### Port Sudah Digunakan
Jika Anda mendapatkan error binding port, periksa apakah layanan lain menggunakan port yang sama:
```bash
# Periksa apa yang menggunakan port 80
lsof -i :80  # macOS/Linux
netstat -ano | findstr :80  # Windows
```

### Masalah Izin (Linux/macOS)
Jika Anda mengalami masalah izin dengan skrip:
```bash
chmod +x docker-start.sh
```

### Variabel Lingkungan Tidak Dimuat
Pastikan file `.env` Anda berada di direktori yang sama dengan `docker-compose.yml` dan berisi variabel yang diperlukan.

## Struktur Proyek

```
vocational/
├── docker-compose.yml     # Konfigurasi Docker
├── Dockerfile            # Setup container PHP/Apache
├── .env                  # Variabel lingkungan
├── docker-start.sh       # Skrip manajemen Linux/macOS
├── docker-start.bat      # Skrip manajemen Windows
├── README-Docker.md      # File ini
├── app/                  # Kode aplikasi
├── public/               # Direktori root web
└── docker/               # File konfigurasi Docker
    └── apache/
        └── vhost.conf    # Konfigurasi virtual host Apache
```

## Alur Kerja Pengembangan

1. **Mulai Layanan**: `./docker-start.sh start`
2. **Akses Aplikasi**: http://localhost:80
3. **Akses Admin Database**: http://localhost:8081
4. **Lakukan Perubahan Kode**: File secara otomatis disinkronkan melalui pemetaan volume
5. **Hentikan Layanan**: `./docker-start.sh stop` (saat selesai)

## Catatan

- Container web memasang direktori proyek Anda ke `/var/www/html` untuk pengembangan langsung
- Apache dikonfigurasi dengan mod_rewrite untuk routing URL
- Data MySQL tetap ada antara restart container
- phpMyAdmin menyediakan antarmuka web untuk manajemen database
