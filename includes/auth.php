<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/app.php';

// Login check
if (empty($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

// Super Admin check
function requireSuperAdmin()
{
    if (($_SESSION['admin_role'] ?? '') !== 'super_admin') {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'msg' => 'Access denied. Only Super Admin can access this page.'
        ];

        header('Location: ' . BASE_URL . '/dashboard.php');
        exit;
    }
}
?>