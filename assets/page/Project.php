<?php
include 'db.php';

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
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css ">

</head>

<body data-barba="wrapper">
    <?php $current_page = 'Work'; ?>
    <?php include './loading.php'; ?>


    <main class="main" id="work" data-barba="container" data-barba-namespace="work">


        <div class="main-wrap" data-scroll-container>

            <?php include './header.php'; ?>

            <header class="section default-header work-header" data-scroll-section>
                <?php include './nav.php'; ?>


                <div class="container medium">
                    <div class="row">
                        <div class="flex-col once-in">
                            <h1>
                                <span>Creating next level </span>
                                <span>digital products</span>
                            </h1>
                        </div>
                    </div>
                </div>
            </header>

            <section class="section work-filters" data-scroll-section>
                <div class="container once-in">
                    <div class="filter-row">
                        <div class="toggle-row">
                            <div class="btn btn-normal all-btn active">
                                <div class="btn-click magnetic" data-strength="25" data-strength-text="15">
                                    <div class="btn-fill"></div>
                                    <span class="btn-text">
                                        <span class="btn-text-inner change">All</span>
                                    </span>
                                </div>
                            </div>
                            <div class="btn btn-normal design-btn">
                                <div class="btn-click magnetic" data-strength="25" data-strength-text="15">
                                    <div class="btn-fill"></div>
                                    <span class="btn-text">
                                        <span class="btn-text-inner change">Design

                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="btn btn-normal development-btn">
                                <div class="btn-click magnetic" data-strength="25" data-strength-text="15">
                                    <div class="btn-fill"></div>
                                    <span class="btn-text">
                                        <span class="btn-text-inner change">Development


                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="grid-row">
                            <div class="btn btn-normal btn-icon rows-btn active">
                                <div class="btn-click magnetic" data-strength="25" data-strength-text="15">
                                    <div class="btn-fill"></div>
                                    <span class="btn-text">
                                        <span class="btn-text-inner change"><svg style="width: 20px;" width="20"
                                                height="19" viewBox="0 0 20 19">
                                                <g fill="currentColor" fill-rule="evenodd">
                                                    <path d="M0 6h20v1H0zM0 0h20v1H0zM0 12h20v1H0zM0 18h20v1H0z" />
                                                </g>
                                            </svg></span>
                                    </span>
                                </div>
                            </div>
                            <div class="btn btn-normal btn-icon columns-btn">
                                <div class="btn-click magnetic" data-strength="25" data-strength-text="15">
                                    <div class="btn-fill"></div>
                                    <span class="btn-text">
                                        <span class="btn-text-inner change"><svg style="width: 20px;" width="20"
                                                height="20" viewBox="0 0 20 20">
                                                <g fill="currentColor" fill-rule="nonzero">
                                                    <path
                                                        d="M8 0H0v8h8V0zM7 1v6H1V1h6zM8 12H0v8h8v-8zm-1 1v6H1v-6h6zM20 0h-8v8h8V0zm-1 1v6h-6V1h6zM20 12h-8v8h8v-8zm-1 1v6h-6v-6h6z" />
                                                </g>
                                            </svg></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section-wrap section-wrap-work once-in" data-scroll-section>
                <section class="section work-grid small-work-grid grid-fade grid-rows-part visible">
                    <div class="container">
                        <div class="grid-sub-title">
                            <div class="flex-col">
                                <h5>Client</h5>
                            </div>
                            <div class="flex-col">
                                <h5>Location</h5>
                            </div>
                            <div class="flex-col">
                                <h5>Services</h5>
                            </div>
                            <div class="flex-col">
                                <h5>Year</h5>
                            </div>
                        </div>
                        <ul class="work-items mouse-pos-list-image-wrap all-active">



                            <?php foreach ($cards as $card):
                                $id = (int) ($card['id'] ?? 0);
                                $title = htmlspecialchars($card['title'] ?? '');
                                $cover_image = htmlspecialchars($card['cover_image'] ?? '');
                                $location = htmlspecialchars($card['location'] ?? '');
                                $services = htmlspecialchars($card['services'] ?? '');
                                $link = htmlspecialchars($card['link'] ?? '');
                                $year = htmlspecialchars($card['year'] ?? '');
                                ?>

                                <li class="design development visible">
                                    <div class="stripe animate"></div>
                                    <a href="./details.php?id=<?= $id ?>" class="row">
                                        <div class="flex-col">
                                            <h4><span><?= $title ?></span></h4>
                                        </div>
                                        <div class="flex-col animate">
                                            <p> <?= $location ?></p>
                                        </div>
                                        <div class="flex-col animate">
                                            <p><?= $services ?></p>
                                        </div>
                                        <div class="flex-col animate">
                                            <p><?= $year ?></p>
                                        </div>
                                    </a>
                                </li>

                            <?php endforeach; ?>

                            <div class="stripe last animate"></div>
                        </ul>
                    </div>
                </section>
                <section class="section work-tiles grid-fade grid-columns-part">
                    <div class="container">
                        <ul>




                            <?php foreach ($cards as $card):
                                $id = (int) ($card['id'] ?? 0);
                                $title = htmlspecialchars($card['title'] ?? '');
                                $cover_image = htmlspecialchars($card['cover_image'] ?? '');
                                $description = nl2br(htmlspecialchars($card['services'] ?? ''));
                                $link = htmlspecialchars($card['link'] ?? '');
                                $year = htmlspecialchars($card['year'] ?? '');
                                ?>




                                <li class="development interaction visible">
                                    <div class="single-tile-wrap">
                                        <a href="./details.php?id=<?= $id ?>" class="row">
                                            <div class="flex-col">

                                                <div class="tile-image">
                                                    <div class="overlay overlay-color" style="background-color: #D8D3CD;">
                                                    </div>
                                                    <div class="overlay overlay-image lazy">
                                                        <img src="../dashboard/uploads/<?php echo htmlspecialchars($card['image1']); ?>"
                                                            alt="" style=" width: 210px;">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="flex-col">
                                                <h4><span><?= $title ?></span></h4>
                                                <div class="stripe"></div>
                                            </div>
                                            <div class="flex-col">
                                                <p><?= $services ?></p>
                                            </div>
                                            <div class="flex-col">
                                                <p><?= $year ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </li>

                            <?php endforeach; ?>






                        </ul>
                    </div>
                </section>
            </section>
            <!-- <section class="section center-grid-btn center-grid-btn-archive" data-scroll-section>
                <div class="container">
                    <div class="grid-after-btn">
                        <div class="btn btn-normal btn-dark">
                            <a href="https://dennissnellenberg.com/archive" class="btn-click magnetic"
                                data-strength="25" data-strength-text="15">
                                <div class="btn-fill"></div>
                                <span class="btn-text">
                                    <span class="btn-text-inner change">Archive</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
 -->

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