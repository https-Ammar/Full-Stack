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
}

$sql = "SELECT * FROM cards ORDER BY id DESC";
$result = $conn->query($sql);

$cards = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }
}

$card = null;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM cards WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $card = $result->fetch_assoc();
        } else {
            exit("Card not found.");
        }
        $stmt->close();
    } else {
        exit("Database error: " . $conn->error);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ammar Ahmed</title>
    <link rel="stylesheet" href="./assets/css/css.css ">
</head>
<body data-barba="wrapper">


          <?php include './assets/page/loading.php'; ?>


    
    <main class="main" id="home" data-barba="container" data-barba-namespace="home">

        <div class="mouse-pos-list-btn no-select"></div>
        <div class="mouse-pos-list-span no-select">
            <p>View</p>
        </div>



          <?php include './assets/page/header.php'; ?>

        
        <div class="main-wrap" data-scroll-container >


            <header class="section home-header theme-dark" data-scroll-section>
                <div class="overlay personal-image no-select once-in" data-scroll data-scroll-speed="-3"
                    data-scroll-position="top">
                    <img src="https://portfolio-sigma-lemon-83.vercel.app/img/IMG_8661.PNG" />
                </div>
                <div class="overlay get-height once-in once-in-secondary">
                    <div class="hanger">
                        <p><span>Located </span><span>in the </span><span>Egypt</span></p>
                        <?xml version="1.0" encoding="UTF-8"?>
                        <svg width="300px" height="121px" viewBox="0 0 300 121" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>Combined Shape</title>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Artboard" transform="translate(0.000000, -366.000000)" fill="#1C1D20">
                                    <g id="Group"
                                        transform="translate(149.816828, 426.633657) rotate(90.000000) translate(-149.816828, -426.633657) translate(89.816828, 276.816828)">
                                        <g id="Hanger"
                                            transform="translate(60.000000, 149.816828) rotate(-90.000000) translate(-60.000000, -149.816828) translate(-89.816828, 89.816828)">
                                            <path
                                                d="M239.633657,0 C272.770742,1.0182436e-15 299.633657,26.862915 299.633657,60 C299.633657,93.137085 272.770742,120 239.633657,120 L0,120 L0,0 L239.633657,0 Z M239.633657,18.7755102 C216.866,18.7755102 198.409167,37.232343 198.409167,60 C198.409167,82.767657 216.866,101.22449 239.633657,101.22449 C262.401314,101.22449 280.858147,82.767657 280.858147,60 C280.858147,37.232343 262.401314,18.7755102 239.633657,18.7755102 Z"
                                                id="Combined-Shape"></path>
                                        </g>
                                    </g>
                                </g>
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
                
                <div class="nav-bar">
                    <div class="credits-top">
                        <div class="btn btn-link btn-left-top">
                            <a href="https://dennissnellenberg.com" class="btn-click magnetic" data-strength="20"
                                data-strength-text="10">
                                <span class="btn-text">
                                    <div class="credit"><span>©</span></div>
                                    <div class="cbd"><span class="code-by">Code by </span><span class="dennis"><span
                                                class="dennis-span">Dennis</span> <span
                                                class="snellenberg">Snellenberg</span></span>
                                </span>
                        </div>
                        </span>
                        </a>
                    </div>
                </div>
                <ul class="links-wrap">


                    
                    <li class="btn btn-link">
                        <a href="./assets/page/Project.php" class="btn-click magnetic" data-strength="20"
                            data-strength-text="10">
                            <span class="btn-text">
                                <span class="btn-text-inner">Home</span>
                            </span>
                        </a>
                    </li>


                                 <li class="btn btn-link">
                        <a href="./assets/page/About.php" class="btn-click magnetic" data-strength="20"
                            data-strength-text="10">
                            <span class="btn-text">
                                <span class="btn-text-inner">About</span>
                            </span>
                        </a>
                    </li>



                    <li class="btn btn-link">
                        <a href="./assets/page/Project.php" class="btn-click magnetic" data-strength="20"
                            data-strength-text="10">
                            <span class="btn-text">
                                <span class="btn-text-inner">Work</span>
                            </span>
                        </a>
                    </li>
       

                         <li class="btn btn-link">
                        <a href="./assets/page/Skills.php" class="btn-click magnetic" data-strength="20"
                            data-strength-text="10">
                            <span class="btn-text">
                                <span class="btn-text-inner">Skils</span>
                            </span>
                        </a>
                    </li>

                    

                    <li class="btn btn-link">
                        <a href="./assets/page/Contact.php" class="btn-click magnetic" data-strength="20"
                            data-strength-text="10">
                            <span class="btn-text">
                                <span class="btn-text-inner">Contact</span>
                            </span>
                        </a>
                    </li>
                    <li class="btn btn-link btn-menu">
                        <div class="btn-click magnetic" data-strength="20" data-strength-text="10">
                            <div class="btn-text">
                                <span class="btn-text-inner">Menu</span>
                            </div>
                        </div>
                    </li>
                </ul>
        </div>

        
        <div class="container once-in once-in-secondary">
            <div class="row">
                <div class="flex-col">
                    <div class="header-above-h4" data-scroll data-scroll-speed="1">
                        <div class="arrow big">
                            <?xml version="1.0" encoding="UTF-8"?>
                            <svg width="14px" height="14px" viewBox="0 0 14 14" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>arrow-up-right</title>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Artboard" transform="translate(-1019.000000, -279.000000)" stroke="#FFFFFF"
                                        stroke-width="1.5">
                                        <g id="arrow-up-right"
                                            transform="translate(1026.000000, 286.000000) rotate(90.000000) translate(-1026.000000, -286.000000) translate(1020.000000, 280.000000)">
                                            <polyline id="Path" points="2.76923077 0 12 0 12 9.23076923"></polyline>
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
                    <h1 class="no-select once-in once-in-secondary">Ammar Ahmed<span class="spacer">—</span></h1>
                </div>
            </div>
        </div>
        <div class="white-block"></div>
        </header>


        
        <section class="section home-intro" data-scroll-section>
            <div class="container medium">
                <div class="row">
                    <div class="flex-col">
                        <h4 class="span-lines animate">Helping brands to stand out in the digital era. Together we will
                            set the new status quo. No nonsense, always on the cutting edge.</h4>
                    </div>
                    <div class="flex-col">
                        <div class="text-wrap fade-in animate">
                            <p>The combination of my passion for design, code & interaction positions me in a unique
                                place in the web design world.</p>
                        </div>
                        <div class="btn btn-round" data-scroll data-scroll-speed="2">
                            <a href="https://dennissnellenberg.com/about" class="btn-click magnetic "
                                data-strength="100" data-strength-text="50">
                                <div class="btn-fill"></div>
                                <span class="btn-text">
                                    <span class="btn-text-inner">About me</span>
                                </span>
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
                    <!-- <div class="flex-col">
            <h5>Services</h5>
         </div> -->
                </div>

                <ul class="work-items mouse-pos-list-image-wrap">

<?php foreach ($cards as $card):
    $id = (int) ($card['id'] ?? 0);
    $title = htmlspecialchars($card['title'] ?? '');
    $cover_image = htmlspecialchars($card['cover_image'] ?? '');
    $second_image = htmlspecialchars($card['second_image'] ?? '');
    $description = nl2br(htmlspecialchars($card['description'] ?? ''));
    $link = htmlspecialchars($card['link'] ?? '');
    $created_at = htmlspecialchars($card['created_at'] ?? '');
?>

<li class="development interaction visible">
    <div class="stripe animate"></div>
    <a href="<?= $link ?>" class="row">
        <div class="flex-col">
            <h4><span><?= $title ?> </span></h4>
        </div>
        <div class="flex-col animate">
            <p><?= $description ?></p>
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
                                <a href="https://dennissnellenberg.com/work/avvr" class="row">
                                    <div class="flex-col">
                                        <div class="tile-image">
                                            <div class="overlay overlay-color" style="background-color: #D8D3CD;"></div>
                                            <div class="overlay overlay-image lazy"
                                                style="background-position: center center; background-repeat: no-repeat; background-size: cover;"
                                                data-bg="https://dennissnellenberg.com/media/pages/work/avvr/4d2a7758a4-1672918357/thumbnail-avvr-v2.jpg">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-col">
                                        <h4><span>AVVR</span></h4>
                                        <div class="stripe"></div>
                                    </div>
                                    <div class="flex-col">
                                        <p>Design &amp; Development</p>
                                    </div>
                                    <div class="flex-col">
                                        <p>2023</p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li class="design development visible">
                            <div class="single-tile-wrap">
                                <a href="https://dennissnellenberg.com/work/graphichunters" class="row">
                                    <div class="flex-col">
                                        <div class="tile-image">
                                            <div class="overlay overlay-color" style="background-color: #7E7E7E;"></div>
                                            <div class="overlay overlay-image lazy"
                                                style="background-position: center center; background-repeat: no-repeat; background-size: cover;"
                                                data-bg="https://dennissnellenberg.com/media/pages/work/graphichunters/0daec771af-1660128857/thumbnail-gh.jpg">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-col">
                                        <h4><span>GraphicHunters</span></h4>
                                        <div class="stripe"></div>
                                    </div>
                                    <div class="flex-col">
                                        <p>Design &amp; Development</p>
                                    </div>
                                    <div class="flex-col">
                                        <p>2022</p>
                                    </div>
                                </a>
                            </div>
                        </li>


                    </ul>
                </div>

            </section>


        </section>



          <?php include './assets/page/footer.php'; ?>


    

    </main>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>
    <script src="./assets/js/locomotive-scroll.min.js"></script>
    <script defer src="./assets/js/index-new.js"></script>
    <style>
        .row.bottom-footer {
            padding-left: 0;
            padding-right: 0;
        }
    </style>
</body>

</html>