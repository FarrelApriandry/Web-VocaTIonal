# Panduan Konfigurasi GitHub Secrets

## Cara Menambahkan Secrets di GitHub

### 1. Buka Repository Settings

1. Buka repository GitHub Anda
2. Klik tab **Settings** (Pengaturan)
3. Di sidebar kiri, klik **Secrets and variables** → **Actions**

### 2. Menambahkan Secrets

#### SNYK_TOKEN (Untuk Security Scanning)

1. Klik tombol **New repository secret**
2. Isi form dengan:
   - **Name**: `SNYK_TOKEN`
   - **Secret**: [Token dari Snyk](https://app.snyk.io/account)
3. Klik **Add secret**

**Cara Mendapatkan SNYK_TOKEN:**
1. Buka [Snyk App](https://app.snyk.io/account)
2. Login atau buat akun gratis
3. Di halaman Account Settings, temukan **Auth Token**
4. Salin token tersebut

#### GITHUB_TOKEN (Otomatis Tersedia)

- GitHub secara otomatis menyediakan `GITHUB_TOKEN` untuk setiap workflow
- Tidak perlu ditambahkan secara manual
- Token ini digunakan untuk autentikasi ke GitHub Container Registry (GHCR)

### 3. Secrets Tambahan (Opsional)

#### Untuk Deployment ke Server

Jika Anda ingin melakukan deployment ke server staging/production:

1. **DEPLOY_HOST**: Alamat server staging
2. **DEPLOY_USER**: Username SSH
3. **DEPLOY_KEY**: Private key SSH (dalam format base64)

**Contoh:**
```
Name: DEPLOY_HOST
Secret: staging.example.com

Name: DEPLOY_USER  
Secret: deploy-user

Name: DEPLOY_KEY
Secret: [isi dengan private key SSH dalam format base64]
```

### 4. Format Secrets

- **String**: Langsung masukkan nilai (contoh: `my-secret-password`)
- **JSON**: Gunakan tanda kutip ganda (contoh: `{"key": "value"}`)
- **Multi-line**: Gunakan tanda kutip ganda dan escape newline (contoh: `"line1\nline2"`)

### 5. Best Practices

#### Keamanan
- Jangan pernah commit secrets ke repository
- Gunakan secrets hanya untuk informasi sensitif
- Batasi akses secrets ke workflow yang benar-benar membutuhkan

#### Manajemen
- Gunakan nama secrets yang deskriptif
- Dokumentasikan kegunaan setiap secret
- Review dan update secrets secara berkala

#### Contoh Nama Secrets yang Baik
- `SNYK_TOKEN` - Untuk Snyk security scanning
- `DEPLOY_STAGING_KEY` - Untuk deployment staging
- `NOTIFICATION_WEBHOOK` - Untuk notifikasi

### 6. Menggunakan Secrets di Workflow

```yaml
env:
  SNYK_TOKEN: ${{ secrets.SNYK_TOKEN }}

steps:
  - name: Use secret
    run: echo "Token: ${{ secrets.SNYK_TOKEN }}"
```

### 7. Troubleshooting

#### Common Issues

1. **Secret tidak ditemukan**
   - Pastikan secret sudah ditambahkan di repository yang benar
   - Periksa ejaan nama secret

2. **Permission denied**
   - Pastikan workflow memiliki izin yang cukup
   - Periksa GitHub App permissions

3. **Token expired**
   - Perbarui token di penyedia layanan (Snyk, dll)
   - Update secret dengan token baru

### 8. Environment Variables vs Secrets

#### Environment Variables
- Untuk nilai yang tidak sensitif
- Bisa dilihat di log workflow
- Contoh: `PHP_VERSION: '8.2'`

#### Secrets
- Untuk nilai sensitif (password, token, key)
- Tidak ditampilkan di log
- Di-masked di output workflow
- Contoh: `SNYK_TOKEN`, `DEPLOY_KEY`

### 9. Contoh Lengkap Setup

```bash
# 1. Setup Snyk
# - Buka https://app.snyk.io/account
# - Copy Auth Token
# - Tambahkan sebagai SNYK_TOKEN secret

# 2. Setup Deployment (opsional)
# - Generate SSH key pair
# - Tambahkan public key ke server
# - Encode private key: base64 private_key > encoded_key
# - Tambahkan encoded_key sebagai DEPLOY_KEY secret
# - Tambahkan DEPLOY_HOST dan DEPLOY_USER
```

### 10. Referensi

- [GitHub Actions Secrets Documentation](https://docs.github.com/en/actions/security-guides/encrypted-secrets)
- [Snyk Authentication](https://docs.snyk.io/snyk-cli/configure-the-snyk-cli#authentication)
- [GitHub Container Registry](https://docs.github.com/en/packages/working-with-a-github-packages-registry/working-with-the-container-registry)