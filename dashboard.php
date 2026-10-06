<?php
$title = "Dashboard";
require "includes/header.php";

$totalStudents = $pdo->query("SELECT COUNT(*) c FROM students")->fetch()['c'];
$totalTeachers = $pdo->query("SELECT COUNT(*) c FROM teachers")->fetch()['c'];
$totalClasses = $pdo->query("SELECT COUNT(*) c FROM departments")->fetch()['c'];

$todayP = $pdo->query("SELECT COUNT(*) c FROM attendance WHERE attendance_date=CURDATE() AND status='Present'")->fetch()['c'];
$todayA = $pdo->query("SELECT COUNT(*) c FROM attendance WHERE attendance_date=CURDATE() AND status='Absent'")->fetch()['c'];

$tot = $todayP + $todayA;
$pct = $tot ? round($todayP / $tot * 100, 1) : 0;

$recent = $pdo->query("
    SELECT a.*, s.name, s.roll
    FROM attendance a
    JOIN students s ON s.id = a.student_id
    ORDER BY a.id DESC
    LIMIT 8
")->fetchAll();
?>

<style>
/* =========================
   ATTENDPRO DASHBOARD
========================= */

:root {
    --primary: #2563eb;
    --primary-dark: #1e40af;
    --indigo: #4f46e5;
    --bg: #f4f7fb;
    --dark: #111827;
}

body {
    background: var(--bg);
}

/* Page Header */
.dashboard-header {
    background: linear-gradient(135deg, #1e3a8a, #2563eb, #4f46e5);
    color: white;
    padding: 25px 28px;
    border-radius: 18px;
    margin-bottom: 24px;
    box-shadow: 0 12px 30px rgba(37, 99, 235, .18);
}

.dashboard-header h2 {
    font-weight: 700;
    margin: 0;
}

.dashboard-header p {
    margin: 5px 0 0;
    opacity: .85;
}

.take-btn {
    background: white;
    color: #2563eb;
    border: none;
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 10px;
    transition: .3s;
}

.take-btn:hover {
    transform: translateY(-2px);
    background: #eff6ff;
    color: #1d4ed8;
}

/* Statistics */
.stat-card {
    position: relative;
    background: white;
    border: none;
    border-radius: 18px;
    padding: 22px;
    min-height: 150px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .07);
    transition: .3s ease;
}

.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(37, 99, 235, .14);
}

.stat-icon {
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    font-size: 21px;
    margin-bottom: 15px;
}

.stat-card h3 {
    font-size: 30px;
    font-weight: 700;
    margin: 3px 0 0;
    color: #111827;
}

.stat-label {
    color: #64748b;
    font-size: 14px;
    font-weight: 500;
}

/* Icon backgrounds */
.icon-blue {
    background: #dbeafe;
    color: #2563eb;
}

.icon-green {
    background: #dcfce7;
    color: #16a34a;
}

.icon-yellow {
    background: #fef3c7;
    color: #d97706;
}

.icon-red {
    background: #fee2e2;
    color: #dc2626;
}

.icon-purple {
    background: #ede9fe;
    color: #7c3aed;
}

.icon-cyan {
    background: #cffafe;
    color: #0891b2;
}

/* Main Cards */
.dashboard-card {
    background: white;
    border: none;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .06);
}

.card-title {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
}

/* Attendance Progress */
.attendance-box {
    display: flex;
    align-items: center;
    gap: 25px;
}

.progress-circle {
    width: 105px;
    height: 105px;
    border-radius: 50%;
    background: conic-gradient(
        #22c55e <?=$pct?>%,
        #e5e7eb <?=$pct?>%
    );
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.progress-inner {
    width: 78px;
    height: 78px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: #1e293b;
    font-size: 18px;
}

.progress {
    height: 10px;
    border-radius: 20px;
    background: #e5e7eb;
}

.progress-bar {
    border-radius: 20px;
}

/* Table */
.attendance-table {
    margin-bottom: 0;
}

.attendance-table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .4px;
    border-bottom: 1px solid #e2e8f0;
}

.attendance-table tbody tr {
    transition: .2s;
}

.attendance-table tbody tr:hover {
    background: #f8fbff;
}

.attendance-table td {
    padding: 15px 10px;
    border-bottom: 1px solid #f1f5f9;
}

/* Student Avatar */
.student-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
    font-weight: 600;
}

/* Status */
.status-present {
    background: #dcfce7;
    color: #15803d;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-absent {
    background: #fee2e2;
    color: #dc2626;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

/* Mobile */
@media (max-width: 768px) {

    .dashboard-header {
        padding: 20px;
    }

    .dashboard-header .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 15px;
    }

    .take-btn {
        width: 100%;
    }

    .attendance-box {
        flex-direction: column;
        align-items: flex-start;
    }

    .stat-card {
        min-height: auto;
    }
}
</style>


<!-- =========================
     DASHBOARD HEADER
========================= -->

<div class="dashboard-header">
    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h2>
                <i class="fa-solid fa-chart-line me-2"></i>
                Dashboard
            </h2>

            <p>
                Welcome to AttendPro Student Attendance Management System
            </p>
        </div>

        <a class="btn take-btn" href="attendance/take.php">
            <i class="fa-solid fa-plus me-2"></i>
            Take Attendance
        </a>

    </div>
