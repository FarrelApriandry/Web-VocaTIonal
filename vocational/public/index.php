<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VocaTIonal | Aspirasi Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F3F4F6; }
        .glass-card { background: white; border-radius: 24px; border: 1px solid #E5E7EB; }
        .btn-category { border: 1px solid #9CA3AF; border-radius: 12px; transition: all 0.3s; }
        .btn-category.active { background-color: #1E3A8A; color: white; border-color: #1E3A8A; }
        .info-card { background-color: #1E3A8A; border-radius: 16px; color: white; }
        
        input:checked ~ .dot { transform: translateX(1.5rem); background-color: #DBEAFE; }
        input:checked ~ .block { background-color: #1E3A8A; }
    </style>
</head>
<body class="min-h-screen">

    <nav class="bg-white border-b border-gray-200 px-6 md:px-16 py-3 flex justify-between items-center shadow-sm sticky top-0 z-50">
        <div class="flex items-center">
            <img src="./assets/img/logo-himatif.svg" alt="logo himatif" class="h-10 w-auto object-contain">
        </div>
        <div class="hidden md:flex gap-8 text-sm font-semibold text-gray-500 uppercase tracking-wider">
            <a href="#" class="hover:text-blue-900">Beranda</a>
            <a href="#" class="hover:text-blue-900">Riwayat</a>
            <a href="#" class="hover:text-blue-900">Panduan</a>
        </div>
        <div>
            <i data-lucide="user" class="text-gray-500 w-6 h-6 cursor-pointer"></i>
        </div>
    </nav>

    <main class="mx-auto px-6 md:px-16 py-8 md:py-16">
        <header class="mb-8 md:mb-12">
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                Halo, mahasiswa <span class="text-blue-900">Teknologi Informasi!</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-500">Ada aspirasi atau keluhan? Suarakan di bawah ini.</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 glass-card p-6 md:p-10 shadow-sm">
                <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-6">Pilih Kategori Laporan</p>
                
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-8">
                    <button class="btn-category active py-3 md:py-4 font-semibold text-sm md:text-base">Akademik</button>
                    <button class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">Sarpas</button>
                    <button class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">Layanan</button>
                    <button class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">Lainnya</button>
                </div>

                <div class="flex flex-col xl:flex-row gap-3">
                    <div class="flex-1 space-y-6">
                        <input type="text" placeholder="Subjek Laporan..." class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-900">
                        <div class="relative">
                            <textarea rows="6" md:rows="8" placeholder="Detail Laporan..." class="w-full h-48 bg-gray-50 border border-gray-300 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-blue-900"></textarea>
                            <span class="absolute bottom-4 right-4 text-xs text-gray-400">0/500 Karakter</span>
                        </div>
                    </div>
                    
                    <div class="flex-1 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center p-8 bg-gray-50 text-gray-400 cursor-pointer hover:bg-gray-100 transition-all min-h-[200px]">
                        <i data-lucide="camera" class="text-[64748B] w-10 md:w-12 h-10 md:h-12 mb-4"></i>
                        <p class="font-bold text-[64748B] text-base md:text-lg">Silahkan Upload Bukti</p>
                        <p class="text-xs text-[64748B] md:text-sm">Klik atau seret file</p>
                    </div>
                </div>

                <div class="mt-10 flex flex-col sm:flex-row justify-between items-center gap-6">
                    <label class="flex items-center cursor-pointer group self-start">
                        <div class="relative">
                            <input type="checkbox" class="sr-only">
                            <div class="block bg-gray-300 w-12 h-7 md:w-14 md:h-8 rounded-full transition"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-5 h-5 md:w-6 md:h-6 rounded-full transition shadow-sm"></div>
                        </div>
                        <span class="ml-3 text-gray-700 font-semibold text-sm md:text-base">Kirim Anonim</span>
                    </label>
                    <button class="w-full sm:w-auto bg-[#111827] text-white px-10 py-4 rounded-xl font-medium uppercase tracking-widest hover:bg-black transition-all text-sm md:text-base">
                        Kirim Aspirasi
                    </button>
                </div>
            </div>

            <div class="space-y-6">
                <div class="info-card p-6 md:p-8 shadow-lg">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest">System Operational</span>
                    </div>
                    <h3 class="text-base md:text-lg font-bold mb-2">Network Transparency</h3>
                    <p class="text-xs md:text-sm text-blue-100 leading-relaxed">
                        Layanan aspirasi berjalan di atas protokol enkripsi satu arah. Data Anda aman dan anonim.
                    </p>
                </div>

                <div class="bg-gray-100 border border-gray-200 rounded-2xl p-6 md:p-8">
                    <p class="text-xs md:text-sm font-bold text-gray-900 uppercase tracking-widest mb-6">Panduan Anonimitas</p>
                    <ul class="space-y-4 md:space-y-6">
                        <li class="flex gap-4">
                            <span class="font-bold text-blue-900 text-sm md:text-base">01</span>
                            <p class="text-xs md:text-sm text-gray-600 font-medium leading-relaxed"><span class="font-bold text-gray-900">Bersihkan Identitas:</span> Hindari menyebutkan nama/NIM di laporan.</p>
                        </li>
                        <li class="flex gap-4">
                            <span class="font-bold text-blue-900 text-sm md:text-base">02</span>
                            <p class="text-xs md:text-sm text-gray-600 font-medium leading-relaxed"><span class="font-bold text-gray-900">Sensor Bukti:</span> Tutupi informasi pribadi pada foto.</p>
                        </li>
                        <li class="flex gap-4">
                            <span class="font-bold text-blue-900 text-sm md:text-base">03</span>
                            <p class="text-xs md:text-sm text-gray-600 font-medium leading-relaxed"><span class="font-bold text-gray-900">Metadata Strip:</span> Sistem menghapus data lokasi (EXIF) otomatis.</p>
                        </li>
                        <li class="flex gap-4">
                            <span class="font-bold text-blue-900 text-sm md:text-base">04</span>
                            <p class="text-xs md:text-sm text-gray-600 font-medium leading-relaxed"><span class="font-bold text-gray-900">Session Purge:</span> Logout browser setelah selesai melapor.</p>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </main>

    <input type="hidden" name="kategori" id="selected-category" value="Akademik">

    <script>
        // Ambil semua button kategori
        const categoryButtons = document.querySelectorAll('.btn-category');
        const categoryInput = document.getElementById('selected-category');

        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                // 1. Hapus class 'active' dan warna teks biru dari semua tombol
                categoryButtons.forEach(btn => {
                    btn.classList.remove('active', 'text-white');
                    btn.classList.add('text-gray-500');
                });

                // 2. Tambah class 'active' ke tombol yang diklik
                button.classList.add('active', 'text-white');
                button.classList.remove('text-gray-500');

                // 3. Update nilai di input hidden buat dikirim ke server nanti
                categoryInput.value = button.innerText;

                // Log buat testing di Console (F12)
                console.log("Kategori dipilih:", categoryInput.value);
            });
        });

        // Inisialisasi Lucide
        lucide.createIcons();
    </script>
</body>
<html>