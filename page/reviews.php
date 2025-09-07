<?php
$audioList = [
  ["title" => "Ehsan Ali", "country" => "Jordan", "src" => "../audio/Ihsan.mp3"],
  ["title" => "Noor Qnebi", "country" => "Palestine", "src" => "../audio/Noor.mp3"],
  ["title" => "Mira Abdallah", "country" => "Lebanon", "src" => "../audio/Mera.mp3"],
  ["title" => "Muhammad Naser", "country" => "Egypt", "src" => "../audio/Naser.mp3"],
  ["title" => "Ahmed Othman", "country" => "Egypt", "src" => "../audio/Othman.mp3"],
  ["title" => "Saja Fawaz", "country" => "Oman", "src" => "../audio/Saja.mp3"],
  ["title" => "Muhamed Samy", "country" => "Egypt", "src" => "../audio/Sami.mp3"],
  ["title" => "Ahmed Al-Hamaida", "country" => "Jordan", "src" => "../audio/Hamaida.mp3"],
  ["title" => "Ahmed Essam", "country" => "Egypt", "src" => "../audio/Essam.mp3"],
  ["title" => "Heba Gamal", "country" => "Egypt", "src" => "../audio/Heba.mp3"],
  ["title" => "Muhammad Gamal", "country" => "Egypt", "src" => "../audio/gamal.mp3"]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reviews - Customer Feedback | Eng Ammar</title>
  <meta name="description"
    content="Listen to voice reviews and testimonials from our clients from Palestine. Hear their feedback on the quality of our web development and design services.">
  <link rel="canonical" href="http://localhost:8888/ammar/assets/page/reviews.php">
  <meta property="og:title" content="Customer Reviews and Testimonials - Eng Ammar">
  <meta property="og:description"
    content="Real voice reviews from our satisfied clients about our web development and design projects.">
  <meta property="og:url" content="http://localhost:8888/ammar/assets/page/reviews.php">
  <meta property="og:type" content="website">
  <meta property="og:image" content="http://localhost:8888/ammar/assets/img/og-image.jpg">
  <link rel="stylesheet" href="../assets/css/main.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<?php $current_page = 'Reviews'; ?>
<?php include '../includes/loading.php'; ?>

<body data-barba="wrapper">
  <main class="main" id="reviews" data-barba="container" data-barba-namespace="reviews">
    <div class="main-wrap" data-scroll-container>
      <?php include '../includes/header.php'; ?>
      <header class="section default-header about-header bg-with" data-scroll-section>
        <?php include '../includes/nav.php'; ?>
        <div class="container medium once-in">
          <div class="row">
            <div class="flex-col">
              <h1><span>Customer</span> <span>evaluation of the work</span></h1>
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
            <?php
            $icons = ['home', 'heartbeat', 'plus', 'id-card', 'user'];
            foreach ($icons as $icon):
              ?>
              <div class="sidebar-icon">
                <i class="fas fa-<?= $icon ?>" aria-hidden="true"></i>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="cards">
            <?php foreach ($audioList as $index => $track): ?>
              <div class="card" style="min-height: 100px;">
                <button class="play-button" data-audio-id="audio<?= $index ?>"
                  aria-label="Play audio for <?= htmlspecialchars($track['title']) ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z" />
                  </svg>
                </button>
                <audio id="audio<?= $index ?>" preload="auto">
                  <source src="<?= htmlspecialchars($track['src']) ?>" type="audio/mpeg">
                </audio>
                <div>
                  <div class="name"><?= htmlspecialchars($track['title']) ?></div>
                  <div class="players"><?= ($index + 1) ?> / <?= count($audioList) ?> Players •</div>
                </div>
              </div>
            <?php endforeach; ?>
            <p>&copy; Ammar_Ahmed 2025 •</p>
          </div>
        </div>
      </section>
      <?php include '../includes/footer.php'; ?>
    </div>
  </main>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      let lastAudio = null;
      let lastButton = null;
      const playIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>';
      const pauseIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>';

      const playButtons = document.querySelectorAll(".play-button");
      playButtons.forEach(btn => {
        const audioId = btn.getAttribute("data-audio-id");
        const audio = document.getElementById(audioId);

        audio.onended = () => {
          btn.innerHTML = playIcon;
        };

        btn.addEventListener("click", () => {
          if (audio.paused) {
            if (lastAudio && lastAudio !== audio) {
              lastAudio.pause();
              if (lastButton) {
                lastButton.innerHTML = playIcon;
              }
            }
            audio.play().then(() => {
              btn.innerHTML = pauseIcon;
              lastAudio = audio;
              lastButton = btn;
            }).catch(err => {
              console.error("Playback error:", err);
            });
          } else {
            audio.pause();
            btn.innerHTML = playIcon;
          }
        });
      });
    });
  </script>
  <script defer src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>
  <script defer src="https://dennissnellenberg.com/assets/js/locomotive-scroll.min.js"></script>
  <script defer src="https://dennissnellenberg.com/assets/js/index-new.js"></script>
</body>

</html>