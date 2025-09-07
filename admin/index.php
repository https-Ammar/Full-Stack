<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['verified_email'])) {
    header("Location: ./auth/verify.php");
    exit();
}

include '../config/db.php';

// Delete visitor
if (isset($_GET['delete_visitor'])) {
    $id = intval($_GET['delete_visitor']);
    $del = $conn->prepare("DELETE FROM visitors WHERE id = ?");
    $del->bind_param("i", $id);
    $del->execute();
    $del->close();
    header("Location: index.php");
    exit();
}

// Count visitors
$totalVisitors = 0;
$countRes = $conn->query("SELECT COUNT(*) as total FROM visitors");
if ($countRes && $row = $countRes->fetch_assoc()) {
    $totalVisitors = $row['total'];
}

// Count projects (from cards table)
$totalProjects = 0;
$projectsRes = $conn->query("SELECT COUNT(*) as total FROM cards");
if ($projectsRes && $prow = $projectsRes->fetch_assoc()) {
    $totalProjects = $prow['total'];
}

// Sum project views (from cards table)
$totalProjectViews = 0;
$viewsRes = $conn->query("SELECT SUM(views) as totalViews FROM cards");
if ($viewsRes && $vrow = $viewsRes->fetch_assoc()) {
    $totalProjectViews = $vrow['totalViews'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
    <link rel="stylesheet" href="/admin/assets/css/dashboard.css">
    <style>
        .stats-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .stats-card {
            flex: 1;
            background: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }

        .delete-btn svg {
            stroke: red;
            transition: 0.3s;
        }

        .delete-btn:hover svg {
            stroke: darkred;
            transform: scale(1.1);
        }
    </style>
</head>

<body>

    <div class="app-container">
        <div class="app-header">
            <div class="app-header-left">
                <p class="app-name">Client Dashboard</p>
            </div>
            <div class="app-header-right">
                <button class="profile-btn">
                    <img src="/assets/img/me.png" />
                    <span>Ammar Ahmed</span>
                </button>
            </div>
        </div>

        <div class="messages-section show">
            <div class="projects-section-header">
                <p>Client Statistics</p>
            </div>

            <!-- Stats -->
            <div class="stats-container">
                <div class="stats-card">Visitors: <?= htmlspecialchars($totalVisitors) ?></div>
                <div class="stats-card">Projects: <?= htmlspecialchars($totalProjects) ?></div>
                <div class="stats-card">Project Views: <?= htmlspecialchars($totalProjectViews) ?></div>
            </div>

            <!-- Visitors List -->
            <div class="projects-section-header">
                <p>Visitors List</p>
            </div>
            <div class="messages">
                <?php
                $res = $conn->query("SELECT * FROM visitors ORDER BY id DESC");
                if ($res && $res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        $datetime_str = trim($row['created_at'] ?? '');
                        if (!empty($datetime_str) && strtotime($datetime_str) !== false) {
                            $datetime = strtotime($datetime_str);
                            $date = date('Y-m-d', $datetime);
                            $time = date('H:i:s', $datetime);
                        } else {
                            $date = 'Unknown';
                            $time = 'Unknown';
                        }
                        ?>
                        <div class="message-box">
                            <div class="img"><?= htmlspecialchars($row['id']) ?></div>
                            <div class="message-content">
                                <div class="message-header">
                                    <div class="name"><?= htmlspecialchars($row['country'] ?? 'Unknown') ?></div>
                                    <div class="star-checkbox delete-btn">
                                        <a href="?delete_visitor=<?= urlencode($row['id']) ?>"
                                            onclick="return confirm('Are you sure you want to delete this visitor?');">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-trash-2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6l-2 14H7L5 6"></path>
                                                <path d="M10 11v6"></path>
                                                <path d="M14 11v6"></path>
                                                <path d="M9 6V4h6v2"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <p class="message-line">IP: <?= htmlspecialchars($row['ip_address'] ?? 'Unknown') ?></p>
                                <p class="message-line time"><?= htmlspecialchars($date) ?> / <?= htmlspecialchars($time) ?></p>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<li class="mt-5 mb-5">No visitors yet</li>';
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>