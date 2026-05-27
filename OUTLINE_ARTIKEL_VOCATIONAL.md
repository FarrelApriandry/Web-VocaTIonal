# OUTLINE & KONTEN ARTIKEL MEDIUM / LAPRAK: VOCATIONAL

> **Dokumen ini** merupakan blueprint komprehensif untuk penulisan artikel Medium (Tech Blog) atau Laporan Praktikum (Laprak) berdasarkan 88 commit history dan arsitektur sistem VocaTIonal.

---

## 1. JUDUL & REKOMENDASI HOOK (TITLE SUGGESTIONS)

### 🔥 Medium / Tech Blog (High-Engagement)

> **"Building a Secure Student Grievance Platform from Scratch: CSRF Tokens, Session Hardening, and MVC Architecture in Native PHP"**

*Subtitle:* How we engineered a production-grade anonymous reporting system with dual-rate limiting, Docker orchestration, and a custom MVC framework — without a single third-party PHP dependency.

### 📄 Laporan Praktikum (Formal / Academic)

> **"Perancangan dan Implementasi Sistem Pelaporan Aspirasi Mahasiswa Berbasis Web dengan Arsitektur MVC, Proteksi CSRF, dan Containerization Docker pada Lingkungan Multi-VirtualHost"**

*Subtitle:* Studi Kasus Pengembangan Aplikasi VocaTIonal untuk Himpunan Mahasiswa Informatika (HIMATIF) Universitas Tidar.

---

## 2. ABSTRAK & PENDAHULUAN (INTRODUCTION & PROBLEM STATEMENT)

### 2.1 Abstrak

VocaTIonal adalah platform pelaporan aspirasi mahasiswa yang dirancang untuk menjembatani kesenjangan komunikasi antara mahasiswa program studi Informatika dengan pemangku kepentingan akademik. Sistem ini dibangun menggunakan arsitektur MVC (Model-View-Controller) native PHP tanpa framework eksternal, dengan penekanan pada keamanan data (CSRF protection, session hardening, dual-rate limiting), anonimitas pelapor, dan aksesibilitas antarmuka. Infrastruktur deployment menggunakan Docker multi-container dengan konfigurasi dual Apache VirtualHost untuk isolasi aplikasi publik dan panel admin.

### 2.2 Rumusan Masalah

| No | Problem Statement | Engineering Gap |
|----|-------------------|-----------------|
| 1 | Aspirasi mahasiswa tidak memiliki kanal formal yang terstruktur | Tidak ada sistem digital yang mengakomodasi submission, tracking, dan response lifecycle |
| 2 | Mahasiswa takut melaporkan karena identitas terekspos | Tidak ada mekanisme anonimitas yang terverifikasi secara teknis (bukan sekadar "hide name") |
| 3 | Data aspirasi tersebar dan tidak terkelola | Tidak ada database schema yang mendukung categorization, status tracking, dan audit trail |
| 4 | Keamanan sistem pelaporan rentan terhadap serangan | Tidak ada implementasi CSRF, rate limiting, session fixation prevention, atau input sanitization |

### 2.3 Solusi yang Diimplementasikan

VocaTIonal menjawab gap tersebut melalui:
- **Dual-application architecture** — Isolasi total antara public app (student-facing) dan admin panel (management-facing)
- **Whitelist-based authentication** — Hanya NPM terdaftar yang dapat mengakses sistem
- **Multi-layer security** — CSRF tokens, session regeneration, dual rate limiting (IP + NPM), input sanitization dengan regex
- **Anonymous-by-design** — Ketika mode anonim aktif, `npm_pelapor` di-set ke literal string "anonim", memutus relasi data ke identitas
- **Versioned database migration** — Schema evolution terkontrol dengan idempotent migrations

---


## 3. SPESIFIKASI TEKNOLOGI (TECH STACK ARCHITECTURE DEEP-DIVE)

### 3.1 Backend Core: PHP 8.2+ Native dengan Custom MVC

