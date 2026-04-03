<?php
/**
 * Centralized Path Configuration
 * Determines correct paths regardless of file location depth
 * Usage: require_once __DIR__ . '/path/to/includes/paths.php'
 */

// Get the public directory path dynamically
// This file is at vocational/public/includes/paths.php
// So we need to go up 2 levels to get vocational/public/
$publicDir = dirname(dirname(__DIR__)); // vocational/public/
$appDir = dirname($publicDir) . '/app'; // vocational/app/

// Define constants for easy access
define('PUBLIC_DIR', $publicDir . '/');
define('APP_DIR', $appDir . '/');
define('ASSETS_DIR', PUBLIC_DIR . 'assets/');
define('JS_DIR', PUBLIC_DIR . 'js/');
define('CSS_DIR', PUBLIC_DIR . 'css/');
define('IMG_DIR', ASSETS_DIR . 'img/');
define('API_DIR', PUBLIC_DIR . 'api/');
define('VIEWS_DIR', APP_DIR . 'Views/');
define('COMPONENTS_DIR', VIEWS_DIR . 'Components/');
define('MODELS_DIR', APP_DIR . 'Models/');
define('CONTROLLERS_DIR', APP_DIR . 'Controllers/');
define('CONFIG_DIR', APP_DIR . 'Config/');

// Convenience functions for relative URLs
function asset($path = '') {
    return './assets/' . ltrim($path, '/');
}

function js_file($file = '') {
    return './js/' . ltrim($file, '/');
}

function css_file($file = '') {
    return './css/' . ltrim($file, '/');
}

function img_file($file = '') {
    return './assets/img/' . ltrim($file, '/');
}