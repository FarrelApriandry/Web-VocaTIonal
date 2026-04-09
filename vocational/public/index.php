<?php 
// SUPPRESS ERRORS DI PRODUCTION - PREVENT HTML WARNINGS MIXED WITH JSON
ini_set('display_errors', '0');
error_reporting(E_ALL);

// ============================================
// SECURITY: Add essential security headers
// ============================================
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

// START SESSION SEBELUM OUTPUT APAPUN (PENTING!)
session_start();

// 1. Definisikan Props
$title = "VocaTIonal | Aspirasi Mahasiswa";
$active = "beranda";

// 2. Import Header & Navbar
include __DIR__ . '/../app/Views/Components/Header.php';
include __DIR__ . '/../app/Views/Components/Navbar.php';
?>
    <main class="mx-auto px-6 md:px-16 py-8 md:py-16">
        <header class="mb-8 md:mb-12">
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                Halo, Mahasiswa <span class="text-blue-900">Teknologi Informasi!</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-500">Ada aspirasi atau keluhan? Suarakan di bawah ini.</p>
        </header>

        <div id="skeleton-loader" class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-pulse">
            <div class="lg:col-span-2 glass-card p-6 md:p-10 shadow-sm border-none bg-gray-200/50">
                <div class="h-4 bg-gray-300 rounded-full w-48 mb-6"></div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                </div>
                <div class="flex flex-col xl:flex-row gap-3">
                    <div class="flex-1 space-y-6">
                        <div class="h-14 bg-gray-300 rounded-xl"></div>
                        <div class="h-48 bg-gray-300 rounded-xl"></div>
                    </div>
                    <div class="flex-1 h-[200px] bg-gray-300 rounded-2xl"></div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="h-40 bg-gray-300 rounded-2xl"></div>
                <div class="h-64 bg-gray-300 rounded-2xl"></div>
            </div>
        </div>

        <div id="main-content" class="hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 glass-card p-6 md:p-10 shadow-sm">
                <form id="submissionForm">
                    <!-- SECURITY: Add CSRF token field -->
                    <input type="hidden" name="csrf_token" id="csrf-token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    
                    <table class="w-full border-separate border-spacing-y-4">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-4">Pilih Kategori Laporan</p>
                                    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3 md:gap-4">
                                        <button type="button" class="btn-category active py-3 md:py-4 font-semibold text-sm md:text-base">Akademik</button>
                                        <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">Fasilitas</button>
                                        <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">Sarpras</button>
                                        <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">Layanan</button>
                                        <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">UKT</button>
                                        <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">Lainnya</button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="hidden xl:table-cell w-[120px] align-middle">
                                    <label class="text-xs font-bold text-gray-400 uppercase">Subjek</label>
                                </td>
                                <td>
                                    <input id="aspirasi-subjek" type="text" placeholder="Subjek Laporan..." maxlength="100"
                                        class="w-full bg-gray-50 border border-[#64748B] rounded-xl px-4 py-4 focus:outline-none focus:ring-1 focus:ring-[#64748B]">
                                </td>
                            </tr>

                            <tr>
                                <td class="hidden xl:table-cell align-top py-4">
                                    <label class="text-xs font-bold text-gray-400 uppercase">Konten</label>
                                </td>
                                <td>
                                    <div class="flex flex-col xl:flex-row gap-4">
                                        <div class="flex-1 relative">
                                            <textarea id="aspirasi-detail" rows="6" placeholder="Detail Laporan..." maxlength="500"
                                                    class="w-full h-48 bg-gray-50 border border-[#64748B] rounded-xl px-4 py-4 focus:outline-none focus:ring-1 focus:ring-[#64748B]"></textarea>
                                            <span class="absolute bottom-4 right-4 text-xs text-gray-400"><span id="char-count">0</span>/500 Karakter</span>
                                        </div>
                                        
                                        <label class="flex-1 border-2 border-dashed border-[#64748B] rounded-2xl flex flex-col items-center justify-center p-8 cursor-pointer hover:bg-gray-50 transition-all min-h-[200px] relative overflow-hidden text-center">
                                            <input type="file" id="bukti_foto" name="bukti_foto" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                            <div id="upload-placeholder" class="flex flex-col items-center">
                                                <i data-lucide="camera" class="text-[#64748B] w-10 h-10 mb-4"></i>
                                                <p class="font-bold text-[#64748B]">Upload Bukti</p>
                                            </div>
                                            <div id="preview-container" class="hidden absolute inset-0 bg-white flex items-center justify-center p-2">
                                                <img id="image-preview" src="#" class="max-h-full max-w-full rounded-xl object-contain">
                                                <button type="button" id="remove-img" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full shadow-lg z-20">
                                                    <i data-lucide="x" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" class="pt-6">
                                    <div class="flex flex-col sm:flex-row justify-between items-center gap-6">
                                        <label class="flex items-center cursor-pointer group self-start">
                                            <div class="relative">
                                                <input type="checkbox" class="sr-only">
                                                <div class="block bg-gray-300 w-12 h-7 md:w-14 md:h-8 rounded-full transition"></div>
                                                <div class="dot absolute left-1 top-1 bg-white w-5 h-5 md:w-6 md:h-6 rounded-full transition shadow-sm"></div>
                                            </div>
                                            <span class="ml-3 text-gray-700 font-semibold text-sm md:text-base">Kirim Anonim</span>
                                        </label>

                                        <button id="btn-show-confirm" type="button" 
                                                class="w-full sm:w-auto bg-[#111827] text-white px-10 py-4 rounded-xl font-medium uppercase tracking-widest hover:bg-black transition-all text-sm md:text-base">
                                            Kirim Aspirasi
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="w-full">
                <table class="w-full border-separate border-spacing-y-6">
                    <tbody>
                        <tr>
                            <td>
                                <div class="info-card p-6 md:p-8 shadow-lg">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                        <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-white">System Operational</span>
                                    </div>
                                    <h3 class="text-base md:text-lg font-bold mb-2 text-white">Network Transparency</h3>
                                    <p class="text-xs md:text-sm text-blue-100 leading-relaxed">
                                        Layanan aspirasi berjalan di atas protokol enkripsi satu arah. Data Anda aman dan anonim.
                                    </p>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="bg-gray-100 border border-gray-200 rounded-2xl p-6 md:p-8">
                                    <p class="text-xs md:text-sm font-bold text-gray-900 uppercase tracking-widest mb-6">Panduan Anonimitas</p>
                                    
                                    <table class="w-full border-separate border-spacing-y-4">
                                        <tr>
                                            <td class="align-top w-8"><span class="font-bold text-blue-900 text-sm">01</span></td>
                                            <td class="text-xs md:text-sm text-gray-600 font-medium leading-relaxed">
                                                <span class="font-bold text-gray-900">Bersihkan Identitas:</span> Hindari menyebutkan nama atau NIM dalam subjek dan detail laporan.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-top w-8"><span class="font-bold text-blue-900 text-sm">02</span></td>
                                            <td class="text-xs md:text-sm text-gray-600 font-medium leading-relaxed">
                                                <span class="font-bold text-gray-900">Sensor Bukti:</span> Pastikan foto bukti tidak mengandung informasi pribadi yang tidak relevan.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-top w-8"><span class="font-bold text-blue-900 text-sm">03</span></td>
                                            <td class="text-xs md:text-sm text-gray-600 font-medium leading-relaxed">
                                                <span class="font-bold text-gray-900">Metadata Strip:</span> Sistem otomatis menghapus data lokasi (EXIF) pada setiap gambar yang diunggah.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-top w-8"><span class="font-bold text-blue-900 text-sm">04</span></td>
                                            <td class="text-xs md:text-sm text-gray-600 font-medium leading-relaxed">
                                                <span class="font-bold text-gray-900">Session Purge:</span> Tutup browser setelah melapor untuk menghapus jejak sesi pada perangkat.
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <input type="hidden" name="kategori" id="selected-category" value="Akademik">

    <script>
        // ============================================
        // SECURITY: Input Validation Helper Functions
        // ============================================
        
        // XSS Prevention: Escape HTML entities
        function sanitizeHTML(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Validate npm format: XX.X.XX.XX.XXX (10 digits total)
        function validateNPM(npm) {
            const cleanNpm = npm.replace(/\./g, '');
            return /^\d{10}$/.test(cleanNpm);
        }

        // Validate file type and size
        function validateFile(file) {
            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            
            if (!file) return { valid: true, message: '' };
            if (!allowedTypes.includes(file.type)) {
                return { valid: false, message: 'Hanya file gambar (JPEG, PNG, GIF, WebP) yang diperbolehkan' };
            }
            if (file.size > maxSize) {
                return { valid: false, message: 'Ukuran file maksimal 5MB' };
            }
            return { valid: true, message: '' };
        }

        // Request origin validation
        function getCSRFToken() {
            return document.getElementById('csrf-token')?.value || '';
        }

        // ============================================
        // SKELETON TO CONTENT TRANSITION LOGIC
        // ============================================
        // Check login status from PHP
        const isLoggedInUser = <?= $isLoggedIn ? 'true' : 'false' ?>;
        
        window.addEventListener('DOMContentLoaded', () => {
            const skeleton = document.getElementById('skeleton-loader');
            const content = document.getElementById('main-content');

            // JIKA SUDAH LOGIN, LANGSUNG FADE OUT SKELETON
            if (isLoggedInUser) {
                setTimeout(() => {
                    skeleton.classList.add('fade-out');

                    setTimeout(() => {
                        skeleton.style.display = 'none';
                        content.classList.remove('hidden');
                        
                        setTimeout(() => {
                            content.classList.add('fade-in');
                            lucide.createIcons();
                        }, 50);
                    }, 500); 
                }, 1500);
            } else {
                // JIKA BELUM LOGIN, SKELETON TETAP VISIBLE DI BACKGROUND MODAL
                // Jangan hide skeleton, let it stay behind modal
                // Modal akan tampil di atas skeleton
            }
        });
        
        // HANDLE SUCCESSFUL LOGIN - HIDE SKELETON & SHOW CONTENT
        function handleLoginSuccess() {
            try {
                const skeleton = document.getElementById('skeleton-loader');
                const content = document.getElementById('main-content');
                const modal = document.getElementById('login-modal');
                
                // Hide modal
                if (modal) {
                    modal.style.display = 'none';
                }
                
                // Fade out skeleton
                if (skeleton) {
                    skeleton.classList.add('fade-out');
                }
                
                setTimeout(() => {
                    if (skeleton) {
                        skeleton.style.display = 'none';
                    }
                    if (content) {
                        content.classList.remove('hidden');
                    }
                    
                    setTimeout(() => {
                        if (content) {
                            content.classList.add('fade-in');
                        }
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    }, 50);
                }, 500);
            } catch (e) {
                // Silent error handling
            }
        }
        
        // CATEGORY SELECTION
        const categoryButtons = document.querySelectorAll('.btn-category');
        const categoryInput = document.getElementById('selected-category');
        const showBoardToggle = document.querySelector('input[type="checkbox"][data-show-board]');

        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                categoryButtons.forEach(btn => {
                    btn.classList.remove('active', 'text-white', 'bg-blue-900');
                    btn.classList.add('text-gray-500', 'hover:bg-gray-50');
                });
                button.classList.add('active', 'text-white', 'bg-blue-900');
                button.classList.remove('text-gray-500', 'hover:bg-gray-50');
                categoryInput.value = button.innerText;
            });
        });

        // ============================================
        // IMAGE PREVIEW LOGIC WITH VALIDATION
        // ============================================
        const fileInput = document.getElementById('bukti_foto');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        const removeBtn = document.getElementById('remove-img');

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                // SECURITY: Validate file
                const validation = validateFile(file);
                if (!validation.valid) {
                    alert(validation.message);
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        removeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            fileInput.value = "";
            previewContainer.classList.add('hidden');
            placeholder.classList.remove('hidden');
        });

        // Character counter for detail
        const detailTextarea = document.getElementById('aspirasi-detail');
        const charCount = document.getElementById('char-count');
        if (detailTextarea && charCount) {
            detailTextarea.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });
        }

        lucide.createIcons();
    </script>

    <?php 
    // Check login status using Auth class - VALIDASI SESSION KETAT
    require_once __DIR__ . '/../app/Controllers/Auth.php';
    $auth = new Auth();
    $isLoggedIn = $auth->check();
    
    // KALO UDAH LOGIN, LANGSUNG TAMPILIN CONTENT & SKIP MODAL
    if ($isLoggedIn) :
        $user = $auth->user();
        $remainingMinutes = floor($user['remaining_time'] / 60);
        $remainingSeconds = $user['remaining_time'] % 60;
    ?>
    <script>
        // Force hide skeleton, show content immediately for logged in users
        document.addEventListener('DOMContentLoaded', function() {
            const skeleton = document.getElementById('skeleton-loader');
            const content = document.getElementById('main-content');
            skeleton.style.display = 'none';
            content.classList.remove('hidden');
            content.classList.add('fade-in');
            if (typeof lucide !== 'undefined') lucide.createIcons();
            
            // Session timeout warning & auto-logout
            const remainingTime = <?php echo $user['remaining_time']; ?> * 1000; // Convert to milliseconds
            const warningThreshold = 5 * 60 * 1000; // 5 minutes in milliseconds
            
            // Show warning when < 5 minutes remaining
            if (remainingTime <= warningThreshold && remainingTime > 0) {
                const minutes = Math.floor(remainingTime / 60000);
                setTimeout(() => {
                    window.confirmationModal.open({
                        title: 'Peringatan: Session Akan Berakhir',
                        message: `Session Anda akan berakhir dalam ${minutes} menit. Silakan simpan pekerjaan Anda!`,
                        confirmText: 'Perpanjang Session',
                        cancelText: 'OK',
                        confirmBtnColor: 'orange',
                        onConfirm: async () => {
                            // Refresh page to extend session
                            window.location.href = window.location.href;
                        }
                    });
                }, 500);
            }
            
            // Auto logout when session expires
            if (remainingTime > 0) {
                setTimeout(() => {
                    window.confirmationModal.open({
                        title: 'Session Telah Berakhir',
                        message: 'Session Anda telah kadaluarsa. Silakan login kembali.',
                        confirmText: 'Login Kembali',
                        cancelText: 'Logout',
                        confirmBtnColor: 'blue',
                        onConfirm: async () => {
                            window.location.href = window.location.href;
                        },
                        onCancel: async () => {
                            window.location.href = './api/logout.php';
                        }
                    });
                }, remainingTime + 1000); // +1 second buffer
            }
            
            // Update countdown every minute
            setInterval(() => {
                // Optional: Show countdown timer in UI
                // console.log('Session remaining:', Math.floor((<?php echo $user['remaining_time']; ?> - (Date.now() - <?php echo time() * 1000; ?>)) / 1000 / 60), 'minutes');
            }, 60000);
        });
    </script>
    <?php 
    else : 
    // KALO BELUM LOGIN, TAMPILIN MODAL
    ?>

    <div id="login-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl p-8 w-[90%] max-w-md shadow-2xl flex flex-col items-center text-center">
        
            <img src="./assets/img/logo-himatif.svg" alt="Logo Himatif" class="w-16 h-16 object-contain mb-4">
        
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Akses Terbatas</h2>
            <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                Silahkan Masukkan Nomor Pokok Mahasiswa (NPM)<br>Untuk Melanjutkan.
            </p>
        
            <div class="w-full">
                <!-- SECURITY: CSRF token in login form -->
                <input type="hidden" name="csrf_token" id="login-csrf-token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                <input type="text" id="npm-input" name="npm" placeholder="XX.X.XX.XX.XXX" maxlength="14"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 mb-4 text-center font-medium tracking-widest text-gray-700 focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A]"
                    required>
            
                <button id="btn-login"  
                        class="w-full bg-[#1E3A8A] text-white rounded-xl px-4 py-3.5 font-semibold hover:bg-blue-900 transition-colors shadow-md text-sm md:text-base"
                        type="button">
                    Masuk Ke Dashboard
                </button>
            </div>
        
            <p class="text-[10px] md:text-xs text-gray-400 mt-6 font-medium">
                Data Anda Dienkripsi Secara End-To-End.
            </p>
        
        </div>
    </div>

    <?php endif; ?>

    <script>
        // ============================================
        // LOGIN FORM SECURITY & VALIDATION
        // ============================================
        const npmInput = document.getElementById('npm-input');
        if (npmInput) {
            npmInput.addEventListener('input', function(e) {
                let numbers = this.value.replace(/[^0-9]/g, '');

                let formatted = '';
                if (numbers.length > 0) formatted += numbers.substring(0, 2);   
                if (numbers.length > 2) formatted += '.' + numbers.substring(2, 3);  
                if (numbers.length > 3) formatted += '.' + numbers.substring(3, 5);  
                if (numbers.length > 5) formatted += '.' + numbers.substring(5, 7);  
                if (numbers.length > 7) formatted += '.' + numbers.substring(7, 10); 

                this.value = formatted;
            });
        }

        const btnSubmit = document.getElementById('btn-login');
        const loginModal = document.getElementById('login-modal');

        if (btnSubmit) {
            btnSubmit.addEventListener('click', async function(e) {
                e.preventDefault();

                const npm = npmInput.value.replace(/\./g, '');
                
                // SECURITY: Validate NPM format
                if (!validateNPM(npmInput.value)) {
                    alert('NPM harus 10 digit angka! Format: XX.X.XX.XX.XXX');
                    return;
                }
                
                // SECURITY: Get CSRF token
                const csrfToken = document.getElementById('login-csrf-token')?.value;
                if (!csrfToken) {
                    alert('Security Error: CSRF token tidak ditemukan');
                    return;
                }
                
                const originalText = this.innerText;
                this.innerText = 'Memproses...';
                this.disabled = true;
                
                try {
                    const response = await fetch('./api/login.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ 
                            npm: npm,
                            csrf_token: csrfToken
                        })
                    });

                    
                    // Get raw text first to handle non-JSON responses
                    const responseText = await response.text();
                    
                    try {
                        // Try to parse as JSON
                        const result = JSON.parse(responseText);
                        
                        if (result.success) {
                            // Update button text to "Mengalihkan halaman..."
                            this.innerText = 'Mengalihkan halaman...';
                            
                            // Try to get nama dari result jika parsing error
                            let displayName = 'Pengguna';
                            try {
                                const fallbackResult = JSON.parse(responseText);
                                displayName = fallbackResult.user?.nama || 'Pengguna';
                            } catch(e) {
                                displayName = 'Pengguna'; // Fallback ke generic
                            }
                            
                            alert(`Login berhasil! Selamat datang, ${sanitizeHTML(displayName)}.`);
                            
                            // Wait 2 seconds then redirect/reload
                            setTimeout(() => {
                                window.location.href = window.location.href;
                            }, 2000);
                        } else {
                            // Login gagal
                            alert('Login gagal: ' + (result.message || 'NPM tidak valid'));
                            npmInput.value = '';
                            npmInput.focus();
                            this.innerText = originalText;
                            this.disabled = false;
                        }
                    } catch (jsonError) {
                        // JSON parse error - likely server error or Cloudflare block
                        // But session might already be created on server
                        if (response.ok && responseText.length < 500) {
                            // Likely a server error page, but if response is "ok" (200),
                            // session might have been created. Auto-redirect.
                            this.innerText = 'Mengalihkan halaman...';
                            
                            // Call handleLoginSuccess to hide skeleton & show content
                            handleLoginSuccess();
                            
                            // Then reload after 2 seconds
                            setTimeout(() => {
                                window.location.href = window.location.href;
                            }, 2000);
                        } else {
                            // Actual error
                            alert('Terjadi kesalahan saat login. Silakan coba lagi.');
                            npmInput.value = '';
                            npmInput.focus();
                            this.innerText = originalText;
                            this.disabled = false;
                        }
                    }
                } catch (error) {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    this.innerText = originalText;
                    this.disabled = false;
                }
            });
        }

    </script>

    <?php 
        include __DIR__ . '/../app/Views/Components/ConfirmationModal.php';
        include __DIR__ . '/../app/Views/Components/Form-ConfirmationAspirasi.php';
    ?>

    <script src="./js/toast.js"></script>
    <script src="./js/confirmation-modal.js"></script>
    <script>
        // ==========================================
        // LOGOUT MODAL HANDLER
        // ==========================================
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('btn-logout-modal');
            
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function() {
                    window.confirmationModal.open({
                        title: 'Logout',
                        message: 'Apakah Anda yakin ingin logout dari akun Anda?',
                        confirmText: 'Ya, Logout',
                        cancelText: 'Batal',
                        confirmBtnColor: 'red',
                        onConfirm: async () => {
                            try {
                                const response = await fetch('./api/logout.php', {
                                    method: 'POST'
                                });
                                
                                if (response.ok) {
                                    // Show success message in modal
                                    const modal = document.getElementById('confirmation-modal');
                                    const modalBox = document.getElementById('confirmation-modal-box');
                                    const title = document.getElementById('confirmation-title');
                                    const message = document.getElementById('confirmation-message');
                                    const buttons = document.querySelector('#confirmation-modal-box > div:last-child');
                                    
                                    // Update modal content
                                    title.textContent = 'Logout Berhasil';
                                    message.textContent = 'Anda akan segera kembali ke halaman login...';
                                    buttons.style.display = 'none';
                                    
                                    // Add success icon animation
                                    const successIcon = document.createElement('div');
                                    successIcon.className = 'flex justify-center mb-6';
                                    successIcon.innerHTML = '<i data-lucide="check-circle" class="w-16 h-16 text-green-500"></i>';
                                    
                                    const messageEl = document.getElementById('confirmation-message');
                                    messageEl.parentElement.insertBefore(successIcon, messageEl);
                                    
                                    if (typeof lucide !== 'undefined') {
                                        lucide.createIcons();
                                    }
                                    
                                    // Wait 1.5 seconds then reload
                                    setTimeout(() => {
                                        window.location.href = window.location.href;
                                    }, 1500);
                                } else {
                                    throw new Error('Logout gagal');
                                }
                            } catch (error) {
                                alert('Terjadi kesalahan saat logout. Silakan coba lagi.');
                            }
                        }
                    });
                });
            }
        });
    </script>

    <script>
        // MODAL LOGIC
        const modal = document.getElementById('modal-confirm');
        const modalBox = document.getElementById('modal-box');
        const btnKirimAspirasi = document.getElementById('btn-show-confirm');
        const showBoardCheckbox = document.querySelector('input[data-show-board]');

        if (btnKirimAspirasi) {
            btnKirimAspirasi.addEventListener('click', function(e) {
                e.preventDefault();

                // 1. Ambil Data
                const kategoriEl = document.getElementById('selected-category');
                const kategori = kategoriEl ? kategoriEl.value : 'Akademik';
                const subjekEl = document.getElementById('aspirasi-subjek');
                const subjek = subjekEl ? subjekEl.value : '';
                const detailEl = document.getElementById('aspirasi-detail');
                const detail = detailEl ? detailEl.value : '';
                const anonimCheckboxEl = document.querySelector('input[type="checkbox"]:not([data-show-board])');
                const isAnonim = anonimCheckboxEl ? anonimCheckboxEl.checked : false;
                const showOnBoard = showBoardCheckbox ? showBoardCheckbox.checked : false;
                
                const previewImgSrc = document.getElementById('image-preview').src;
                const hasImage = !document.getElementById('preview-container').classList.contains('hidden');

                // 2. SECURITY: Validasi Form dengan strict checks
                if (!subjek.trim() || subjek.trim().length === 0) {
                    alert('Mohon isi subjek laporan terlebih dahulu.');
                    return;
                }

                if (subjek.trim().length > 100) {
                    alert('Subjek maksimal 100 karakter.');
                    return;
                }

                if (!detail.trim() || detail.trim().length === 0) {
                    alert('Mohon isi detail laporan terlebih dahulu.');
                    return;
                }

                if (detail.trim().length > 500) {
                    alert('Detail maksimal 500 karakter.');
                    return;
                }

                // 3. SECURITY: Sanitize untuk display di modal (bukan server)
                document.getElementById('confirm-kategori').textContent = sanitizeHTML(kategori);
                document.getElementById('confirm-subjek').textContent = sanitizeHTML(subjek) || "(Tanpa Subjek)";
                document.getElementById('confirm-detail').textContent = sanitizeHTML(detail) || "(Tanpa Detail)";
                
                const imgWrapper = document.getElementById('confirm-img-wrapper');
                if(hasImage && previewImgSrc !== "#") {
                    imgWrapper.classList.remove('hidden');
                    document.getElementById('confirm-preview').src = previewImgSrc;
                } else {
                    imgWrapper.classList.add('hidden');
                }

                document.getElementById('confirm-anonim-status').style.display = isAnonim ? 'flex' : 'none';
                document.getElementById('confirm-board-status').style.display = showOnBoard ? 'flex' : 'none';

                // 4. Store board status in data attribute for later
                document.getElementById('final-submit').dataset.showOnBoard = showOnBoard ? '1' : '0';

                // 5. Tampilkan Modal
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalBox.classList.remove('scale-95', 'opacity-0');
                    modalBox.classList.add('scale-100', 'opacity-100');
                }, 10);
                
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            modalBox.classList.remove('scale-100', 'opacity-100');
            modalBox.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Event listener untuk tombol close di modal
        const closeBtn = document.querySelector('#modal-confirm button[onclick="closeModal()"]');
        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        // Event listener untuk tombol Cek Lagi
        const cekLagiBtn = document.querySelector('#modal-confirm button:nth-child(1)');
        if (cekLagiBtn) {
            cekLagiBtn.addEventListener('click', closeModal);
        }

        // Event listener untuk background modal
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Event listener untuk tombol Kirim Sekarang
         const finalSubmitBtn = document.getElementById('final-submit');
         if (finalSubmitBtn) {
             finalSubmitBtn.addEventListener('click', async function() {
                 try {
                     // Get all form elements safely
                     const kategoriEl = document.getElementById('selected-category');
                     const subjekEl = document.getElementById('aspirasi-subjek');
                     const detailEl = document.getElementById('aspirasi-detail');
                     const anonimCheckboxEl = document.querySelector('input[type="checkbox"]:not([data-show-board])');
                     const fileInput = document.getElementById('bukti_foto');
                     const csrfEl = document.getElementById('csrf-token');
                     
                     // Validate all elements exist
                     if (!kategoriEl || !subjekEl || !detailEl || !anonimCheckboxEl || !csrfEl) {
                         alert('Terjadi kesalahan: Form tidak lengkap');
                         return;
                     }
                     
                     // SECURITY: Perform final validation before sending
                     if (fileInput && fileInput.files[0]) {
                         const validation = validateFile(fileInput.files[0]);
                         if (!validation.valid) {
                             alert(validation.message);
                             return;
                         }
                     }

                     const formData = new FormData();
                     formData.append('kategori', kategoriEl.value || 'Akademik');
                     formData.append('subjek', subjekEl.value);
                     formData.append('detail', detailEl.value);
                     formData.append('anonim', anonimCheckboxEl.checked ? '1' : '0');
                     formData.append('show_on_board', this.dataset.showOnBoard || '0');
                     formData.append('csrf_token', csrfEl.value);
                     
                     if (fileInput && fileInput.files[0]) {
                         formData.append('bukti_foto', fileInput.files[0]);
                     }

                     const response = await fetch('./api/submit-aspirasi.php', {
                         method: 'POST',
                         body: formData,
                         headers: {
                             'X-Requested-With': 'XMLHttpRequest'
                         }
                     });

                     const result = await response.json();

                     if (result.success) {
                         alert('Aspirasi berhasil dikirim!');
                         closeModal();
                         
                          // Reset form
                          subjekEl.value = '';
                          detailEl.value = '';
                          if (anonimCheckboxEl) anonimCheckboxEl.checked = false;
                          const boardToggle = document.querySelector('input[data-show-board]');
                          if (boardToggle) boardToggle.checked = false;
                          if (fileInput) fileInput.value = '';
                          const previewContainer = document.getElementById('preview-container');
                          const uploadPlaceholder = document.getElementById('upload-placeholder');
                          if (previewContainer) previewContainer.classList.add('hidden');
                          if (uploadPlaceholder) uploadPlaceholder.classList.remove('hidden');
                          if (charCount) charCount.textContent = '0';
                          
                          const categoryButtons = document.querySelectorAll('.btn-category');
                         categoryButtons.forEach(btn => {
                             btn.classList.remove('active', 'text-white', 'bg-blue-900');
                             btn.classList.add('text-gray-500', 'hover:bg-gray-50');
                         });
                         if (categoryButtons[0]) {
                             categoryButtons[0].classList.add('active', 'text-white', 'bg-blue-900');
                             categoryButtons[0].classList.remove('text-gray-500', 'hover:bg-gray-50');
                         }
                         kategoriEl.value = 'Akademik';
                     } else {
                         alert('Error: ' + (result.message || 'Gagal mengirim aspirasi'));
                     }
                 } catch (error) {
                     alert('Terjadi kesalahan saat mengirim aspirasi: ' + error.message);
                 }
             });
         }
    </script>
</body>
</html>