| Layer | Implementation | Engineering Rationale |
|-------|---------------|----------------------|
| **Router** | `routes.php` dengan `switch($action)` mapping | Lightweight routing tanpa overhead regex engine; action-based dispatch via query parameter `?action=` |
| **Controller** | `AdminBaseController` (abstract) → concrete controllers | Template Method pattern; `renderLayout()` menggunakan `ob_start()` + `extract()` untuk variable injection ke views |
| **Model** | `Aspirasi.php`, `AspirationReport.php` | Active Record-lite pattern; semua query menggunakan PDO prepared statements (`$stmt->execute([$param])`) |
| **View** | Pure PHP templates dengan `extract($data)` | Zero-dependency templating; data dikirim sebagai associative array, di-extract menjadi local variables |
| **Config** | `Database.php` (singleton PDO), `Session.php`, `Migration.php` | Separation of concerns; setiap config file memiliki single responsibility |

**Mengapa Native PHP tanpa Framework?**
- **Zero dependency overhead** — Tidak ada Composer autoload chain, tidak ada vendor bloat
- **Full control** — Setiap security layer diimplementasikan secara eksplisit (bukan "magic" dari framework)
- **Educational value** — Memahami bagaimana MVC bekerja di level fundamental
- **Performance** — Cold start time minimal; tidak ada bootstrap/service container initialization

```
Request Flow:
Browser → Apache VHost → index.php → routeAdmin($action) → Controller::index()
    → Model::query() → Controller::renderLayout('view', $data)
        → ob_start() → extract($data) → include(view.php) → ob_get_clean()
            → include(layout.php) → echo $content → Browser
```

### 3.2 Frontend Ecosystem: Tailwind CSS + Lucide Icons

| Technology | Role | Implementation Detail |
|-----------|------|----------------------|
| **Tailwind CSS** (CDN) | Utility-first styling | Responsive grid (`grid-cols-1 md:grid-cols-2 lg:grid-cols-3`), dark mode ready, zero custom CSS files |
| **Lucide Icons** | Iconography system | SVG-based icon library via `data-lucide` attributes; replaced inline SVGs in commit `dad712a` |
| **Vanilla JavaScript** | Client-side logic | Async/await fetch API, DOM manipulation, event delegation — no jQuery, no React |

**Frontend Architecture Decisions:**
- **No build step** — CDN-loaded Tailwind eliminates the need for PostCSS/webpack pipeline
- **Progressive enhancement** — Skeleton loaders (`animate-pulse`) provide perceived performance while async data loads
- **Masonry-style grid** — CSS Grid with randomized rotation (`Math.random() * 4 - 2` degrees) creates bulletin-board aesthetic

### 3.3 Infrastructure & Environment: Docker + Dual VirtualHost

```yaml
# Architecture Diagram
┌─────────────────────────────────────────────────────┐
│                   Docker Network                     │
│                                                     │
│  ┌──────────────────┐    ┌──────────────────────┐  │
│  │  vocational-web   │    │   vocational-db       │  │
│  │  (Apache + PHP)   │    │   (MySQL 8.0)         │  │
│  │                   │    │                       │  │
│  │  Port 80 (HTTP)   │    │   Port 3306           │  │
│  │  Port 443 (HTTPS) │    │                       │  │
│  │                   │    │                       │  │
│  │  VHost 1:         │    │   Tables:             │  │
│  │   vocational.prod │    │   - mhs_whitelist     │  │
│  │   → /public/      │    │   - aspirasi          │  │
│  │                   │    │   - admin_web          │  │
│  │  VHost 2:         │    │   - aspirasi_reactions │  │
│  │   admin.vocational│    │   - aspirasi_reports   │  │
│  │   → /admin/public/│    │   - user_sessions     │  │
│  └──────────────────┘    │   - tanggapan          │  │
│                           └──────────────────────┘  │
└─────────────────────────────────────────────────────┘
```

