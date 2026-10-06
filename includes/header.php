<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/auth.php';
$title = $title ?? 'Attendance System';
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($title) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head><body>
<div class="app"><aside class="sidebar">
<div class="brand"><i class="fa-solid fa-user-check"></i> AttendPro</div>
<a href="<?= BASE_URL ?>/dashboard.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
<a href="<?= BASE_URL ?>/students/index.php"><i class="fa-solid fa-user-graduate"></i> Students</a>
<a href="<?= BASE_URL ?>/teachers/index.php"><i class="fa-solid fa-chalkboard-user"></i> Teachers</a>
<a href="<?= BASE_URL ?>/departments/index.php"><i class="fa-solid fa-building"></i> Classes</a>
<a href="<?= BASE_URL ?>/attendance/take.php"><i class="fa-solid fa-calendar-check"></i> Take Attendance</a>
<a href="<?= BASE_URL ?>/attendance/report.php"><i class="fa-solid fa-file-lines"></i> Reports</a>
<a href="<?= BASE_URL ?>/logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</aside><main class="content"><nav class="topbar"><span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span><a href="<?= BASE_URL ?>/logout.php" class="btn btn-sm btn-outline-secondary">Logout</a></nav>
<div class="container-fluid py-4">
<?php if(!empty($_SESSION['flash'])): ?><div class="alert alert-<?= $_SESSION['flash']['type'] ?>"><?= htmlspecialchars($_SESSION['flash']['msg']); unset($_SESSION['flash']); ?></div><?php endif; ?>