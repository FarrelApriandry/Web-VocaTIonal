<?php
// vocational/admin/index.php

ini_set('display_errors', '0');
error_reporting(E_ALL);

session_start();

// Auth check - redirect to login if not authenticated
require_once __DIR__ . '/../app/Controllers/AdminAuth.php';

if (!AdminAuth::check()) {
    header('Location: ./auth/login.php');
    exit;
}

// If authenticated, redirect to dashboard
header('Location: ./dashboard.php');
exit;
?>
