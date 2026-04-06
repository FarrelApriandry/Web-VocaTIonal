<?php
// vocational/admin/public/index.php

ini_set('display_errors', '0');
error_reporting(E_ALL);

session_start();

// Bootstrap - Load shared dependencies
require_once __DIR__ . '/../app/Controllers/AdminAuth.php';
require_once __DIR__ . '/../app/Config/Database.php';
require_once __DIR__ . '/../app/Models/Aspirasi.php';
require_once __DIR__ . '/../app/Models/AspirationReport.php';

// Auth check FIRST
if (!AdminAuth::check()) {
    header('Location: ./auth/login.php');
    exit;
}

// Load admin routing
require_once __DIR__ . '/../app/Config/routes.php';

// Get action from query parameter
$action = $_GET['action'] ?? 'dashboard';

// Route & render (Controller handles everything)
routeAdmin($action);
?>