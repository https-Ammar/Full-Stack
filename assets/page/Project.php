<?php
include 'db.php';

$ip = $_SERVER['REMOTE_ADDR'];
if ($ip === '127.0.0.1' || $ip === '::1') {
    $ip = '8.8.8.8';
}

$country = 'غير معروف';
$response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country");
if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data['country'])) {
        $country = $data['country'];
    }
}

$stmt = $conn->prepare("INSERT INTO visitors (ip_address, country) VALUES (?, ?)");
if ($stmt) {
    $stmt->bind_param("ss", $ip, $country);
    $stmt->execute();
    $stmt->close();
} else {
    error_log("Failed to prepare statement: " . $conn->error);
}

$sql = "SELECT * FROM cards ORDER BY id DESC";
$result = $conn->query($sql);

$cards = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }
} else {
    error_log("Failed to fetch cards: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Blog</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/style.css">


    <style>
        .card-details {
            display: none;
        }

        .card-details:first-child {
            display: block;
        }
    </style>

</head>

<body>
    <aside id="head"></aside>




    <section class="news-standard fix section-padding">
        <div class="container p-0">
            <div class="row g-4">
                <div class="col-12 col-lg-8">

                    <?php foreach ($cards as $card):
                        $id = (int) $card['id'];
                        $title = htmlspecialchars($card['title']);
                        $cover_image = htmlspecialchars($card['cover_image']);
                        $second_image = htmlspecialchars($card['second_image']);
                        $description = nl2br(htmlspecialchars($card['description']));
                        $link = htmlspecialchars($card['link']);
                        $created_at = htmlspecialchars($card['created_at']);
                    ?>


                        <div class="news-standard-wrapper">
                            <div class="news-standard-items card-details" id="details-<?= $id ?>">
                                <div class="news-thumb">
                                    <img src="uploads/<?= $cover_image ?>" alt="img" />
                                </div>
                                <div class="news-content">
                                    <ul>
                                        <li><i class="bi bi-person"></i> <?= $created_at ?></li>
                                        <li><i class="bi bi-folder2-open"></i> digital art</li>
                                    </ul>
                                    <h3><a href="<?= $link ?>"><?= $title ?></a></h3>
                                    <p><?= $description ?></p>
                                    <a href="<?= $link ?>" class="theme-btn mt-4 mb-3">
                                        Read More
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                    <div class="page-nav-wrap pt-5 text-center">
                        <ul>
                            <li><a class="page-numbers" href="#">1</a></li>
                            <li><a class="page-numbers" href="#">2</a></li>
                            <li><a class="page-numbers" href="#">3</a></li>
                            <li><a class="page-numbers" href="#"><i class="bi bi-arrow-right"></i></a></li>
                        </ul>
                    </div>

                </div>

                <div class="col-12 col-lg-4">
                    <div class="main-sidebar">

                        <div class="single-sidebar-widget">
                            <div class="wid-title">
                                <h3><img src="../img/star-3.png" alt="img" /> Search</h3>
                            </div>
                            <div class="search-widget">
                                <form id="searchForm" onsubmit="return false;">
                                    <input type="text" placeholder="Search here" id="searchInput" />
                                    <button type="submit" id="searchBtn"><i class="bi bi-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <div class="single-sidebar-widget">
                            <div class="wid-title">
                                <h3><img src="../img/star-3.png" alt="img" /> Categories</h3>
                            </div>
                            <div class="news-widget-categories">
                                <ul>
                                    <?php foreach ($cards as $card):
                                        $id = (int) $card['id'];
                                        $title = htmlspecialchars($card['title']);
                                    ?>
                                        <li><a href="#" onclick="toggleDetails(<?= $id ?>); return false;"><?= $title ?></a>
                                            <span>(08)</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                        <div class="single-sidebar-widget">
                            <div class="wid-title">
                                <h3><img src="../img/star-3.png" alt="img" /> Recent Post</h3>
                            </div>
                            <div class="recent-post-area">
                                <div class="recent-items">
                                    <div class="recent-thumb">
                                        <img src="../img/pp4.jpg" alt="img" />
                                    </div>
                                    <div class="recent-content">
                                        <span>digital</span>
                                        <h6><a href="news-details.html">Forms without realistic represent
                                                areterm</a>
                                        </h6>
                                        <ul>
                                            <li><i class="bi bi-calendar2-week"></i> 18 Dec, 2024</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="single-sidebar-widget">
                            <div class="wid-title">
                                <h3><img src="../img/star-3.png" alt="img" /> Tags Clouds</h3>
                            </div>
                            <div class="news-widget-categories">
                                <div class="tagcloud">
                                    <a href="news-standard.html">creativity</a>
                                    <a href="news-details.html">reality</a>
                                    <a href="news-details.html">focus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function toggleDetails(id) {
            let allDetails = document.querySelectorAll('.card-details');
            allDetails.forEach(div => {
                if (div.id === 'details-' + id) {
                    div.style.display = (div.style.display === 'block') ? 'none' : 'block';
                } else {
                    div.style.display = 'none';
                }
            });
        }

        function searchCards() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const categoryLinks = document.querySelectorAll('.news-widget-categories ul li a');

            if (input.trim() === '') {
                categoryLinks.forEach(link => {
                    link.parentElement.style.display = 'list-item';
                });
                return;
            }

            categoryLinks.forEach(link => {
                const text = link.textContent.toLowerCase();
                if (text.includes(input)) {
                    link.parentElement.style.display = 'list-item';
                } else {
                    link.parentElement.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('searchBtn').addEventListener('click', searchCards);
            document.getElementById('searchInput').addEventListener('keyup', (e) => {
                if (e.key === 'Enter') {
                    searchCards();
                }
            });
        });
    </script>
    <script src="../js/audio-script.js"></script>
    <script src="../js/script.js"></script>
    <style>
        .news-content h3 a {
            color: black !important;
        }

        .single-sidebar-widget {
            background: black !important;
        }



        .news-widget-categories ul li {
            background: #effb52 !important;
            color: white !important;
        }

        a.page-numbers {
            color: black !important;
        }
    </style>
</body>

</html>