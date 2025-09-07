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

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $res = $conn->prepare("SELECT image1, image2, image3, image4, image5, image6 FROM cards WHERE id = ?");
    $res->bind_param("i", $id);
    $res->execute();
    $result = $res->get_result();

    if ($result->num_rows) {
        $imgs = $result->fetch_assoc();
        foreach ($imgs as $img) {
            if (!empty($img)) {
                @unlink("../assets/uploads/$img");
            }
        }
    }
    $res->close();

    $del = $conn->prepare("DELETE FROM cards WHERE id = ?");
    $del->bind_param("i", $id);
    $del->execute();
    $del->close();

    header("Location: index.php");
    exit();
}

$result = $conn->query("SELECT * FROM cards ORDER BY id DESC");
$cards = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Dashboard</title>
    <link rel="stylesheet" href="/admin/assets/css/dashboard.css">
    <style>
        .projects-section {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>

    <div class="projects-section">
        <div class="projects-section-header">
            <p>Projects</p>
        </div>

        <div class="project-boxes jsListView">
            <?php foreach ($cards as $card): ?>
                <div class="project-box-wrapper">
                    <div class="project-box" style="background-color: #e9e7fd;">
                        <?php if (!empty($card["image1"])): ?>
                            <div class="project-box-header"
                                style="background: url(/uploads/<?= htmlspecialchars($card["image1"]) ?>);">
                            </div>
                        <?php endif; ?>

                        <div class="project-box-content-header">
                            <p class="box-content-header"><?= htmlspecialchars($card['title']) ?></p>
                            <p class="box-content-subheader"><?= htmlspecialchars($card['location']) ?></p>
                        </div>

                        <div class="box-progress-wrapper">
                            <p class="box-progress-header">views ( <?= htmlspecialchars($card['views']) ?> )</p>
                            <div class="box-progress-bar">
                                <span class="box-progress" style="width: 50%; background-color: #4f3ff0"></span>
                            </div>
                        </div>

                        <div class="project-box-footer">
                            <div class="days-left" style="color: #4f3ff0;">
                                <?= htmlspecialchars($card['year']) ?>
                            </div>
                        </div>

                        <a href="?delete=<?= $card['id'] ?>">
                            <button class="project-btn-more">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-more-vertical">
                                    <circle cx="12" cy="12" r="1" />
                                    <circle cx="12" cy="5" r="1" />
                                    <circle cx="12" cy="19" r="1" />
                                </svg>
                            </button>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>