<?php
// Works with both XAMPP/Apache (/student-attendance-system) and PHP built-in server (/)
$projectRoot = realpath(__DIR__ . '/..');
$documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? $projectRoot);
$base = '';
if ($documentRoot && str_starts_with(str_replace('\\','/',$projectRoot), str_replace('\\','/',$documentRoot))) {
    $relative = str_replace('\\','/', substr(str_replace('\\','/',$projectRoot), strlen(str_replace('\\','/',$documentRoot))));
    $base = rtrim($relative, '/');
}
define('BASE_URL', $base);
?>