<?php

// vocational/public/api/board/react.php

header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../../../app/Config/Database.php';
require_once __DIR__ . '/../../../app/Models/AspirationReport.php';
require_once __DIR__ . '/../../../app/Controllers/Auth.php';

// Only POST requests allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => 'Method not allowed']));
}

// Check authentication
$auth = new Auth();
if (!$auth->check()) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

try {
    $user = $auth->user();
    $npm = $user['npm'];

    // Get JSON body
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || !isset($input['id_aspirasi'])) {
        http_response_code(400);
        die(json_encode(['success' => false, 'message' => 'Missing id_aspirasi']));
    }

    $id_aspirasi = intval($input['id_aspirasi']);
    $reaction_type = $input['reaction_type'] ?? 'like';

    // Validate reaction type
    if (!in_array($reaction_type, ['like', 'love', 'helpful'])) {
        $reaction_type = 'like';
    }

    $reaction = new AspirationReaction();

    // Toggle reaction
    $result = $reaction->toggleReaction($id_aspirasi, $npm, $reaction_type);

    // Get current reaction count
    $reactionCount = $reaction->getReactionCount($id_aspirasi);

    // Determine if user now has reacted
    $userHasReacted = $reaction->hasReacted($id_aspirasi, $npm);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => $userHasReacted ? 'Reacted' : 'Reaction removed',
        'data' => [
            'id_aspirasi' => $id_aspirasi,
            'userHasReacted' => $userHasReacted,
            'totalReactions' => $reactionCount
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error processing reaction',
        'error' => $e->getMessage()
    ]);
}