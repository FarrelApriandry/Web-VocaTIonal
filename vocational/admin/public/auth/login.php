<?php
// vocational/admin/auth/login.php

ini_set('display_errors', '0');
error_reporting(E_ALL);

session_start();

// Jika sudah login, redirect ke dashboard via MVC router
require_once __DIR__ . '/../../app/Controllers/AdminAuth.php';
if (AdminAuth::check()) {
    header('Location: ../index.php?action=dashboard');
    exit;
}

$title = "VocaTIonal | Admin Login";
?>
<?php include __DIR__ . '/../../app/Views/Layouts/Header.php'; ?>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <img src="../assets/img/logo-himatif.svg" alt="Logo HIMATIF" class="h-10 w-auto mx-auto mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Admin Panel</h1>
                <p class="text-sm text-gray-600 mt-1">Sistem Aspirasi Mahasiswa</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <!-- Alert Messages -->
                <div id="alert-container" class="mb-6"></div>

                <!-- Form -->
                <form id="login-form" class="space-y-4">
                    <!-- Username Input -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            Username
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Masukkan username"
                            required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        >
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Masukkan password"
                                required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            >
                            <button 
                                type="button" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                                onclick="togglePassword()"
                            >
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        id="btn-login"
                        class="w-full bg-blue-900 text-white font-medium py-2.5 rounded-lg hover:bg-blue-800 transition-colors duration-200 mt-6"
                    >
                        <span id="btn-text">Login</span>
                    </button>
                </form>

                <!-- Demo Info -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-xs text-gray-600 text-center">
                        Demo: <code class="bg-gray-100 px-2 py-1 rounded text-gray-700">admin-prod</code> / <code class="bg-gray-100 px-2 py-1 rounded text-gray-700">admin123</code>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <p class="text-center text-xs text-gray-500 mt-6">
                Akses terbatas untuk admin sistem
            </p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = event.currentTarget.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            
            lucide.createIcons();
        }

        // Show alert
        function showAlert(message, type = 'error') {
            const container = document.getElementById('alert-container');
            const alertClasses = {
                error: 'bg-red-50 border border-red-200 text-red-700',
                success: 'bg-green-50 border border-green-200 text-green-700'
            };

            const alert = document.createElement('div');
            alert.className = `rounded-lg p-4 ${alertClasses[type] || alertClasses.error}`;
            alert.innerHTML = `
                <div class="flex items-center gap-2 text-sm">
                    <i data-lucide="${type === 'error' ? 'alert-circle' : 'check-circle'}" class="w-4 h-4 flex-shrink-0"></i>
                    <span>${message}</span>
                </div>
            `;

            container.innerHTML = '';
            container.appendChild(alert);
            lucide.createIcons();

            if (type === 'success') {
                setTimeout(() => {
                    window.location.href = '../index.php?action=dashboard';
                }, 1500);
            }
        }

        // Form submission
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const btnLogin = document.getElementById('btn-login');
            const btnText = document.getElementById('btn-text');

            // Disable button
            btnLogin.disabled = true;
            btnText.textContent = 'Loading...';

            try {
                const response = await fetch('../api/admin-login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showAlert('Login berhasil!', 'success');
                } else {
                    showAlert(result.message || 'Login gagal', 'error');
                    btnLogin.disabled = false;
                    btnText.textContent = 'Login';
                }
            } catch (error) {
                showAlert('Terjadi kesalahan. Coba lagi.', 'error');
                btnLogin.disabled = false;
                btnText.textContent = 'Login';
            }
        });

        // Initialize lucide icons
        lucide.createIcons();
    </script>
</body>
</html>