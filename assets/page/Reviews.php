<?php
$audioList = [
    [
        "title" => "Ehsan Ali",
        "country" => "Palestine",
        "sources" => [
            ["src" => "../audio/Ihsan.mp3", "type" => "audio/mpeg"],
            ["src" => "../audio/Ihsan.ogg", "type" => "audio/ogg"],
            ["src" => "../audio/Ihsan.m4a", "type" => "audio/mp4"]
        ]
    ],
    [
        "title" => "Noor Qnebi",
        "country" => "Palestine",
        "sources" => [
            ["src" => "../audio/Noor.mp3", "type" => "audio/mpeg"],
            ["src" => "../audio/Noor.ogg", "type" => "audio/ogg"],
            ["src" => "../audio/Noor.m4a", "type" => "audio/mp4"]
        ]
    ],
    [
        "title" => "Mira Abdallah",
        "country" => "Palestine",
        "sources" => [
            ["src" => "../audio/Mera.mp3", "type" => "audio/mpeg"],
            ["src" => "../audio/Mera.ogg", "type" => "audio/ogg"],
            ["src" => "../audio/Mera.m4a", "type" => "audio/mp4"]
        ]
    ],
    [
        "title" => "Muhammad Naser",
        "country" => "Palestine",
        "sources" => [
            ["src" => "../audio/Naser.mp3", "type" => "audio/mpeg"],
            ["src" => "../audio/Naser.ogg", "type" => "audio/ogg"],
            ["src" => "../audio/Naser.m4a", "type" => "audio/mp4"]
        ]
    ],
    [
        "title" => "Ahmed Othman",
        "country" => "Palestine",
        "sources" => [
            ["src" => "../audio/Othman.mp3", "type" => "audio/mpeg"],
            ["src" => "../audio/Othman.ogg", "type" => "audio/ogg"],
            ["src" => "../audio/Othman.m4a", "type" => "audio/mp4"]
        ]
    ],
    [
        "title" => "Saja Fawaz",
        "country" => "Palestine",
        "sources" => [
            ["src" => "../audio/Saja.mp3", "type" => "audio/mpeg"],
            ["src" => "../audio/Saja.ogg", "type" => "audio/ogg"],
            ["src" => "../audio/Saja.m4a", "type" => "audio/mp4"]
        ]
    ],
    [
        "title" => "Muhamed Samy",
        "country" => "Palestine",
        "sources" => [
            ["src" => "../audio/Sami.mp3", "type" => "audio/mpeg"],
            ["src" => "../audio/Sami.ogg", "type" => "audio/ogg"],
            ["src" => "../audio/Sami.m4a", "type" => "audio/mp4"]
        ]
    ],
    [
        "title" => "Ahmed Al-Hamaida",
        "country" => "Palestine",
        "sources" => [
            ["src" => "../audio/Hamaida.mp3", "type" => "audio/mpeg"],
            ["src" => "../audio/Hamaida.ogg", "type" => "audio/ogg"],
            ["src" => "../audio/Hamaida.m4a", "type" => "audio/mp4"]
        ]
    ],
    [
        "title" => "Ahmed Essam",
        "country" => "Palestine",
        "sources" => [
            ["src" => "../audio/Essam.mp3", "type" => "audio/mpeg"],
            ["src" => "../audio/Essam.ogg", "type" => "audio/ogg"],
            ["src" => "../audio/Essam.m4a", "type" => "audio/mp4"]
        ]
    ],
    [
        "title" => "Heba Gamal",
        "country" => "Palestine",
        "sources" => [
            ["src" => "../audio/Heba.mp3", "type" => "audio/mpeg"],
            ["src" => "../audio/Heba.ogg", "type" => "audio/ogg"],
            ["src" => "../audio/Heba.m4a", "type" => "audio/mp4"]
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<body data-barba="wrapper">
    <?php $current_page = 'Reviews'; ?>
    <?php include './loading.php'; ?>
    <main class="main" id="about" data-barba="container" data-barba-namespace="about">
        <div class="main-wrap" data-scroll-container>

            <?php include './header.php'; ?>



            <header class="section default-header about-header bg-with" data-scroll-section>
                <?php include './nav.php'; ?>
                <div class="container medium once-in">
                    <div class="row">
                        <div class="flex-col">


                            <h1><span> Customer </span><span> evaluation of the work</span></h1>
                        </div>
                    </div>
                </div>
            </header>

            <section class="section no-padding line-globe once-in" data-scroll-section>
                <div class="container medium">
                    <div class="row">
                        <div class="flex-col">
                            <div class="stripe"></div>
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
                </div>
            </section>


            <section class="section about-services bg-with" data-scroll-section>
                <div class="container flex">
                    <div class="sidebar">
                        <div class="sidebar-icon"><i class="fas fa-home"></i></div>
                        <div class="sidebar-icon"><i class="fas fa-heartbeat"></i></div>
                        <div class="sidebar-icon"><i class="fas fa-plus"></i></div>
                        <div class="sidebar-icon"><i class="fas fa-id-card"></i></div>
                        <div class="sidebar-icon"><i class="fas fa-user"></i></div>
                    </div>

                    <div class="cards">
                        <?php foreach ($audioList as $index => $track): ?>
                            <div class="card">
                                <button class="play-button"
                                    onclick='playAudio(<?php echo json_encode($track["sources"]); ?>, this)'>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </button>
                                <div>
                                    <div class="name"><?php echo htmlspecialchars($track['title']); ?></div>
                                    <div class="players"><?php echo ($index + 1) . " / " . count($audioList); ?> Players •
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <p>Copyright @ Ammar_Ahmed 2025 •</p>

                    </div>
                </div>

                <audio id="audio-player"></audio>

                <script>
                    function initializeAudioPlayer() {
                        const player = document.getElementById("audio-player");
                        let currentButton = null;

                        const icons = {
                            play: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>`,
                            pause: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>`
                        };

                        window.playAudio = function (sources, btn) {
                            if (btn === currentButton && !player.paused) {
                                player.pause();
                                btn.innerHTML = icons.play;
                                return;
                            }

                            if (btn !== currentButton) {
                                player.pause();
                                player.innerHTML = '';
                                sources.forEach(source => {
                                    const src = document.createElement('source');
                                    src.src = source.src;
                                    src.type = source.type;
                                    player.appendChild(src);
                                });
                                player.load();
                                if (currentButton) currentButton.innerHTML = icons.play;
                                currentButton = btn;
                            }

                            player.load();
                            player.play().catch(() => { });
                            btn.innerHTML = icons.pause;
                        };

                        ["pause", "ended"].forEach(e =>
                            player.addEventListener(e, () => {
                                if (currentButton) currentButton.innerHTML = icons.play;
                            })
                        );
                    }

                    document.addEventListener("DOMContentLoaded", () => {
                        initializeAudioPlayer();
                    });

                    if (window.barba) {
                        barba.hooks.after(() => {
                            initializeAudioPlayer();
                        });
                    }
                </script>




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
    <script src="https://dennissnellenberg.com/assets/js/locomotive-scroll.min.js"></script>
    <script defer src="https://dennissnellenberg.com/assets/js/index-new.js"></script>
</body>

</html>