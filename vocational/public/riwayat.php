<?php
// vocational/public/riwayat.php

// SUPPRESS ERRORS DI PRODUCTION
ini_set('display_errors', '0');
error_reporting(E_ALL);

// START SESSION SEBELUM OUTPUT APAPUN
session_start();

// 1. Definisikan Props
$title = "VocaTIonal | Riwayat Aspirasi";
$active = "riwayat";

// 2. Auth check
require_once __DIR__ . '/../app/Controllers/Auth.php';
$auth = new Auth();

if (!$auth->check()) {
    header('Location: ./index.php');
    exit;
    }
    
    $user = $auth->user();
    $userNpm = Session::get('user_npm');

// 3. Import Header & Navbar
include __DIR__ . '/../app/Views/Components/Header.php';
include __DIR__ . '/../app/Views/Components/Navbar.php';
?>

    <main class="mx-auto px-6 md:px-16 py-8 md:py-16">
        <header class="mb-8 md:mb-12">
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-2 leading-tight">
                Riwayat Aspirasi
            </h1>
            <p class="text-lg md:text-xl text-gray-500">Pantau semua aspirasi yang telah Anda kirimkan</p>
        </header>

        <!-- SKELETON LOADER -->
        <div id="skeleton-loader" class="space-y-4 animate-pulse">
            <div class="h-12 bg-gray-200 rounded-xl w-full"></div>
            <div class="space-y-3">
                <div class="h-16 bg-gray-200 rounded-xl w-full"></div>
                <div class="h-16 bg-gray-200 rounded-xl w-full"></div>
                <div class="h-16 bg-gray-200 rounded-xl w-full"></div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div id="main-content" class="hidden">
            <!-- FILTER SECTION -->
            <div class="bg-white rounded-2xl p-6 md:p-8 mb-8 shadow-sm border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Filter Kategori -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">
                            Kategori
                        </label>
                        <select id="filter-kategori" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-900 bg-white">
                            <option value="">Semua Kategori</option>
                            <option value="Akademik">Akademik</option>
                            <option value="Fasilitas">Fasilitas</option>
                            <option value="Sarpras">Sarpras</option>
                            <option value="Layanan">Layanan</option>
                            <option value="UKT">UKT</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <!-- Filter Status -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">
                            Status
                        </label>
                        <select id="filter-status" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-900 bg-white">
                            <option value="">Semua Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <!-- Reset Button -->
                    <div class="flex items-end">
                        <button id="btn-reset-filter" class="w-full bg-blue-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-800 transition-colors">
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- TABLE SECTION -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="aspirasi-table-body" class="divide-y divide-gray-200">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>

                <!-- EMPTY STATE -->
                <div id="empty-state" class="hidden text-center py-12 px-6">
                    <i data-lucide="inbox" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                    <p class="text-lg text-gray-500 font-semibold">Belum ada aspirasi</p>
                    <p class="text-sm text-gray-400">Anda belum mengirimkan aspirasi apapun. Mulai sekarang!</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Helper function untuk get status badge color
        function getStatusColor(status) {
            const colors = {
                'Pending': 'bg-yellow-100 text-yellow-800',
                'Proses': 'bg-blue-100 text-blue-800',
                'Selesai': 'bg-green-100 text-green-800'
            };
            return colors[status] || 'bg-gray-100 text-gray-800';
        }

        // Helper function untuk get kategori badge color
        function getKategoriColor(kategori) {
            const colors = {
                'Akademik': 'bg-purple-100 text-purple-800',
                'Fasilitas': 'bg-pink-100 text-pink-800',
                'Sarpras': 'bg-orange-100 text-orange-800',
                'Layanan': 'bg-cyan-100 text-cyan-800',
                'UKT': 'bg-red-100 text-red-800',
                'Lainnya': 'bg-gray-100 text-gray-800'
            };
            return colors[kategori] || 'bg-gray-100 text-gray-800';
        }

        // Load aspirasi data
        async function loadAspirations(filters = {}) {
            try {
                const skeleton = document.getElementById('skeleton-loader');
                const content = document.getElementById('main-content');
                const tableBody = document.getElementById('aspirasi-table-body');
                const emptyState = document.getElementById('empty-state');

                // Show skeleton
                skeleton.classList.remove('hidden');
                content.classList.add('hidden');

                // Build query string
                const params = new URLSearchParams();
                if (filters.kategori) params.append('kategori', filters.kategori);
                if (filters.status) params.append('status', filters.status);

                const response = await fetch('./api/get-riwayat.php?' + params.toString());
                const result = await response.json();

                if (!result.success) {
                    alert('Error: ' + result.message);
                    return;
                }

                // Hide skeleton, show content
                skeleton.classList.add('hidden');
                content.classList.remove('hidden');
                content.style.opacity = '1';

                // Clear table
                tableBody.innerHTML = '';

                if (result.data.length === 0) {
                    emptyState.classList.remove('hidden');
                    tableBody.parentElement.parentElement.style.display = 'none';
                    return;
                }

                emptyState.classList.add('hidden');
                tableBody.parentElement.parentElement.style.display = 'block';

                // Populate table
                result.data.forEach((item) => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50 transition-colors';
                    row.innerHTML = `
                        <td class="px-6 py-4 text-sm font-mono text-gray-600">#${item.id_aspirasi}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">${item.judul}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${getKategoriColor(item.kategori)}">
                                ${item.kategori}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${getStatusColor(item.status)}">
                                ${item.status}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">${item.created_at}</td>
                        <td class="px-6 py-4 text-sm">
                            <button class="text-blue-900 hover:text-blue-700 font-semibold" onclick="viewDetail(${item.id_aspirasi})">
                                Lihat
                            </button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            } catch (error) {
                alert('Terjadi kesalahan saat memuat data');
            }
        }

        // View detail aspirasi
        function viewDetail(id) {
            alert('Detail aspirasi #' + id + ' - Coming Soon!');
        }

        // Event listeners
        document.getElementById('filter-kategori').addEventListener('change', function() {
            const filters = {
                kategori: this.value,
                status: document.getElementById('filter-status').value
            };
            loadAspirations(filters);
        });

        document.getElementById('filter-status').addEventListener('change', function() {
            const filters = {
                kategori: document.getElementById('filter-kategori').value,
                status: this.value
            };
            loadAspirations(filters);
        });

        document.getElementById('btn-reset-filter').addEventListener('click', function() {
            document.getElementById('filter-kategori').value = '';
            document.getElementById('filter-status').value = '';
            loadAspirations();
        });

        // Initial load
        window.addEventListener('DOMContentLoaded', function() {
            loadAspirations();
        });
    </script>

    <?php 
        include __DIR__ . '/../app/Views/Components/ConfirmationModal.php';
    ?>

    <script src="./js/confirmation-modal.js"></script>
</body>
</html>