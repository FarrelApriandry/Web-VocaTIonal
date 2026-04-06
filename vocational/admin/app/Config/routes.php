<?php
// vocational/admin/app/Config/routes.php

/**
 * Admin routing configuration
 * Maps actions to controllers
 */

function routeAdmin($action) {
    switch ($action) {
        case 'dashboard':
            require_once __DIR__ . '/../Controllers/DashboardController.php';
            $controller = new DashboardController();
            $controller->index();
            break;

        case 'aspirations':
            require_once __DIR__ . '/../Controllers/AspirationsController.php';
            $controller = new AspirationsController();
            $controller->index();
            break;

        case 'reports':
            require_once __DIR__ . '/../Controllers/ReportsController.php';
            $controller = new ReportsController();
            $controller->index();
            break;

        case 'board':
            require_once __DIR__ . '/../Controllers/BoardController.php';
            $controller = new BoardController();
            $controller->index();
            break;

        default:
            // Default to dashboard
            require_once __DIR__ . '/../Controllers/DashboardController.php';
            $controller = new DashboardController();
            $controller->index();
            break;
    }
}

?>