</div>


<!-- =========================
     STATISTICS
========================= -->

<div class="row g-4">

    <!-- Students -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">

            <div class="stat-icon icon-blue">
                <i class="fa-solid fa-user-graduate"></i>
            </div>

            <div class="stat-label">Students</div>

            <h3><?=$totalStudents?></h3>

        </div>
    </div>


    <!-- Teachers -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">

            <div class="stat-icon icon-green">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>

            <div class="stat-label">Teachers</div>

            <h3><?=$totalTeachers?></h3>

        </div>
    </div>


    <!-- Classes -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">

            <div class="stat-icon icon-yellow">
                <i class="fa-solid fa-layer-group"></i>
            </div>

            <div class="stat-label">Classes</div>

            <h3><?=$totalClasses?></h3>

        </div>
    </div>


    <!-- Present -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">

            <div class="stat-icon icon-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div class="stat-label">Today Present</div>

            <h3><?=$todayP?></h3>

        </div>
    </div>


    <!-- Absent -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">

            <div class="stat-icon icon-red">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>

            <div class="stat-label">Today Absent</div>

            <h3><?=$todayA?></h3>

        </div>
    </div>


    <!-- Percentage -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">

            <div class="stat-icon icon-cyan">
                <i class="fa-solid fa-percent"></i>
            </div>

            <div class="stat-label">Attendance Rate</div>

            <h3><?=$pct?>%</h3>

        </div>
    </div>

</div>


<!-- =========================
     ATTENDANCE OVERVIEW
========================= -->

<div class="row g-4 mt-1">

    <div class="col-lg-5">

        <div class="dashboard-card h-100">

            <div class="card-title mb-4">
                <i class="fa-solid fa-calendar-check text-primary me-2"></i>
                Today's Attendance
            </div>

            <div class="attendance-box">

                <div class="progress-circle">
                    <div class="progress-inner">
                        <?=$pct?>%
                    </div>
                </div>

                <div class="flex-grow-1">

                    <h5 class="mb-1">
                        <?=$todayP?> Present
                    </h5>

                    <p class="text-muted mb-3">
                        <?=$todayA?> Absent · <?=$tot?> Total Marked
                    </p>

                    <div class="progress">
                        <div
                            class="progress-bar bg-success"
                            style="width:<?=$pct?>%">
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Quick Info -->
    <div class="col-lg-7">

        <div class="dashboard-card h-100">

            <div class="card-title mb-4">
                <i class="fa-solid fa-bolt text-warning me-2"></i>
                Quick Overview
            </div>

            <div class="row g-3">

                <div class="col-6">
                    <div class="p-3 rounded-3 bg-light">
                        <small class="text-muted">Total Students</small>
                        <h4 class="mb-0 mt-1">
                            <?=$totalStudents?>
                        </h4>
                    </div>
                </div>

                <div class="col-6">
                    <div class="p-3 rounded-3 bg-light">
                        <small class="text-muted">Total Teachers</small>
                        <h4 class="mb-0 mt-1">
                            <?=$totalTeachers?>
                        </h4>
                    </div>
                </div>

                <div class="col-6">
                    <div class="p-3 rounded-3 bg-light">
                        <small class="text-muted">Available Classes</small>
                        <h4 class="mb-0 mt-1">
                            <?=$totalClasses?>
                        </h4>
                    </div>
                </div>

                <div class="col-6">
                    <div class="p-3 rounded-3 bg-light">
                        <small class="text-muted">Marked Today</small>
                        <h4 class="mb-0 mt-1">
                            <?=$tot?>
                        </h4>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================
     RECENT ATTENDANCE
========================= -->

<div class="dashboard-card mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div class="card-title">
            <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>
            Recent Attendance
        </div>

        <a href="attendance/" class="btn btn-sm btn-outline-primary">
            View All
        </a>

    </div>


    <div class="table-responsive">

        <table class="table attendance-table align-middle">

            <thead>
                <tr>
                    <th>Student</th>
                    <th>Roll</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

            <?php if(empty($recent)): ?>

                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fa-solid fa-inbox fa-2x mb-2"></i>
                        <br>
                        No attendance records found.
                    </td>
                </tr>

            <?php else: ?>

                <?php foreach($recent as $r): ?>

                    <tr>

                        <td>
                            <span class="student-avatar">
                                <?=strtoupper(substr($r['name'], 0, 1))?>
                            </span>

                            <?=htmlspecialchars($r['name'])?>
                        </td>

                        <td>
                            <?=htmlspecialchars($r['roll'])?>
                        </td>

                        <td>
                            <i class="fa-regular fa-calendar me-1 text-muted"></i>
                            <?=htmlspecialchars($r['attendance_date'])?>
                        </td>

                        <td>

                            <?php if($r['status'] === 'Present'): ?>

                                <span class="status-present">
                                    <i class="fa-solid fa-check me-1"></i>
                                    Present
                                </span>

                            <?php else: ?>

                                <span class="status-absent">
                                    <i class="fa-solid fa-xmark me-1"></i>
                                    Absent
                                </span>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>


<?php require "includes/footer.php"; ?>