**Infrastructure Decisions:**
- **Dual VirtualHost** — Complete application isolation; admin panel tidak dapat diakses dari domain publik
- **SSL/TLS termination** — Self-signed certificates (dev) / Let's Encrypt (prod) dengan HTTP→HTTPS 301 redirect
- **Timezone synchronization** — `TZ=Asia/Jakarta` environment variable memastikan konsistensi timestamp antara PHP dan MySQL
- **Volume mounting** — Source code di-mount langsung untuk hot-reload development tanpa rebuild

---


## 4. ALUR PENGEMBANGAN SISTEM (CHRONOLOGICAL DEVELOPMENT WORKFLOW)

> Berdasarkan analisis 88 commit pada branch `development` (21 Feb – 21 Mei 2026)

### Tahap 1: Inisialisasi & Containerization (21 Feb – 2 Mar 2026)

**Commits:** `20fb005` → `ad2a3f4` (8 commits)

| Milestone | Detail Teknis |
|-----------|---------------|
| Repository initialization | README.md + Software Design Document |
| Docker scaffold | `Dockerfile` (PHP 8.2 + Apache), `docker-compose.yml` (web + db + phpmyadmin) |
| Application skeleton | `Database.php` (PDO singleton), `Controller.php` (base class), `Env.php` (dotenv parser) |
| Apache VirtualHost | Single vhost pointing `/public/` as DocumentRoot |
| Security fix | Removed accidentally committed `.env` file; moved `.gitignore` to root |
| Migration system | Initial `Migration.php` with versioned SQL execution |

**Key Engineering Decision:** Containerization-first approach memastikan environment parity antara development dan production sejak hari pertama.

---

### Tahap 2: Standardisasi CI/CD & Linting (3 – 4 Mar 2026)

**Commits:** `c3096ee` → `91e9546` (13 commits)

| Pipeline Component | Implementation |
|-------------------|----------------|
| PHP Syntax Linting | `find . -name "*.php" -exec php -l {} \;` dalam GitHub Actions |
| Security Scanning | Automated vulnerability detection pada push events |
| Docker Build Test | Validasi bahwa `docker build` berhasil tanpa error |
| Workflow naming | Renamed `deploy.yml` → `cd.yml` untuk konvensi standar |

**Iterasi yang Terjadi:**
1. Awalnya menambahkan PHPStan + PHP CodeSniffer + Composer → **dihapus** (commit `56f9a00`) karena over-engineering untuk skala proyek
2. Docker service testing di CI → **dihapus** karena limitasi GitHub Actions runner
3. Final CI: PHP linting + security scan only (lean pipeline)

**Lesson:** Start with minimal CI, expand only when complexity demands it.

---

### Tahap 3: Perancangan Arsitektur Database & Migrasi (14 Mar – 1 Apr 2026)

**Commits:** `d0f41f2` → `349ff43` (12+ commits pada Migration.php)

**Schema Evolution Timeline:**

```sql
-- v1.0: Core tables
mhs_whitelist (npm PK, nama)
aspirasi (id, npm_pelapor FK, judul, deskripsi, kategori ENUM, status ENUM, anonim BOOL)

-- v1.1: Response system
tanggapan (id, id_aspirasi FK, isi_tanggapan, admin_id FK)

-- v1.2: Admin management
admin_web (admin_id, usn_adm UNIQUE, pw_adm VARCHAR(255), role_adm ENUM)

-- v1.5: Session tracking
user_sessions (id, npm FK, session_token, ip_address, user_agent, timestamps)

-- v2.0: Bulletin board
ALTER aspirasi ADD show_on_board BOOLEAN, board_approved BOOLEAN

-- v2.1: Reaction system
aspirasi_reactions (id, id_aspirasi FK, npm_reactor FK, reaction_type, UNIQUE KEY)

-- v2.2: Report system
aspirasi_reports (id, id_aspirasi FK, npm_reporter FK, reason ENUM, status ENUM)
```

**Migration Design Patterns:**
- `CREATE TABLE IF NOT EXISTS` — Idempotent execution (safe to re-run)
- `INSERT IGNORE` — Seed data tanpa duplicate errors
- `password_hash('admin123', PASSWORD_BCRYPT)` — Hashed default credentials in migration
- Sequential versioning comments (`// Versi 1.0`, `// Versi 2.1`) — Human-readable changelog

