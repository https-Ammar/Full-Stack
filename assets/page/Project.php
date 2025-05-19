<?php
include 'db.php';

$ip = $_SERVER['REMOTE_ADDR'];
if ($ip === '127.0.0.1' || $ip === '::1') {
    $ip = '8.8.8.8';
}

$country = 'Unknown';
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
    <?php include './head_links.php'; ?>
</head>

<body>
    <aside id="head"></aside>

    <section class="news-standard fix section-padding">
        <div class="container p-0">
            <div class="row g-4">

                <?php if (empty($cards)): ?>

                    <section class="error-section style-padding fix">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-9">
                                    <div class="error-items">
                                        <div class="error-image wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                            <img src="../img/error.png" alt="img">
                                        </div>
                                        <h2 class="wow fadeInUp" data-wow-delay=".3s"
                                            style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                                            <p class="text-muted mb-0"><i class="bi bi-info-circle"></i> No Projects available.</p>
                                        </h2>

                                        <a href="https://eng-ammar.com/" class="theme-btn wow fadeInUp" data-wow-delay=".7"
                                            style="visibility: visible; animation-name: fadeInUp;">
                                            Go Back Home
                                            <i class="fa-solid fa-arrow-right-long"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                <?php else: ?>

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
                                <div class="news-standard-items card-details" id="details-<?= $id ?>" style="display: none;">
                                    <div class="news-thumb">
                                        <img src="uploads/<?= $cover_image ?>" alt="cover image" />
                                    </div>
                                    <div class="news-content">
                                        <ul>
                                            <li><i class="bi bi-calendar-check"></i> <?= $created_at ?></li>
                                            <li><i class="bi bi-tags"></i> Digital Art</li>
                                        </ul>
                                        <h3><a href="<?= $link ?>"><?= $title ?></a></h3>
                                        <p><?= $description ?></p>
                                        <a href="<?= $link ?>" class="theme-btn mt-4 mb-3">
                                            Read More
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="page-nav-wrap pt-5 text-center">
                            <ul>
                                <?php foreach ($cards as $index => $card): ?>
                                    <li>
                                        <a class="page-numbers" href="#" onclick="toggleDetails(<?= $card['id'] ?>); return false;">
                                            <?= $index + 1 ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="main-sidebar">

                            <div class="single-sidebar-widget">
                                <div class="wid-title">
                                    <h3><img src="../img/star-3.png" alt="star icon" /> Search</h3>
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
                                    <h3><img src="../img/star-3.png" alt="star icon" /> Categories</h3>
                                </div>
                                <div class="news-widget-categories">
                                    <ul>
                                        <?php foreach ($cards as $card):
                                            $id = (int) $card['id'];
                                            $title = htmlspecialchars($card['title']);
                                        ?>
                                            <li><a href="#" onclick="toggleDetails(<?= $id ?>); return false;"><i class="bi bi-folder"></i> <?= $title ?></a>
                                                <span>(08)</span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="single-sidebar-widget">
                                <div class="wid-title">
                                    <h3><img src="../img/star-3.png" alt="star icon" /> Recent Post</h3>
                                </div>
                                <div class="recent-post-area">
                                    <?php
                                    if (!empty($cards)) {
                                        $random_card = $cards[array_rand($cards)];

                                        $random_title = htmlspecialchars($random_card['title']);
                                        $random_image = htmlspecialchars($random_card['cover_image']);
                                        $random_link = htmlspecialchars($random_card['link']);
                                        $random_date = htmlspecialchars($random_card['created_at']);
                                    ?>
                                        <div class="recent-items">
                                            <div class="recent-thumb">
                                                <img style="width: 140px; height: 140px;" src="uploads/<?= $random_image ?>" alt="recent post image" />
                                            </div>
                                            <div class="recent-content">
                                                <span><i class="bi bi-lightning"></i> Digital</span>
                                                <h6><a href="<?= $random_link ?>"><?= $random_title ?></a></h6>
                                                <ul>
                                                    <li><i class="bi bi-calendar2-week"></i> <?= $random_date ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php } else { ?>


                                        <p class="text-muted mb-0"><i class="bi bi-info-circle"></i> No Projects available.</p>


                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </section>

    <script>
        function toggleDetails(id) {
            let allDetails = document.querySelectorAll('.card-details');
            allDetails.forEach(div => {
                div.style.display = (div.id === 'details-' + id) ? 'block' : 'none';
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
                link.parentElement.style.display = text.includes(input) ? 'list-item' : 'none';
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
    <script>
        function toggleDetails(id) {
            let allDetails = document.querySelectorAll('.card-details');
            allDetails.forEach(div => {
                div.style.display = (div.id === 'details-' + id) ? 'block' : 'none';
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
                link.parentElement.style.display = text.includes(input) ? 'list-item' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Show the first card details by default
            toggleDetails(<?= $cards[0]['id'] ?>);

            document.getElementById('searchBtn').addEventListener('click', searchCards);
            document.getElementById('searchInput').addEventListener('keyup', (e) => {
                if (e.key === 'Enter') {
                    searchCards();
                }
            });
        });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>