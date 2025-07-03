<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['verified_email'])) {
    header("Location: verify.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);
    $role = trim($_POST['role']);
    $services = trim($_POST['services']);
    $credits = trim($_POST['credits']);
    $location = trim($_POST['location']);
    $year = intval($_POST['year']);
    $extra_text = trim($_POST['extra_text']);
    $date = date('Y-m-d');
    $views = 0;

    if ($year < 1901 || $year > 2155) {
        header("Location: index.php?error=invalid_year");
        exit();
    }

    $images = [];
    for ($i = 1; $i <= 6; $i++) {
        $field = "image$i";
        if (!empty($_FILES[$field]['name'])) {
            $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
            $newName = uniqid("img_") . ".$ext";
            move_uploaded_file($_FILES[$field]['tmp_name'], "../assets/uploads/$newName");
            $images["image$i"] = $newName;
        } else {
            $images["image$i"] = '';
        }
    }

    $stmt = $conn->prepare("INSERT INTO cards (title, description, link, image1, image2, image3, image4, image5, image6, role, services, credits, location, year, extra_text, created_at, views) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssssssssssssi",
        $title,
        $description,
        $link,
        $images["image1"],
        $images["image2"],
        $images["image3"],
        $images["image4"],
        $images["image5"],
        $images["image6"],
        $role,
        $services,
        $credits,
        $location,
        $year,
        $extra_text,
        $date,
        $views
    );
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = intval($_POST['edit_id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);
    $role = trim($_POST['role']);
    $services = trim($_POST['services']);
    $credits = trim($_POST['credits']);
    $location = trim($_POST['location']);
    $year = intval($_POST['year']);
    $extra_text = trim($_POST['extra_text']);
    $date = date('Y-m-d');

    if ($year < 1901 || $year > 2155) {
        header("Location: index.php?error=invalid_year");
        exit();
    }

    $res = $conn->prepare("SELECT image1, image2, image3, image4, image5, image6 FROM cards WHERE id = ?");
    $res->bind_param("i", $id);
    $res->execute();
    $oldImages = $res->get_result()->fetch_assoc();
    $res->close();

    $images = [];
    for ($i = 1; $i <= 6; $i++) {
        $field = "image$i";
        if (!empty($_FILES[$field]['name'])) {
            if (!empty($oldImages["image$i"])) {
                @unlink("../assets/uploads/" . $oldImages["image$i"]);
            }
            $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
            $newName = uniqid("img_") . ".$ext";
            move_uploaded_file($_FILES[$field]['tmp_name'], "../assets/uploads/$newName");
            $images["image$i"] = $newName;
        } else {
            $images["image$i"] = $oldImages["image$i"];
        }
    }

    $stmt = $conn->prepare("UPDATE cards SET title = ?, description = ?, link = ?, image1 = ?, image2 = ?, image3 = ?, image4 = ?, image5 = ?, image6 = ?, role = ?, services = ?, credits = ?, location = ?, year = ?, extra_text = ?, created_at = ? WHERE id = ?");
    $stmt->bind_param(
        "ssssssssssssssssi",
        $title,
        $description,
        $link,
        $images["image1"],
        $images["image2"],
        $images["image3"],
        $images["image4"],
        $images["image5"],
        $images["image6"],
        $role,
        $services,
        $credits,
        $location,
        $year,
        $extra_text,
        $date,
        $id
    );
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}

if (isset($_GET['delete_visitor'])) {
    $id = intval($_GET['delete_visitor']);
    $del = $conn->prepare("DELETE FROM visitors WHERE id = ?");
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
    <title>Portfolio</title>
    <link rel="stylesheet" href="./dashboard.css">
</head>

<body>




    <div class="app-container">
        <div class="app-header">
            <div class="app-header-left">
                <span class="app-icon"></span>
                <p class="app-name">Portfolio</p>
                <div class="search-wrapper">
                    <input class="search-input" type="text" placeholder="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-search"
                        viewBox="0 0 24 24">
                        <defs></defs>
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.35-4.35"></path>
                    </svg>
                </div>
            </div>
            <div class="app-header-right">
                <button class="mode-switch" title="Switch Theme">
                    <svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
                        <defs></defs>
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                    </svg>
                </button>

                <!-- زر الإضافة -->
                <button class="add-btn" title="Add New Project" onclick="openModal()">
                    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                </button>

                <!-- النافذة المنبثقة -->
                <div id="popupModal" class="modal">
                    <div class="modal-content">
                        <span class="close-btn" onclick="closeModal()">&times;</span>
                        <h3>Add New Project</h3>

                        <hr>



                        <form method="POST" enctype="multipart/form-data">

                            <div class="flex">
                                <div>
                                    <label>Title</label>
                                    <input type="text" name="title" placeholder="Title" required>
                                </div>

                                <div>
                                    <label>Description</label>
                                    <input type="text" name="description" placeholder="Description" required>
                                </div>
                            </div>


                            <div class="flex">
                                <div>
                                    <label>Link</label>
                                    <input type="text" name="link" placeholder="Link" required>
                                </div>

                                <div>
                                    <label>Location</label>
                                    <input type="text" name="location" placeholder="Location" required>
                                </div>

                            </div>


                            <div class="flex">
                                <div>
                                    <label>Year</label>
                                    <input type="number" name="year" placeholder="Year" required>
                                </div>

                                <div>
                                    <label>Services</label>
                                    <input type="text" name="services" placeholder="Services" required>
                                </div>

                            </div>





                            <div id="more-settings">


                                <div class="flex">
                                    <div>
                                        <label>cover</label>
                                        <input type="file" name="image1">
                                    </div>


                                    <div>
                                        <label>pc</label>
                                        <input type="file" name="image2">
                                    </div>
                                </div>

                                <div class="flex">
                                    <div>
                                        <label>phone</label>
                                        <input type="file" name="image3">
                                    </div>

                                    <div>
                                        <label>phone</label>
                                        <input type="file" name="image4">
                                    </div>

                                    <div>
                                        <label>phone</label>
                                        <input type="file" name="image5">
                                    </div>
                                </div>

                                <div class="flex">

                                </div>


                                <div class="flex">

                                </div>

                                <div class="flex">

                                </div>







                                <div>
                                    <label>tap</label>
                                    <input type="file" name="image6">
                                </div>


                                <div>
                                    <label>Extra Text</label>
                                    <input type="text" name="extra_text" placeholder="Extra Text">
                                </div>

                            </div>

                            <button class="save-button" type="submit" name="add">Save</button>

                        </form>


                    </div>
                </div>

                <button class="notification-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-bell">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                </button>
                <button class="profile-btn">
                    <img src="/assets/img/me.png" />
                    <span>Ammar Ahmed</span>
                </button>
            </div>
            <button class="messages-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-message-circle">
                    <path
                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                </svg>
            </button>
        </div>
        <div class="app-content">
            <div class="app-sidebar">
                <a href="" class="app-sidebar-link active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </a>
                <a href="" class="app-sidebar-link">
                    <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        class="feather feather-pie-chart" viewBox="0 0 24 24">
                        <defs />
                        <path d="M21.21 15.89A10 10 0 118 2.83M22 12A10 10 0 0012 2v10z" />
                    </svg>
                </a>
                <a href="" class="app-sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-calendar">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </a>



                <?php if (isset($_SESSION['verified_email'])): ?>



                    <a href="logout.php" class="app-sidebar-link">
                        <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            class="feather feather-settings" viewBox="0 0 24 24">
                            <defs />
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" />
                        </svg>
                    </a>
                <?php endif; ?>


            </div>
            <div class="projects-section">
                <div class="projects-section-header">
                    <p>Projects</p>
                    <p class="time">December, 12</p>
                </div>
                <div class="projects-section-line">
                    <div class="projects-status">
                        <?php
                        $total_projects = count($cards);
                        $total_views = 0;
                        foreach ($cards as $card) {
                            $total_views += (int) $card['views'];
                        }
                        ?>



                        <div class="item-status">
                            <span class="status-number"><?= $total_views ?></span>
                            <span class="status-type">Total views</span>
                        </div>
                        <div class="item-status">
                            <span class="status-number">10</span>
                            <span class="status-type">Upcoming</span>
                        </div>
                        <div class="item-status">
                            <span class="status-number"><?= $total_projects ?></span>
                            <span class="status-type">Total Projects</span>
                        </div>
                    </div>
                    <div class="view-actions">
                        <button class="view-btn list-view" title="List View">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-list">
                                <line x1="8" y1="6" x2="21" y2="6" />
                                <line x1="8" y1="12" x2="21" y2="12" />
                                <line x1="8" y1="18" x2="21" y2="18" />
                                <line x1="3" y1="6" x2="3.01" y2="6" />
                                <line x1="3" y1="12" x2="3.01" y2="12" />
                                <line x1="3" y1="18" x2="3.01" y2="18" />
                            </svg>
                        </button>
                        <button class="view-btn grid-view active" title="Grid View">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-grid">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="project-boxes jsListView">

                    <?php foreach ($cards as $card): ?>
                        <div class="project-box-wrapper">
                            <div class="project-box" style="background-color: #e9e7fd;">


                                <?php if (!empty($card["image1"])): ?>
                                    <div class="project-box-header"
                                        style="background: url(../assets/uploads/<?= htmlspecialchars($card["image1"]) ?>);">
                                    </div>
                                <?php endif; ?>

                                <div class="project-box-content-header">
                                    <p class="box-content-header"><?= htmlspecialchars($card['title']) ?></p>
                                    <p class="box-content-subheader"><?= htmlspecialchars($card['location']) ?></p>
                                </div>


                                <div class="box-progress-wrapper">
                                    <p class="box-progress-header">viwe ( <?= htmlspecialchars($card['views']) ?> )</p>
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
            <div class="messages-section">
                <button class="messages-close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-x-circle">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                </button>
                <div class="projects-section-header">
                    <p>Client </p>

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
                                <div class="img">
                                    <?= htmlspecialchars($row['id']) ?>
                                </div>
                                <div class="message-content">
                                    <div class="message-header">
                                        <div class="name"><?= htmlspecialchars($row['country'] ?? 'Unknown') ?></div>
                                        <div class="star-checkbox">
                                            <input type="checkbox" id="star-4">
                                            <label for="star-4">
                                                <a href="?delete_visitor=<?= urlencode($row['id']) ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-star">
                                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 
                                        18.18 21.02 12 17.77 5.82 21.02 7 14.14 
                                        2 9.27 8.91 8.26 12 2" />
                                                    </svg>
                                                </a>
                                            </label>
                                        </div>
                                    </div>
                                    <p class="message-line">
                                        ID / <?= htmlspecialchars($row['ip_address'] ?? 'Unknown') ?>
                                    </p>
                                    <p class="message-line time">
                                        <?= htmlspecialchars($date) ?> / <?= htmlspecialchars($time) ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <li class="mt-5 mb-5">No visitors yet</li>
                        <?php
                    }
                    ?>


                </div>
            </div>
        </div>
    </div>



    <!-- ammar -->

</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modeSwitch = document.querySelector('.mode-switch');

        modeSwitch.addEventListener('click', function () {
            document.documentElement.classList.toggle('dark');
            modeSwitch.classList.toggle('active');
        });

        var listView = document.querySelector('.list-view');
        var gridView = document.querySelector('.grid-view');
        var projectsList = document.querySelector('.project-boxes');

        listView.addEventListener('click', function () {
            gridView.classList.remove('active');
            listView.classList.add('active');
            projectsList.classList.remove('jsGridView');
            projectsList.classList.add('jsListView');
        });

        gridView.addEventListener('click', function () {
            gridView.classList.add('active');
            listView.classList.remove('active');
            projectsList.classList.remove('jsListView');
            projectsList.classList.add('jsGridView');
        });

        document.querySelector('.messages-btn').addEventListener('click', function () {
            document.querySelector('.messages-section').classList.add('show');
        });

        document.querySelector('.messages-close').addEventListener('click', function () {
            document.querySelector('.messages-section').classList.remove('show');
        });
    });
</script>

<script>
    function openModal() {
        document.getElementById("popupModal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("popupModal").style.display = "none";
    }

    window.onclick = function (event) {
        const modal = document.getElementById("popupModal");
        if (event.target === modal) {
            closeModal();
        }
    }
</script>



</html>