---

### Tahap 4: Implementasi Autentikasi & Pengerasan Sesi (1 – 2 Apr 2026)

**Commits:** `b3e45f4` → `7183bf8` (8 commits)

| Security Layer | Implementation |
|---------------|----------------|
| **CSRF Protection** | `bin2hex(random_bytes(32))` token generation; validated via `hash_equals()` |
| **Session Timeout** | 60-minute absolute timeout; 5-minute warning threshold |
| **Session Regeneration** | `session_regenerate_id(true)` on login — prevents fixation attacks |
| **Session Fingerprinting** | `md5(HTTP_USER_AGENT)` + `REMOTE_ADDR` stored in session for validation |
| **Cookie Hardening** | `httponly=true`, `samesite=Strict`, `use_strict_mode=true` |
| **Dual Rate Limiting** | IP-based (5 attempts/15min) + NPM-based (3 attempts/10min) |
| **Security Logging** | JSON-structured log files per day (`security_YYYY-MM-DD.log`) |

**Authentication Flow:**
```
User submits NPM → Rate limit check (IP + NPM) → CSRF validation
    → Regex sanitization (/[^0-9]/) → Length validation (10 digits)
        → Year prefix validation (20-24) → Pattern anomaly detection
            → Whitelist DB lookup (prepared statement)
                → Session creation + regeneration + CSRF token refresh
                    → JSON response with user data
```

---

### Tahap 5: Pengembangan Fitur Utama & Komponen (3 – 7 Apr 2026)

**Commits:** `ff79287` → `f7a7dbb` (25+ commits)

#### 5.1 Bulletin Board System

| Component | Technical Detail |
|-----------|-----------------|
| **Data fetching** | Async `fetch()` with category query parameter; paginated (12 items/page) |
| **Masonry grid** | CSS Grid 3-column responsive layout with randomized card rotation |
| **Skeleton loading** | 9x placeholder divs with `animate-pulse` class during fetch |
| **Category filtering** | Client-side button state management + server-side `WHERE kategori = ?` |
| **Reaction engine** | Toggle-based like system with `UNIQUE KEY (id_aspirasi, npm_reactor)` constraint |
| **Report system** | Modal-based reporting with reason enum (Inappropriate, Spam, Offensive) |

#### 5.2 Admin Panel MVC Architecture

| Component | Implementation |
|-----------|---------------|
| **Router** | `switch($action)` dispatch in `routes.php`; default → dashboard |
| **Base Controller** | Abstract class with `renderLayout()`, auth guard, model initialization |
| **View Rendering** | Output buffering (`ob_start/ob_get_clean`) + `extract()` for variable scope isolation |
| **Layout System** | `main.php` layout wraps view content with header + sidebar |
| **Role-based access** | `hasRole($role)` method checking session-stored admin role |

#### 5.3 Aspiration Submission Pipeline

```
Form Submit → POST /api/submit-aspirasi.php
    → Auth check (session valid?)
        → Input extraction ($_POST)
            → Whitelist validation (kategori ∈ ['Akademik','Fasilitas','Sarpras','Layanan','UKT','Lainnya'])
                → Input truncation (judul: 255 chars, deskripsi: 5000 chars)
                    → Anonymity handling (npm → "anonim" if flag set)
                        → Model::create() with prepared statement
                            → HTTP 201 + JSON response
```

---

### Tahap 6: Refactoring & Aksesibilitas (20 – 21 Mei 2026)

**Commits:** `ad03984` → `dad712a` (6 commits)

| Refactoring Area | Before → After |
|-----------------|----------------|
| **Icon system** | Inline SVG / no icons → Lucide Icons (`data-lucide` attributes) |
| **Password auth** | NPM-only login → NPM + password with `change-password.php` API |
| **Accessibility** | Generic `<div>` buttons → Semantic `<button>` with ARIA labels |
| **Code cleanup** | `console.log()` debug statements → removed for production |
| **Error handling** | PHP errors displayed → `error_reporting(0)` in production |
| **Layout** | Inconsistent markup → Standardized component structure |

