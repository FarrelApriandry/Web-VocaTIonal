<?php
// vocational/admin/api/admin-logout.php

require_once __DIR__ . '/../../app/Controllers/AdminAuth.php';

// Logout
AdminAuth::logout();

// Redirect to login
header('Location: ../auth/login.php');
exit;
