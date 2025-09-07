<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include './config/db.php';
$ip = $_SERVER['REMOTE_ADDR'];
if (in_array($ip, ['127.0.0.1', '::1'])) {
    $ip = '8.8.8.8';
}
$country = 'Unknown';
$response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country", false, stream_context_create([
    'http' => ['timeout' => 2]
]));

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
    <title>Ammar Ahmed Mostafa – Full Stack Web Developer & Designer</title>
    <meta name="description"
        content="Ammar Ahmed Mostafa is a Full Stack Web Developer & SEO Specialist with experience in PHP, HTML, CSS, JavaScript, Python, and modern technologies. Explore his professional portfolio, skills, and web projects.">
    <meta name="keywords"
        content="Ammar Ahmed Mostafa, Ammar Ahmed, Full Stack Developer, Web Developer Egypt, Portfolio, PHP, HTML, CSS, JavaScript, SQL, Python, AI Developer, ChatGPT, Frontend Developer, Backend Developer, UX UI, Web Design, Responsive Design, SEO Specialist, Web Projects, Cairo Developer, Freelancer Developer, Modern Websites, Dynamic Web Design, Bootstrap, GitHub, Ammarx3, ammar132004@gmail.com">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="./index.php">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Ammar Ahmed Mostafa – Full Stack Developer & Designer">
    <meta property="og:description"
        content="Visit Ammar Ahmed Mostafa's portfolio to explore modern web design and development projects using cutting-edge technologies.">
    <meta property="og:image" content="http://localhost:8888/ammar/assets/img/web-developer-ammar-ahmed.jpg">
    <meta property="og:url" content="http://localhost:8888/ammar/">
    <meta property="og:site_name" content="Ammar Ahmed Portfolio">
    <meta property="article:author" content="https://www.linkedin.com/in/eng-ammar-ahmed/">
    <meta name="facebook-profile" content="https://www.facebook.com/eng.amaar.ah.med/">
    <meta name="instagram-profile" content="https://www.instagram.com/3mmarx3/">
    <link rel="stylesheet" href="./assets/css/main.css">
    <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "Ammar Ahmed Mostafa",
    "url": "https://eng-ammar.com",
    "image": "http://localhost:8888/ammar/assets/img/ammar-ahmed.webp",
    "sameAs": [
      "https://github.com/https-Ammar",
      "https://linkedin.com/in/ammar-mostafa",
      "https://www.facebook.com/eng.amaar.ah.med/",
      "https://www.instagram.com/3mmarx3/"
    ],
    "jobTitle": "Full Stack Developer & SEO Specialist",
    "worksFor": {
      "@type": "Organization",
      "name": "Freelancer"
    },
    "email": "mailto:ammar132004@gmail.com",
    "nationality": "Egyptian",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "EG"
    },
    "description": "Ammar Ahmed Mostafa is a detail-oriented Full Stack Developer with expertise in building high-performance, SEO-optimized web applications with modern design and scalability in mind."
  }
  </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NB128WD6QV"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-NB128WD6QV');
    </script>
</head>

<body data-barba="wrapper">
    <?php include './includes/loading.php'; ?>
    <main class="main" id="home" data-barba="container" data-barba-namespace="home">
        <?php include './includes/header.php'; ?>
        <div class="main-wrap" data-scroll-container>
            <header class="section home-header theme-dark" data-scroll-section>
                <?php include './includes/nav.php'; ?>
                <div class="overlay personal-image no-select once-in" data-scroll data-scroll-speed="-3"
                    data-scroll-position="top">
                    <img src="./assets/img/eng-ammar.webp" alt="Ammar Ahmed - Front-End Developer and UI/UX Specialist"
                        title="Ammar Ahmed - Front-End Developer and UI/UX Specialist" loading="lazy" decoding="async">
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
                                <a href="./page/about.php" class="btn-click magnetic">
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
                                                    <img src="./assets/img/anc.webp"
                                                        alt="Ammar Ahmed - Animated Network Card Illustration"
                                                        title="Ammar Ahmed - Network Card Design" width="210"
                                                        height="auto" loading="lazy" decoding="async"
                                                        style="width: 210px; height: auto; display: block;">
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
                                                    <img src="./assets/img/glamora.webp"
                                                        alt="Ammar Ahmed - Glamora Project UI Design"
                                                        title="Glamora Project by Ammar Ahmed - UI/UX Design Showcase"
                                                        width="210" height="auto" loading="lazy" decoding="async"
                                                        style="width: 210px; height: auto; display: block;">
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
            <?php include './includes/footer.php'; ?>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.js"></script>
    <script defer src="./assets/js/index-new.js"></script>
</body>

</html>