---


## 5. BEDAH ALGORITMA & LOGIKA UTAMA (CORE ALGORITHMS & CORE LOGIC)

### 5.1 Algoritma Validasi & Auto-Format Input NPM

**Problem:** NPM mahasiswa harus tepat 10 digit numerik dengan prefix tahun valid (20–24). User bisa memasukkan karakter non-numerik, spasi, atau pola mencurigakan.

**Solusi — Multi-Layer Validation Pipeline:**

```php
// Layer 1: Sanitization — Strip ALL non-numeric characters
$npm = preg_replace('/[^0-9]/', '', $npm);

// Layer 2: Length validation — Exactly 10 digits
if (strlen($npm) !== 10) → REJECT

// Layer 3: Semantic validation — Year prefix must be 20-24
$year = (int) substr($npm, 0, 2);
if ($year < 20 || $year > 24) → REJECT

// Layer 4: Anomaly detection — All-same-digit pattern
if (count(array_unique(str_split($npm))) === 1) → REJECT + LOG

// Layer 5: Database verification — Whitelist lookup
$stmt = $pdo->prepare("SELECT npm, nama FROM mhs_whitelist WHERE npm = ?");
```

**Kompleksitas:** O(1) untuk setiap layer (regex, string ops, array unique, single DB lookup dengan indexed PK).

**Auto-Format di Frontend:**
```javascript
// Real-time formatting saat user mengetik (client-side)
input.addEventListener('input', (e) => {
    e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 10);
});
```

---

### 5.2 Mekanisme CSRF Protection Lifecycle

**Problem:** Stateful form submissions rentan terhadap Cross-Site Request Forgery — attacker bisa membuat form palsu yang mengirim request ke server atas nama user yang sudah login.

**Solusi — Token-Based Stateful Validation:**

```
┌─────────────────────────────────────────────────────────────┐
│                    CSRF TOKEN LIFECYCLE                       │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  1. GENERATION (on login success):                           │
│     $_SESSION['csrf_token'] = bin2hex(random_bytes(32));     │
│     → 64-character hex string (256-bit entropy)              │
│                                                              │
│  2. EMBEDDING (in HTML response):                            │
│     <meta name="csrf-token" content="<?= $token ?>">        │
│     → Token dikirim ke client sebagai meta tag               │
│                                                              │
│  3. TRANSMISSION (on state-changing request):                │
│     fetch(url, {                                             │
│       headers: { 'X-CSRF-Token': token }                     │
│     });                                                      │
│     → Token dikirim via custom HTTP header                   │
│                                                              │
│  4. VALIDATION (server-side):                                │
│     $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'];              │
│     hash_equals($_SESSION['csrf_token'], $csrfToken);        │
│     → Timing-safe comparison prevents timing attacks         │
│                                                              │
│  5. REGENERATION (post-login):                               │
│     Session::generateCSRFToken(); // new token per session   │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

**Mengapa `hash_equals()` bukan `===`?**
- Operator `===` melakukan byte-by-byte comparison yang berhenti pada mismatch pertama
- Timing side-channel: attacker bisa mengukur response time untuk menebak token karakter per karakter
- `hash_equals()` selalu membandingkan seluruh string dalam waktu konstan (constant-time comparison)

---

### 5.3 Logika Manajemen Sesi & Keamanan

**Problem:** Session fixation, session hijacking, dan stale sessions merupakan attack vectors utama pada sistem berbasis session.

**Solusi — Defense-in-Depth Session Management:**

```php
// === SESSION CONFIGURATION ===
session_start([
    'cookie_httponly' => true,      // JS tidak bisa akses cookie
    'cookie_secure'  => false,     // true di production (HTTPS only)
    'use_strict_mode' => true,     // Reject uninitialized session IDs
    'cookie_samesite' => 'Strict', // No cross-site cookie sending
    'cookie_lifetime' => 3600      // 60-minute absolute lifetime
]);
```

**Session Lifecycle State Machine:**

```
[UNAUTHENTICATED] ──login()──→ [ACTIVE]
        ↑                          │
        │                    ┌─────┴─────┐
        │                    │           │
        │              check_timeout   check_fingerprint
        │                    │           │
        │              elapsed > 3600?  UA/IP changed?
        │                    │           │
        │                  YES         YES
        │                    │           │
        └────destroy()───────┴───────────┘
                                         
