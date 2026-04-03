<?php

// vocational/public/api/board/aspirations.php

header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../../app/Config/Database.php';
require_once __DIR__ . '/../../app/Models/Aspirasi.php';
require_once __DIR__ . '/../../app/Controllers/Auth.php';

// Only GET requests allowed
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => 'Method not allowed']));
}

try {
    $auth = new Auth();
    $npm = $auth->check() ? $auth->user()['npm'] : null;

    $aspirasi = new Aspirasi();

    // Get parameters
    $category = $_GET['category'] ?? 'all';
    $page = max(1, intval($_GET['page'] ?? 1));
    $limit = 12;
    $offset = ($page - 1) * $limit;

    // Validate category
    $validCategories = ['all', 'Akademik', 'Fasilitas', 'UKT', 'Lainnya'];
    if (!in_array($category, $validCategories)) {
        $category = 'all';
    }

    // Get aspirations
    $aspirations = $aspirasi->getBoardAspirations($category === 'all' ? null : $category, $limit + 1, $offset);

    // Check if there's a next page
    $hasNextPage = count($aspirations) > $limit;
    $aspirations = array_slice($aspirations, 0, $limit);

    // Enrich aspirations with user reaction status
    $enriched = [];
    foreach ($aspirations as $asp) {
        $asp['userHasReacted'] = $npm ? $aspirasi->hasUserReacted($asp['id_aspirasi'], $npm) : false;
        $asp['userHasReported'] = $npm ? $aspirasi->hasUserReported($asp['id_aspirasi'], $npm) : false;
        $asp['excerpt'] = substr($asp['deskripsi'], 0, 100) . (strlen($asp['deskripsi']) > 100 ? '...' : '');
        $asp['total_reactions'] = $asp['total_reactions'] ?? 0;
        $enriched[] = $asp;
    }

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $enriched,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'hasNextPage' => $hasNextPage,
            'totalShown' => count($aspirations)
        ]
    ], JSON_UNESCAPED_UNICODE);
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    error_log('PDOException in aspirations API: ' . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Database error',
        'error' => preg_replace('/password[^,]*/i', 'password:***', $e->getMessage())
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    error_log('Exception in aspirations API: ' . $e->getMessage() . ' - ' . $e->getFile() . ':' . $e->getLine());
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching aspirations',
        'error' => $e->getMessage()
    ]);
    exit;
}
