# 📋 Task List — Proyek VocaTIonal

**Project:** VocaTIonal - Professional IT Student Grievance System  
**Development Period:** 90 hari (21 Feb – 21 Mei 2026)  
**Total Estimasi Biaya:** Rp 13.825.000

---

## Tabel Task List

| No | Task (Fitur) | Role | Durasi | Material | Cost (IDR) |
|----|-------------|------|--------|----------|------------|
| 1 | **Inisialisasi & Docker Scaffold** — Setup repository, Dockerfile, docker-compose, Apache vhost, MVC skeleton | DO (DevOps Engineer), LD-BE (Lead Developer Backend) | 3 hari | GitHub Free, Docker Hub | Rp 1.005.000 |
| 2 | **CI/CD Pipeline** — GitHub Actions: PHP linting, security scan, auto-deploy ke DigitalOcean | DO (DevOps Engineer) | 4 hari | GitHub Actions (free tier) | Rp 640.000 |
| 3 | **Database Schema & Migration** — Design 7 tabel, migration idempotent, seed data, schema versioning | DBA (Database Administrator) | 5 hari | MySQL (via Docker) | Rp 800.000 |
| 4 | **Student Authentication System** — Login NPM+password, CSRF protection, session hardening, dual rate limiting, session fingerprinting | SA (Security Analyst), LD-BE (Lead Developer Backend) | 5 hari | — | Rp 1.750.000 |
| 5 | **Aspiration Submission System** — Form submit, input validation, kategori, anonymous mode, API endpoint | BD (Backend Developer), FD (Frontend Developer) | 3 hari | — | Rp 900.000 |
| 6 | **Bulletin Board & Reaction System** — Masonry grid, async fetch, category filter, pagination, emoji reactions, skeleton loader | FD (Frontend Developer), BD (Backend Developer) | 5 hari | — | Rp 1.500.000 |
| 7 | **Report System** — Report modal, reason enum, report CRUD API, admin report management + statistics | BD (Backend Developer), FD (Frontend Developer) | 4 hari | — | Rp 1.200.000 |
| 8 | **Admin Panel MVC Architecture** — Router, BaseController, layout system (header+sidebar), view rendering dengan output buffering | LD-BE (Lead Developer Backend) | 4 hari | — | Rp 700.000 |
| 9 | **Admin Authentication** — Admin login/logout, session management, role-based access control | LD-BE (Lead Developer Backend), SA (Security Analyst) | 3 hari | — | Rp 1.050.000 |
| 10 | **Admin Aspiration Management** — Dashboard, aspirations list, status update API, board approval | BD (Backend Developer), FD (Frontend Developer) | 3 hari | — | Rp 900.000 |
| 11 | **SSL/HTTPS & Production Deployment** — Let's Encrypt, dual vhost (public + admin), HTTP→HTTPS redirect, DigitalOcean server setup | DO (DevOps Engineer) | 3 hari | DigitalOcean VPS (3 bln), Domain vocational.info, SSL Let's Encrypt | Rp 930.000 |
| 12 | **UI/UX & Accessibility Enhancement** — Tailwind responsive, Lucide icons, semantic HTML, ARIA labels, skeleton loaders, mobile nav | FD (Frontend Developer), UX (UI/UX Designer) | 5 hari | Tailwind CDN (free), Lucide Icons (free) | Rp 1.450.000 |
| 13 | **Documentation & Technical Writing** — SDD, Docker guide, README, API docs, panduan operasional | TW (Technical Writer), PM (Project Manager) | 4 hari | — | Rp 1.000.000 |

---

## 💰 Ringkasan Biaya

| Kategori | Total |
|----------|-------|
| **Labor Cost (Jasa)** | Rp 13.375.000 |
| **Material Cost** | Rp 450.000 |
| **TOTAL PROYEK** | **Rp 13.825.000** |

---

## 📝 Detail Kalkulasi Labor

| No | Kalkulasi | Subtotal |
|----|-----------|----------|
| 1 | DO(3×Rp160.000) + LD-BE(3×Rp175.000) | Rp 1.005.000 |
| 2 | DO(4×Rp160.000) | Rp 640.000 |
| 3 | DBA(5×Rp160.000) | Rp 800.000 |
| 4 | SA(5×Rp175.000) + LD-BE(5×Rp175.000) | Rp 1.750.000 |
| 5 | BD(3×Rp150.000) + FD(3×Rp150.000) | Rp 900.000 |
| 6 | FD(5×Rp150.000) + BD(5×Rp150.000) | Rp 1.500.000 |
| 7 | BD(4×Rp150.000) + FD(4×Rp150.000) | Rp 1.200.000 |
| 8 | LD-BE(4×Rp175.000) | Rp 700.000 |
| 9 | LD-BE(3×Rp175.000) + SA(3×Rp175.000) | Rp 1.050.000 |
| 10 | BD(3×Rp150.000) + FD(3×Rp150.000) | Rp 900.000 |
| 11 | DO(3×Rp160.000) | Rp 480.000 |
| 12 | FD(5×Rp150.000) + UX(5×Rp140.000) | Rp 1.450.000 |
| 13 | TW(4×Rp100.000) + PM(4×Rp150.000) | Rp 1.000.000 |

---

## 🖥️ Detail Material

| Item | Biaya |
|------|-------|
| DigitalOcean VPS (3 bulan × Rp 100.000) | Rp 300.000 |
| Domain vocational.info (1 tahun) | Rp 150.000 |
| SSL Let's Encrypt | Gratis |
| GitHub (Free tier + Actions) | Gratis |
| Tailwind CSS CDN | Gratis |
| Lucide Icons | Gratis |
| Docker Hub | Gratis |
| **Total Material** | **Rp 450.000** |

---

## 👥 Resource Rate Reference

| No | Resource Name | Type | Initials | Group | Standard Rate | Overtime Rate |
|----|--------------|------|----------|-------|---------------|---------------|
| 1 | Project Manager / Scrum Master | Work | PM | Management | Rp 150.000/hari | Rp 200.000/hari |
| 2 | Lead Developer (Backend) | Work | LD-BE | Development | Rp 175.000/hari | Rp 250.000/hari |
| 3 | Frontend Developer | Work | FD | Development | Rp 150.000/hari | Rp 200.000/hari |
| 4 | Backend Developer | Work | BD | Development | Rp 150.000/hari | Rp 200.000/hari |
| 5 | DevOps Engineer | Work | DO | Infrastructure | Rp 160.000/hari | Rp 220.000/hari |
| 6 | QA Engineer / Tester | Work | QA | Quality | Rp 125.000/hari | Rp 175.000/hari |
| 7 | UI/UX Designer | Work | UX | Design | Rp 140.000/hari | Rp 190.000/hari |
| 8 | Database Administrator | Work | DBA | Database | Rp 160.000/hari | Rp 220.000/hari |
| 9 | Security Analyst | Work | SA | Security | Rp 175.000/hari | Rp 250.000/hari |
| 10 | Technical Writer | Work | TW | Documentation | Rp 100.000/hari | Rp 130.000/hari |

---

*Dokumen ini di-generate pada 28 Mei 2026 berdasarkan analisis COMMIT_HISTORY_AUDIT.md dan OUTLINE_ARTIKEL_VOCATIONAL.md*