[ACTIVE] ──────────────────→ [WARNING] (remaining ≤ 300s)
[ACTIVE] ──────────────────→ [EXPIRED] (remaining = 0)
[ACTIVE] ──────logout()────→ [DESTROYED]
```

**Session Fingerprinting Algorithm:**
```php
// On login:
$_SESSION['user_agent'] = md5($_SERVER['HTTP_USER_AGENT']);
$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];

// On every request (implicit via Session::start()):
// If user_agent or ip_address changes → session is potentially hijacked
// → Force destroy and re-authenticate
```

**Dual Rate Limiting Algorithm:**
```php
// Two independent counters with different windows:
// 1. IP-based: max 5 attempts per 15 minutes (900 seconds)
// 2. NPM-based: max 3 attempts per 10 minutes (600 seconds)

// Sliding window implementation:
if ($now - $lastAttempt < $window) {
    if ($count >= $maxAttempts) → HTTP 429 + retry_after header
} else {
    $counter = reset; // Window expired, start fresh
}

// On successful login: both counters are cleared (unset)
```

---

### 5.4 Algoritma Filtering & State Management Papan Buletin

**Problem:** Bulletin board harus menampilkan aspirasi yang sudah disetujui, dengan filtering per kategori, pagination, dan real-time reaction counts — tanpa full page reload.

**Solusi — Async State Machine dengan Server-Side Filtering:**

```javascript
// === CLIENT-SIDE STATE ===
let currentCategory = 'all';  // Active filter
let currentPage = 1;          // Pagination cursor
const limit = 12;             // Items per page
let isLoading = false;        // Debounce flag

// === FETCH PIPELINE ===
async function loadAspirations(category, page, append) {
    if (isLoading) return;           // Prevent concurrent requests
    isLoading = true;
    
    // Show skeleton (perceived performance)
    if (!append) showSkeletons(9);
    
    // Server request with query params
    const response = await fetch(
        `./api/board/aspirations.php?category=${category}&page=${page}`
    );
    const result = await response.json();
    
    // Render or show empty state
    if (result.data.length > 0) renderCards(result.data, append);
    else showEmptyState();
    
    // Toggle "Load More" button visibility
    toggleLoadMore(result.data.length === limit);
    
    isLoading = false;
}
```

**Server-Side Query Construction (Dynamic WHERE clause):**
```php
// Base query — only approved board items
$query = "SELECT ... FROM aspirasi a 
          WHERE a.show_on_board = TRUE AND a.board_approved = TRUE";
$params = [];

// Conditional category filter (parameterized)
if ($category && $category !== 'all') {
    $query .= " AND a.kategori = ?";
    $params[] = $category;
}

// Pagination via LIMIT/OFFSET (integer-cast to prevent injection)
$query .= " ORDER BY a.created_at DESC 
            LIMIT " . ((int)$limit) . " OFFSET " . ((int)$offset);

$stmt = $this->pdo->prepare($query);
$stmt->execute($params);
```

**Category Filter UI State Management:**
```javascript
// Event delegation on filter buttons
document.querySelectorAll('.category-filter').forEach(btn => {
    btn.addEventListener('click', () => {
        // 1. Update visual state (active class toggle)
        document.querySelector('.category-filter.active').classList.remove('active');
        btn.classList.add('active');
        
        // 2. Update application state
        currentCategory = btn.dataset.category;
        currentPage = 1; // Reset pagination on filter change
        
        // 3. Trigger data reload
        loadAspirations(currentCategory, 1, false);
    });
});
```

**Reaction Toggle Pattern (Idempotent):**
```sql
-- UNIQUE KEY constraint prevents duplicate reactions
UNIQUE KEY unique_reaction (id_aspirasi, npm_reactor)

