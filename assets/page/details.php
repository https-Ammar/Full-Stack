<?php
include 'db.php';

$cards = [];
$sql = "SELECT * FROM cards ORDER BY id DESC";
$result = $conn->query($sql);

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

$current_page = isset($card['title']) ? htmlspecialchars($card['title']) : 'Work';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $current_page; ?></title>
    <link rel="stylesheet" href="../css/main.css">
</head>

<body data-barba="wrapper">
    <?php include './loading.php'; ?>

    <main class="main" id="work-single" data-barba="container" data-barba-namespace="work-single">
        <?php include './header.php'; ?>

        <div class="main-wrap" data-scroll-container>
            <section class="section case-top-wrap">
                <header class="section default-header case-header" data-scroll-section>
                    <?php include './nav.php'; ?>
                    <div class="container medium once-in">
                        <div class="row">
                            <div class="flex-col">

                                <a href="<?php echo htmlspecialchars($card['link']); ?>">

                                    <h1><?php echo htmlspecialchars($card['title']); ?></h1>
                                </a>
                                <hr>
                                <br>
                                <p>Lorem ipsum dolor sit.</p>

                            </div>
                        </div>
                    </div>
                </header>


                <section class="section case-intro-image once-in block-padding-bottom" data-scroll-section>
                    <div class="container">
                        <div class="row">
                            <div class="flex-col">
                                <div class="btn-wrap theme-dark">
                                    <div class="btn btn-round" data-scroll data-scroll-speed="2"
                                        data-scroll-position="top">
                                        <a href="<?php echo htmlspecialchars($card['link']); ?>" target="_blank"
                                            class="btn-click magnetic" data-strength="100" data-strength-text="50">
                                            <div class="btn-fill"></div>
                                            <span class="btn-text">
                                                <span class="btn-text-inner">Live site<div class="arrow"></div></span>
                                            </span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </section>



            <section class="section single-block block-device block_0 block-padding-bottom"
                style="background-color: #d8d5cc;" data-scroll-section>
                <div class="container">
                    <div class="row device-macprohigher">
                        <div class="flex-col">
                            <div class="device">


                                <div class="single-image"
                                    style="background: url(../dashboard/uploads/<?php echo htmlspecialchars($card['image2'] ?? ''); ?>);">
                                    <div class="overlay overlay-image playpauze">
                                        <video muted playsinline></video>
                                    </div>
                                </div>
                                <div class="overlay-device-image">
                                    <div class="overlay overlay-device"
                                        style="background: url('../img/device-macpro-higher.png') center center no-repeat; background-size: cover;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section single-block block-mobile-devices block_1" data-scroll-section>
                <div class="container no-padding block-padding-sides amount-3">
                    <div class="row device-iphone13nonotch">
                        <div class="flex-col block-padding-bottom">
                            <div class="device" data-scroll data-scroll-target=".block_1" data-scroll-speed="-1">
                                <img src="../dashboard/uploads/<?php echo htmlspecialchars($card['image3'] ?? ''); ?>"
                                    alt="glamora">
                            </div>
                        </div>
                        <div class="flex-col block-padding-bottom">
                            <div class="device">
                                <img src="../dashboard/uploads/<?php echo htmlspecialchars($card['image4'] ?? ''); ?>"
                                    alt="glamora">
                            </div>
                        </div>
                        <div class="flex-col block-padding-bottom">
                            <div class="device" data-scroll data-scroll-target=".block_1" data-scroll-speed="1">
                                <img src="../dashboard/uploads/<?php echo htmlspecialchars($card['image5'] ?? ''); ?>"
                                    alt="glamora">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section single-block block-device block_2 block-padding-bottom"
                style="background-color: #d8d5cc;" data-scroll-section>
                <div class="container">
                    <div class="row device-ipadpro">
                        <div class="flex-col">
                            <div class="device">
                                <div class="single-image">
                                    <div class="overlay overlay-image playpauze">
                                        <video class="overlay" loop muted playsinline>
                                            <style>
                                                video.overlay {
                                                    background: url(../dashboard/uploads/<?php echo htmlspecialchars($card['image6'] ?? ''); ?>);
                                                    background-size: cover;
                                                    background-position: center center;
                                                    background-repeat: no-repeat;
                                                }
                                            </style>
                                        </video>
                                    </div>
                                </div>
                                <div class="overlay-device-image">
                                    <div class="overlay overlay-device"
                                        style="background: url('../img/device-ipad-pro-lower.png') center center no-repeat; background-size: cover;">
                                    </div>
                                    <img class="overlay overlay-pencil lazy" data-scroll data-scroll-speed="1.5"
                                        data-src="../img/device-apple-pencil.png" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </section>
            <section class="section case-intro once-in" data-scroll-section>
                <div class="container medium">
                    <div class="row">
                        <div class="flex-col">
                            <h5>Role / Services</h5>
                            <div class="stripe"></div>
                            <li>
                                <p><?php echo nl2br(htmlspecialchars($card['services'] ?? '')); ?></p>
                            </li>
                        </div>
                        <div class="flex-col">
                            <h5>Credits</h5>
                            <div class="stripe"></div>
                            <li>
                                <p><?php echo nl2br(htmlspecialchars($card['extra_text'] ?? '')); ?></p>
                            </li>
                        </div>
                        <div class="flex-col">
                            <h5>Location & year</h5>
                            <div class="stripe"></div>
                            <li>
                                <p><?php echo htmlspecialchars($card['location']); ?> ©</p>
                            </li>
                            <li>
                                <p><?php echo htmlspecialchars($card['year']); ?></p>
                            </li>
                        </div>
                    </div>
                </div>
            </section>

            <?php include './footer.php'; ?>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>
    <script src="../js/locomotive-scroll.min.js"></script>
    <script defer src="../js/index-new.js"></script>
</body>

</html>