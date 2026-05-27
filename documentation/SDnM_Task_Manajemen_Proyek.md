# TUGAS SD&M - MANAJEMEN PROYEK PERANGKAT LUNAK
## Proyek: VocaTIonal (Platform Aspirasi Mahasiswa)

---

## 📋 INFORMASI PROYEK

| Item | Detail |
|------|--------|
| **Nama Proyek** | VocaTIonal - Platform Aspirasi Terintegrasi |
| **Organisasi** | Universitas Tidar, Teknik Informatika '24 - HIMATIF |
| **Scope** | Web-based aspiration management system dengan admin panel |
| **Teknologi** | PHP 8.2, MySQL 8.0, Tailwind CSS, Docker, Apache |
| **Tim Developer** | 5 orang |
| **Durasi Estimasi** | 6 bulan (24 minggu) |
| **Repository** | https://github.com/FarrelApriandry/Web-VocaTIonal |

---

## 1. RESOURCE SHEET (Daftar Sumber Daya)

### A. Tipe WORK (Sumber Daya Manusia)

| No | Resource Name | Type | Initials | Group | Standard Rate | Overtime Rate | Cost/Use | Notes |
|----|---------------|------|----------|-------|---------------|---------------|----------|-------|
| 1 | Project Manager / Scrum Master | Work | PM | Management | Rp 150.000/hari | Rp 200.000/hari | Rp 0 | Koordinasi tim, sprint planning |
| 2 | Lead Developer (Backend) | Work | LD-BE | Development | Rp 175.000/hari | Rp 250.000/hari | Rp 0 | PHP, MySQL, API development |
| 3 | Frontend Developer | Work | FD | Development | Rp 150.000/hari | Rp 200.000/hari | Rp 0 | Tailwind CSS, UI/UX implementation |
| 4 | Backend Developer | Work | BD | Development | Rp 150.000/hari | Rp 200.000/hari | Rp 0 | PHP development, API integration |
| 5 | DevOps Engineer | Work | DO | Infrastructure | Rp 160.000/hari | Rp 220.000/hari | Rp 0 | Docker, CI/CD, deployment |
| 6 | QA Engineer / Tester | Work | QA | Quality | Rp 125.000/hari | Rp 175.000/hari | Rp 0 | Integration testing, bug reporting |
| 7 | UI/UX Designer | Work | UX | Design | Rp 140.000/hari | Rp 190.000/hari | Rp 0 | Wireframe, mockup, user experience |
| 8 | Database Administrator | Work | DBA | Database | Rp 160.000/hari | Rp 220.000/hari | Rp 0 | Schema design, migration, optimization |
| 9 | Security Analyst | Work | SA | Security | Rp 175.000/hari | Rp 250.000/hari | Rp 0 | CSRF, XSS, SQL injection prevention |
| 10 | Technical Writer | Work | TW | Documentation | Rp 100.000/hari | Rp 130.000/hari | Rp 0 | SDD, user guide, API docs |

### B. Tipe MATERIAL (Sumber Daya Material)