-- Toggle logic: INSERT on first click, DELETE on second
-- Server checks hasUserReacted() before deciding INSERT vs DELETE
```

---

## 6. KESIMPULAN & PELAJARAN TEKNIS (LESSONS LEARNED & TECHNICAL TAKEAWAYS)

### 6.1 Architectural Insights

| Insight | Evidence from Commits |
|---------|----------------------|
| **Start containerized, stay containerized** | Docker setup di commit ke-3 (`c4829f2`); zero "works on my machine" issues sepanjang development |
| **MVC refactor is inevitable** | Admin panel dimulai sebagai flat files (commit `9b3b966`) → full MVC refactor dalam 1 commit besar (`b1002a7`) — lebih baik design MVC dari awal |
| **Lean CI beats comprehensive CI** | PHPStan + PHPCS ditambahkan lalu dihapus dalam hari yang sama — over-tooling menghambat velocity |
| **Security is not a feature, it's a layer** | CSRF, rate limiting, session hardening diimplementasikan sebagai cross-cutting concerns, bukan per-endpoint |

### 6.2 Frontend Engineering Lessons

| Lesson | Implementation |
|--------|---------------|
| **Skeleton loaders > spinners** | `animate-pulse` divs memberikan spatial context tentang layout yang akan muncul |
| **Async fetch > form submit** | Semua API calls menggunakan `fetch()` + JSON — no full page reloads |
| **CSS utility-first scales** | Tailwind classes langsung di HTML mengeliminasi CSS file management overhead |
| **Icon libraries > inline SVG** | Migrasi dari inline SVG ke Lucide Icons (commit `dad712a`) mengurangi markup bloat |
| **Semantic HTML matters** | Commit `410f2fb` mengubah `<div onclick>` menjadi `<button>` — accessibility compliance |

### 6.3 Security Engineering Lessons

| Lesson | Technical Detail |
|--------|-----------------|
| **Never commit secrets** | `.env` committed lalu dihapus (commit `9211e05`) — damage already done; gunakan `.gitignore` dari awal |
| **Hash passwords in migrations** | Awalnya plaintext → refactored ke `password_hash()` (commit `842c035`) |
| **Rate limiting needs dual vectors** | IP-only rate limiting bisa di-bypass via proxy; NPM-based limiting menambah layer kedua |
| **`hash_equals()` over `===`** | Timing-safe comparison mencegah timing side-channel attacks pada token validation |
| **Session regeneration on auth state change** | `session_regenerate_id(true)` pada login mencegah session fixation |

### 6.4 Development Process Lessons

| Lesson | Evidence |
|--------|----------|
| **Commit messages matter** | Conventional commits (`feat:`, `fix:`, `ci:`, `chore:`) memudahkan audit dan changelog generation |
| **Iterative > big-bang** | 88 commits dalam 90 hari = rata-rata 1 commit/hari; small, focused changes |
| **Documentation as code** | SDD, Docker guides, dan operational docs di-maintain dalam repository |
| **Fix typos immediately** | `Form-ConfrmationAspirasi.php` → `Form-ConfirmationAspirasi.php` (commit `bf57381`) — typos in filenames cause import errors |

---

## 📎 LAMPIRAN: STATISTIK REPOSITORY

| Metric | Value |
|--------|-------|
| Total commits (development branch) | 88 |
| Development period | 90 days (21 Feb – 21 May 2026) |
| Active development days | 22 |
| Peak day | 5 April 2026 (16 commits) |
| Most modified file | `vocational/public/index.php` (~30 modifications) |
| Total unique files created | 80+ |
| Lines of PHP code (estimated) | 3,000+ |
| Database tables | 7 |
| API endpoints | 12+ |
| Security layers | 6 (CSRF, rate limit ×2, session hardening, input validation, prepared statements) |

---

*Dokumen ini di-generate berdasarkan analisis commit history branch `development` dan source code review pada 27 Mei 2026.*
