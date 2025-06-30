<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$ip = $_SERVER['REMOTE_ADDR'];
if ($ip === '127.0.0.1' || $ip === '::1') {
    $ip = '8.8.8.8';
}

$country = 'Unknown';

$ctx = stream_context_create([
    'http' => [
        'timeout' => 2
    ]
]);

$response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country", false, $ctx);
if ($response !== false) {
    $data = json_decode($response, true);
    if (!empty($data['country'])) {
        $country = $data['country'];
    }
}

$stmt = $conn->prepare("SELECT id FROM visitors WHERE ip_address = ? AND created_at >= NOW() - INTERVAL 1 DAY");
$stmt->bind_param("s", $ip);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();
    $insert = $conn->prepare("INSERT INTO visitors (ip_address, country, created_at) VALUES (?, ?, NOW())");
    $insert->bind_param("ss", $ip, $country);
    $insert->execute();
    $insert->close();
} else {
    $stmt->close();
}

$cards = [];
$result = $conn->query("SELECT * FROM cards ORDER BY id DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }
}

$card = null;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM cards WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $card = $result->fetch_assoc();
    } else {
        exit("Card not found.");
    }
    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ammar Ahmed</title>
    <link rel="stylesheet" href="./assets/css/main.css">
</head>

<body data-barba="wrapper">
    <?php include './assets/page/loading.php'; ?>



    <main class="main" id="home" data-barba="container" data-barba-namespace="home">

        <div class="mouse-pos-list-btn no-select"></div>
        <div class="mouse-pos-list-span no-select">
            <p>View</p>
        </div>

        <?php include './assets/page/header.php'; ?>

        <div class="main-wrap" data-scroll-container>


            <header class="section home-header theme-dark" data-scroll-section>
                <?php include './assets/page/nav.php'; ?>

                <div class="overlay personal-image no-select once-in" data-scroll data-scroll-speed="-3"
                    data-scroll-position="top">
                    <img src="https://portfolio-sigma-lemon-83.vercel.app/img/IMG_8661.PNG" />
                </div>

                <div class="overlay get-height once-in once-in-secondary">
                    <div class="hanger">
                        <p><span>Lives in Egypt</span></p>
                        <svg width="300px" height="121px" viewBox="0 0 300 121" xmlns="http://www.w3.org/2000/svg">
                            <g fill="#1C1D20">
                                <path
                                    d="M239.633657,0 C272.770742,1.0182436e-15 299.633657,26.862915 299.633657,60 C299.633657,93.137085 272.770742,120 239.633657,120 L0,120 L0,0 L239.633657,0 Z M239.633657,18.7755102 C216.866,18.7755102 198.409167,37.232343 198.409167,60 C198.409167,82.767657 216.866,101.22449 239.633657,101.22449 C262.401314,101.22449 280.858147,82.767657 280.858147,60 C280.858147,37.232343 262.401314,18.7755102 239.633657,18.7755102 Z" />
                            </g>
                        </svg>

                        <div class="digital-ball">
                            <div class="overlay"></div>
                            <div class="globe">
                                <div class="globe-wrap">
                                    <div class="circle"></div>
                                    <div class="circle"></div>
                                    <div class="circle"></div>
                                    <div class="circle-hor"></div>
                                    <div class="circle-hor-middle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="container once-in once-in-secondary">
                    <div class="row">
                        <div class="flex-col">
                            <div class="header-above-h4" data-scroll data-scroll-speed="1">
                                <div class="arrow big">
                                    <svg width="14px" height="14px" viewBox="0 0 14 14" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <title>arrow-up-right</title>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g id="Artboard" transform="translate(-1019.000000, -279.000000)"
                                                stroke="#FFFFFF" stroke-width="1.5">
                                                <g id="arrow-up-right"
                                                    transform="translate(1026.000000, 286.000000) rotate(90.000000) translate(-1026.000000, -286.000000) translate(1020.000000, 280.000000)">
                                                    <polyline id="Path" points="2.76923077 0 12 0 12 9.23076923">
                                                    </polyline>
                                                    <line x1="12" y1="0" x2="0" y2="12" id="Path"></line>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <h4><span>Freelance</span> Designer & Developer</h4>
                        </div>
                    </div>
                </div>

                <div class="big-name">
                    <div class="name-h1" data-scroll data-scroll-direction="horizontal" data-scroll-speed="4"
                        data-scroll-position="top">
                        <div class="name-wrap">
                            <h1 class="no-select once-in once-in-secondary">Ammar Ahmed<span class="spacer">—</span>
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="white-block"></div>
            </header>

            <section class="section home-intro" data-scroll-section>
                <div class="container medium">
                    <div class="row">
                        <div class="flex-col">
                            <h4 class="span-lines animate">Helping brands to stand out in the digital era. Together we
                                will set the new status quo. No nonsense, always on the cutting edge.</h4>
                        </div>
                        <div class="flex-col">
                            <div class="text-wrap fade-in animate">
                                <p>The combination of my passion for design, code & interaction positions me in a unique
                                    place in the web design world.</p>
                            </div>
                            <div class="btn btn-round" data-scroll data-scroll-speed="2">
                                <a href="https://dennissnellenberg.com/about" class="btn-click magnetic">
                                    <div class="btn-fill"></div>
                                    <span class="btn-text-inner">About me</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section work-grid large-work-grid" data-scroll-section>
                <div class="container">
                    <div class="grid-sub-title">
                        <div class="flex-col">
                            <h5>Recent work</h5>
                        </div>
                    </div>
                    <ul class="work-items mouse-pos-list-image-wrap">
                        <?php foreach ($cards as $card): ?>
                            <li class="development interaction visible">
                                <div class="stripe animate"></div>
                                <a href="<?= htmlspecialchars($card['link'], ENT_QUOTES, 'UTF-8') ?>" class="row">
                                    <div class="flex-col">
                                        <h4><span><?= htmlspecialchars($card['title']) ?></span></h4>
                                    </div>
                                    <div class="flex-col animate">
                                        <p><?= nl2br(htmlspecialchars($card['services'])) ?></p>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <div class="stripe last animate"></div>
                    </ul>
                </div>

                <section class="section work-tiles grid-fade grid-columns-part visible">
                    <div class="container">
                        <ul>
                            <li class="design development interaction visible">
                                <div class="single-tile-wrap">
                                    <a href="#" class="row">
                                        <div class="flex-col">
                                            <div class="tile-image">
                                                <div class="overlay overlay-color" style="background-color: #D8D3CD;">
                                                </div>
                                                <div class="overlay overlay-image lazy">
                                                    <img src="./assets/img/anc.png" alt="anc-compan"
                                                        style="width: 210px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-col">
                                            <h4><span>anc-compan</span></h4>
                                            <div class="stripe"></div>
                                        </div>
                                        <div class="flex-col">
                                            <p>Design & Development</p>
                                        </div>
                                        <div class="flex-col">
                                            <p>2024</p>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li class="design development interaction visible">
                                <div class="single-tile-wrap">
                                    <a href="#" class="row">
                                        <div class="flex-col">
                                            <div class="tile-image">
                                                <div class="overlay overlay-color" style="background-color: #D8D3CD;">
                                                </div>
                                                <div class="overlay overlay-image lazy">
                                                    <img src="./assets/img/glamora.png" alt="glamora"
                                                        style="width: 210px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-col">
                                            <h4><span>glamora</span></h4>
                                            <div class="stripe"></div>
                                        </div>
                                        <div class="flex-col">
                                            <p>Design & Development</p>
                                        </div>
                                        <div class="flex-col">
                                            <p>2024</p>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </section>
            </section>

            <?php include './assets/page/footer.php'; ?>

        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>
    <script src="./assets/js/locomotive-scroll.min.js"></script>
    <script defer src="./assets/js/index-new.js"></script>



    <script>
        const newPaths = {
            "Home": "/home.php",
            "About": "./assets/page/About.php",
            "Work": "./assets/page/Project.php",
            "Skills": "./assets/page/Skills.php",
            "Contact": "./assets/page/Contact.php"
        };

        document.querySelectorAll('.links-wrap a').forEach(link => {
            const innerText = link.innerText.trim().toLowerCase();

            for (let key in newPaths) {
                if (innerText === key.toLowerCase()) {
                    link.setAttribute('href', newPaths[key]);
                }
            }
        });

        const newSocials = {
            "Awwwards": "https://example.com/awwwards",
            "Instagram": "https://example.com/insta",
            "Twitter": "https://example.com/twitter",
            "LinkedIn": "https://example.com/linkedin"
        };

        document.querySelectorAll('.socials a').forEach(link => {
            const text = link.innerText.trim();
            if (newSocials[text]) {
                link.setAttribute('href', newSocials[text]);
            }
        });

    </script>


</body>

</html>