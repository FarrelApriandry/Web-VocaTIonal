<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../app/Controllers/Auth.php';

$auth = new Auth();
$result = $auth->logout();

echo json_encode($result);
