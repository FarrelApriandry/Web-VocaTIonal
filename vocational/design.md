# Design Document — `public/index.php` (Beranda)

## Overview

The homepage serves as the primary entry point for VocaTIonal. It handles two states: **unauthenticated** (login modal) and **authenticated** (aspiration submission form). The page uses a skeleton-to-content transition pattern for perceived performance.

---

## Page States

| State | Behavior |
|-------|----------|
| Not logged in | Login modal overlays the skeleton loader. Main content stays hidden. |
| Logged in | Skeleton fades out → aspiration form fades in (1.5s delay). |

---

## Layout Structure

```
<body>
├── [Skip Link] ─────────────── (a11y: skip to #main-content)
├── <nav> ───────────────────── Navbar (sticky, z-50)
│   ├── Logo (link to /)
│   ├── Desktop nav links
│   ├── Mobile menu toggle
│   └── Profile dropdown trigger
├── <main id="main-content">
│   ├── <header> ────────────── Hero heading + subtitle
│   ├── #skeleton-loader ────── Pulse animation placeholder (aria-hidden)
│   └── #aspiration-content ─── Hidden initially, revealed via JS
│       ├── <section> ───────── Aspiration form (2/3 width on lg)
│       │   ├── Category radiogroup (6 buttons)
│       │   ├── Subject input
│       │   ├── Detail textarea + char counter
│       │   ├── File upload (drag area + preview)
│       │   ├── Anonim switch (role=switch)
│       │   └── Submit button
│       └── <aside> ─────────── Sidebar (1/3 width on lg)
│           ├── System status card (info-card)
│           └── Anonymity guide (ordered list)
├── #login-modal (if !logged in) ── role=dialog, aria-modal
│   ├── Logo
│   ├── NPM input (with auto-format XX.X.XX.XX.XXX)
│   ├── Password input
│   ├── Error region (role=alert, aria-live=assertive)
│   └── Submit button
└── Scripts + Confirmation modals
```

---

## Security Layers

| Layer | Implementation |
|-------|---------------|
| CSRF | Token generated on page load (`$_SESSION['csrf_token']`), sent in form body |
| Session | 60-min timeout, fingerprinting (IP + user-agent hash), regeneration on login |
| Input validation | Client-side (NPM format, file type/size, maxlength) + server-side |
| XSS prevention | `sanitizeHTML()` for display, `htmlspecialchars()` for PHP output |
| Headers | X-Content-Type-Options, X-Frame-Options, X-XSS-Protection, Referrer-Policy, Permissions-Policy |
| Rate limiting | IP-based (5/15min) + NPM-based (3/10min) in `login.php` |

---

## Authentication Flow

```
[User visits /] 
    → session_start()
    → Generate CSRF token if missing
    → Auth::check() → Session valid?
        ├── YES → $isLoggedIn = true, render form, skeleton→fade-in
        └── NO  → $isLoggedIn = false, render login modal
                    → User submits NPM + Password
                    → POST /api/login.php (JSON)
                        → Rate limit check
                        → Whitelist lookup (prepared statement)
                        → password_verify()
                        → Session creation + regeneration
                        → Response → JS hides modal, reloads page
```

---

## Component Dependencies

| Component | Path | Purpose |
|-----------|------|---------|
| Header.php | `app/Views/Components/Header.php` | `<head>`, Tailwind CDN, Poppins font, Lucide icons, global CSS, skip link |
| Navbar.php | `app/Views/Components/Navbar.php` | Navigation bar, profile dropdown, mobile menu |
| ConfirmationModal.php | `app/Views/Components/ConfirmationModal.php` | Reusable confirm/cancel dialog |
| Form-ConfirmationAspirasi.php | `app/Views/Components/Form-ConfirmationAspirasi.php` | Aspiration preview before submit |
| toast.js | `public/js/toast.js` | Toast notification system |
| confirmation-modal.js | `public/js/confirmation-modal.js` | Modal open/close logic (`window.confirmationModal`) |

---

## CSS Architecture

- **Framework:** Tailwind CSS (CDN, no build step)
- **Custom classes** (defined in Header.php `<style>`):
  - `.glass-card` — White card with rounded corners + border
  - `.btn-category` — Category toggle button (border, rounded)
  - `.btn-category.active` — Blue-900 background, white text
  - `.info-card` — Blue-900 background card
  - `.fade-out` / `.fade-in` — Opacity transitions
  - `#aspiration-content` — Starts at opacity:0, translateY(10px)
  - `.skip-link` — Off-screen until focused

---

## Accessibility (WCAG 2.2 AA)

| Criterion | Implementation |
|-----------|---------------|
| 1.3.1 Info & Relationships | Semantic HTML: `<main>`, `<header>`, `<section>`, `<aside>`, `<fieldset>`, `<legend>`, `<ol>` |
| 1.4.3 Contrast (Minimum) | All text ≥ 4.5:1 ratio (gray-600/700 on white, white on blue-900) |
| 2.1.1 Keyboard | All controls focusable, switch responds to Space/Enter |
| 2.4.1 Bypass Blocks | Skip-to-content link |
| 2.4.7 Focus Visible | `focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2` |
| 3.3.2 Labels | Explicit `<label for="">` on all inputs |
| 4.1.2 Name, Role, Value | `role=radiogroup`, `role=radio`, `aria-checked`, `role=switch`, `role=dialog`, `aria-modal`, `aria-pressed` |
| 4.1.3 Status Messages | `aria-live=polite` on char counter, `aria-live=assertive` on login error |

---

## JavaScript Modules

### 1. Utility Functions
- `sanitizeHTML(text)` — Escapes `& < > " '`
- `validateNPM(npm)` — Checks 10-digit format
- `validateFile(file)` — Type (JPEG/PNG/GIF/WebP) + size (5MB max)

### 2. Skeleton Transition
- On DOMContentLoaded: if logged in, fade skeleton → show content after 1.5s
- `handleLoginSuccess()` — Same transition triggered after login API success

### 3. Category Selection
- Click toggles `active` class + `aria-checked` attribute
- Updates hidden `#selected-category` input

### 4. Anonim Switch
- Custom `role=switch` with keyboard support (Space/Enter)
- Toggles hidden checkbox + `aria-checked`

### 5. Image Preview
- FileReader for client-side preview
- Validates before display
- Remove button clears state

### 6. Login Form
- Auto-formats NPM as `XX.X.XX.XX.XXX`
- Validates client-side before fetch
- Errors displayed in `aria-live` region (no `alert()`)
- Disables button during request

### 7. Aspiration Submission
- Opens confirmation modal with sanitized preview
- Sends FormData (supports file upload)
- Resets form + ARIA states on success

### 8. Session Management
- Warning modal at 5 minutes remaining
- Auto-logout modal when session expires
- Logout via confirmation modal → POST /api/logout.php

---

## API Endpoints Used

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/login.php` | POST | Authenticate NPM + password |
| `/api/logout.php` | POST | Destroy session |
| `/api/submit-aspirasi.php` | POST | Submit new aspiration (FormData) |

---

## Responsive Breakpoints

| Breakpoint | Layout |
|------------|--------|
| Mobile (default) | Single column, full-width form |
| `md` (768px) | Larger padding, bigger headings |
| `lg` (1024px) | 3-column grid (form 2/3, sidebar 1/3) |
| `xl` (1280px) | Detail textarea + file upload side-by-side |