| No | Resource Name | Type | Initials | Group | Standard Rate | Cost/Use | Notes |
|----|---------------|------|----------|-------|---------------|----------|-------|
| 11 | Cloud Server (Digital Ocean Droplet) | Material | DO-SRV | Infrastructure | Rp 200.000/bulan | Rp 1.200.000 | 2GB RAM, 1 vCPU, 70GB Disk (6 bulan) |
| 12 | Domain Name (.info) | Material | DOM | Infrastructure | Rp 150.000/tahun | Rp 150.000 | vocational.info + admin.vocational.info |
| 13 | SSL Certificate (Let's Encrypt) | Material | SSL | Security | Rp 0 | Rp 0 | Free SSL untuk production |
| 14 | Development Tools & Licenses | Material | TOOLS | Development | Rp 500.000 | Rp 500.000 | IDE, plugins, testing tools |
| 15 | Documentation & Printing | Material | DOC | Documentation | Rp 200.000 | Rp 200.000 | Laporan, presentasi, hardcopy |

### C. Tipe COST (Sumber Daya Biaya Langsung)

| No | Resource Name | Type | Initials | Group | Fixed Cost | Notes |
|----|---------------|------|----------|-------|------------|-------|
| 16 | Internet & Communication | Cost | INT | Operations | Rp 600.000 | 6 bulan x Rp 100.000/bulan |
| 17 | Meeting & Transportation | Cost | MEET | Operations | Rp 480.000 | 24 minggu x Rp 20.000/minggu |
| 18 | Contingency Reserve (10%) | Cost | CONT | Management | Rp 850.000 | Cadangan untuk risiko tak terduga |

---

## 2. ESTIMASI BIAYA DETAIL

### A. Biaya Sumber Daya Manusia (WORK)

| Role | Hari Kerja | Rate/Hari | Total Biaya |
|------|------------|-----------|-------------|
| Project Manager | 120 hari | Rp 150.000 | Rp 18.000.000 |
| Lead Developer | 100 hari | Rp 175.000 | Rp 17.500.000 |
| Frontend Developer | 100 hari | Rp 150.000 | Rp 15.000.000 |
| Backend Developer | 90 hari | Rp 150.000 | Rp 13.500.000 |
| DevOps Engineer | 60 hari | Rp 160.000 | Rp 9.600.000 |
| QA Engineer | 50 hari | Rp 125.000 | Rp 6.250.000 |
| UI/UX Designer | 40 hari | Rp 140.000 | Rp 5.600.000 |
| DBA | 30 hari | Rp 160.000 | Rp 4.800.000 |
| Security Analyst | 20 hari | Rp 175.000 | Rp 3.500.000 |
| Technical Writer | 30 hari | Rp 100.000 | Rp 3.000.000 |
| **SUBTOTAL SDM** | **640 hari** | | **Rp 96.750.000** |

---

## 3. WORK BREAKDOWN STRUCTURE (WBS)

### Level 1: VocaTIonal Project

```
VocaTIonal Project (Rp 100.730.000)
├── 1. Project Management
├── 2. Requirement Analysis
├── 3. System Design
├── 4. Development (4 Sprints)
├── 5. Testing & QA
├── 6. Deployment
└── 7. Documentation & Handover
```

### Alokasi Sumber Daya per Fase

| WBS | Fase | Durasi | Resources | Biaya |
|-----|------|--------|-----------|-------|
| 1 | Project Management | 24 minggu | PM, All Team | Rp 19.400.000 |
| 2 | Requirement Analysis | 3 minggu | PM, UX, LD-BE, TW | Rp 4.730.000 |
| 3 | System Design | 2 minggu | UX, DBA, LD-BE, SA, DO | Rp 6.320.000 |
| 4 | Development | 14 minggu | All Dev, QA, SA | Rp 24.260.000 |
| 5 | Testing & QA | 3 minggu | QA, All Dev, DO, SA | Rp 9.630.000 |
| 6 | Deployment | 2 minggu | DO, LD-BE, QA | Rp 2.840.000 |
| 7 | Documentation | 2 minggu | TW, LD-BE, DO, PM | Rp 4.795.000 |

---

## 4. ANALISIS OVERALLOCATION & RESOLUSI

### Indikator Overallocation

| Resource | Peak Load | Status | Solusi |
|----------|-----------|--------|--------|
| Lead Developer | 100% (W5-8,11-18) | CRITICAL | Task splitting ke Backend Dev |
| Backend Developer | 100% (W5-15) | CRITICAL | Pair programming + overtime |
| QA Engineer | 100% (W18-21) | WARNING | Shift left testing, automated test |
| Project Manager | 100% (W1-3) | WARNING | Delegation ke TW |
| Frontend Developer | 100% (W8-15) | WARNING | Parallel development |

---

## 5. ANALISIS NPV & BREAK EVEN POINT

### Perhitungan NPV

| Keterangan | Tahun 0 | Tahun 1 | Tahun 2 | Tahun 3 |
|------------|---------|---------|---------|---------|
| Investasi | -100.730.000 | - | - | - |
| Penghematan | - | 30.000.000 | 40.000.000 | 50.000.000 |
| Tambahan Penerimaan | - | 40.000.000 | 50.000.000 | 60.000.000 |
| **Total Manfaat** | **-100.730.000** | **70.000.000** | **90.000.000** | **110.000.000** |
| Discount Factor (10%) | 1 | 0.909 | 0.826 | 0.751 |
| **PV Manfaat** | -100.730.000 | 63.636.364 | 74.380.165 | 82.644.628 |
| **Kumulatif NPV** | -100.730.000 | -37.093.636 | 37.286.530 | **119.931.158** |

### Hasil Analisis

| Metric | Value | Interpretasi |
|--------|-------|--------------|
| **NPV** | **+Rp 119.931.158** | Positif - Proyek LAYAK |
| **IRR** | ~35% | Melebihi discount rate |
| **BEP** | **1 tahun 6 bulan** | Investasi cepat kembali |

---

## 6. KESIMPULAN

1. **Alokasi Sumber Daya:** 18 sumber daya berhasil dialokasikan ke 7 fase proyek
2. **Total Biaya Proyek:** Rp 100.730.000
3. **Kelayakan Finansial:** NPV: +Rp 119.931.158 (POSITIF) - Proyek SANGAT LAYAK
4. **BEP:** 1 tahun 6 bulan

---

**Disusun oleh:** Farrel Apriandry Ciu & Team VocaTIonal
**Tanggal:** 24 Mei 2026
**Mata Kuliah:** Software Development & Management (SD&M)