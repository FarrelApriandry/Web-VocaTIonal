<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="./assets/img/logo-himatif.svg">
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

        /* Custom Transition Classes */
        .fade-out { opacity: 0; transition: opacity 0.5s ease-out; pointer-events: none; }
        .fade-in { opacity: 1 !important; transform: translateY(0) !important; transition: all 0.6s ease-out; }
        #main-content { opacity: 0; transform: translateY(10px); }
    </style>
</head>
<body class="min-h-screen">

    <nav class="bg-white border-b border-gray-200 px-6 md:px-16 py-3 flex justify-between items-center shadow-[0_4px_4px_0_rgba(0,0,0,0.25)] sticky top-0 z-50">
        <div class="flex items-center">
            <img src="./assets/img/logo-himatif.svg" alt="logo himatif" class="h-10 w-auto object-contain">
        </div>
        
        <div class="hidden md:flex gap-8 text-sm font-medium text-gray-500 uppercase tracking-wider">
            <a href="#" class="text-blue-900 underline transition-colors duration-200">Beranda</a>
            <a href="#" class="hover:text-blue-900 transition-colors duration-200">Riwayat</a>
            <a href="#" class="hover:text-blue-900 transition-colors duration-200">Panduan</a>
        </div>

        <div class="hover:scale-110 transition-transform duration-200">
            <i data-lucide="user" class="text-gray-600 w-6 h-6 cursor-pointer"></i>
        </div>
    </nav>

    <main class="mx-auto px-6 md:px-16 py-8 md:py-16">
        <header class="mb-8 md:mb-12">
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                Halo, mahasiswa <span class="text-blue-900">Teknologi Informasi!</span>
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
                <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-6">Pilih Kategori Laporan</p>
                
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-8">
                    <button type="button" class="btn-category active py-3 md:py-4 font-semibold text-sm md:text-base">Akademik</button>
                    <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">Sarpas</button>
                    <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">Layanan</button>
                    <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-500 hover:bg-gray-50 text-sm md:text-base">Lainnya</button>
                </div>

                <div class="flex flex-col xl:flex-row gap-3">
                    <div class="flex-1 space-y-6">
                        <input type="text" placeholder="Subjek Laporan..." class="w-full bg-gray-50 border border-[#64748B] rounded-xl px-4 py-4 focus:outline-none focus:ring-1 focus:ring-[#64748B]">
                        <div class="relative">
                            <textarea rows="6" placeholder="Detail Laporan..." class="w-full h-48 bg-gray-50 border border-[#64748B] rounded-xl px-4 py-4 focus:outline-none focus:ring-1 focus:ring-[#64748B]"></textarea>
                            <span class="absolute bottom-4 right-4 text-xs text-gray-400">0/500 Karakter</span>
                        </div>
                    </div>
                    
                    <label class="flex-1 border-2 border-dashed border-[#64748B] rounded-2xl flex flex-col items-center justify-center p-8 cursor-pointer hover:bg-gray-50 transition-all min-h-[200px] relative overflow-hidden text-center">
                        <input type="file" id="bukti_foto" name="bukti_foto" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        
                        <div id="upload-placeholder" class="flex flex-col items-center">
                            <i data-lucide="camera" class="text-[#64748B] w-10 md:w-12 h-10 md:h-12 mb-4"></i>
                            <p class="font-bold text-[#64748B] text-base md:text-lg">Silahkan Upload Bukti</p>
                            <p class="text-xs text-[#64748B] md:text-sm">Klik atau seret file</p>
                        </div>

                        <div id="preview-container" class="hidden absolute inset-0 bg-white flex items-center justify-center p-2">
                            <img id="image-preview" src="#" class="max-h-full max-w-full rounded-xl object-contain">
                            <button type="button" id="remove-img" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full shadow-lg z-20">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </label>
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
                    <ul class="space-y-4 md:space-y-6 text-xs md:text-sm text-gray-600 font-medium leading-relaxed">
                        <li class="flex gap-4">
                            <span class="font-bold text-blue-900">01</span>
                            <p><span class="font-bold text-gray-900">Bersihkan Identitas:</span> Hindari menyebutkan nama atau NIM.</p>
                        </li>
                        <li class="flex gap-4">
                            <span class="font-bold text-blue-900">02</span>
                            <p><span class="font-bold text-gray-900">Sensor Bukti:</span> Tutupi informasi pribadi pada foto.</p>
                        </li>
                        <li class="flex gap-4">
                            <span class="font-bold text-blue-900">03</span>
                            <p><span class="font-bold text-gray-900">Metadata Strip:</span> Sistem menghapus data lokasi (EXIF) otomatis.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <input type="hidden" name="kategori" id="selected-category" value="Akademik">

    <script>
        // SKELETON TO CONTENT TRANSITION LOGIC
        window.addEventListener('DOMContentLoaded', () => {
            const skeleton = document.getElementById('skeleton-loader');
            const content = document.getElementById('main-content');

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
        });
        
        // CATEGORY SELECTION
        const categoryButtons = document.querySelectorAll('.btn-category');
        const categoryInput = document.getElementById('selected-category');

        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                categoryButtons.forEach(btn => {
                    btn.classList.remove('active', 'text-white');
                    btn.classList.add('text-gray-500');
                });
                button.classList.add('active', 'text-white');
                button.classList.remove('text-gray-500');
                categoryInput.value = button.innerText;
            });
        });

        // IMAGE PREVIEW LOGIC
        const fileInput = document.getElementById('bukti_foto');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        const removeBtn = document.getElementById('remove-img');

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
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

        lucide.createIcons();
    </script>
</body>
</html>