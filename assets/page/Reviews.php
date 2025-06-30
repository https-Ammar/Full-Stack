<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Отзывы</title>
    <link rel="stylesheet" href="../css/audio.css">
    <style>
        .reviews {
            display: flex;
            justify-content: space-between;
            padding: 2rem;
        }

        .block-tour {
            margin: 0.5rem 0;
        }

        .stars {
            color: gold;
        }

        .pagination {
            margin-top: 1rem;
        }

        .bullet {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #ccc;
            margin: 0 5px;
        }

        .bullet.active {
            background-color: #000;
        }

        .reviews-right__nav button {
            margin: 10px;
            padding: 5px 15px;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    $reviews = [
        [
            'title' => 'Ehsan Ali',
            'country' => 'Palestine',
            'audio' => '../audio/Ihsan.mp3',
            'review' => 'مراجعة رائعة من إحسان عن الخدمة والتجربة.',
            'image' => '../images/ihsan.jpg'
        ],
        [
            'title' => 'Noor Qnebi',
            'country' => 'Palestine',
            'audio' => '../audio/Noor.mp3',
            'review' => 'نور تشكر الفريق وتوصي بالتجربة.',
            'image' => '../images/noor.jpg'
        ],
        [
            'title' => 'Mira Abdallah',
            'country' => 'Palestine',
            'audio' => '../audio/Mera.mp3',
            'review' => 'تجربة ميرا كانت مليئة بالحماس والسعادة.',
            'image' => '../images/mira.jpg'
        ],
        [
            'title' => 'Muhammad Naser',
            'country' => 'Palestine',
            'audio' => '../audio/Naser.mp3',
            'review' => 'محمد ناصر تحدث عن تفاصيل رائعة للرحلة.',
            'image' => '../images/naser.jpg'
        ]
    ];

    $current = isset($_GET['review']) ? intval($_GET['review']) : 0;
    if ($current < 0 || $current >= count($reviews)) {
        $current = 0;
    }
    $review = $reviews[$current];
    ?>

    <div class="reviews">
        <div class="reviews-left">
            <h2>Отзывы</h2>
            <p>
                Мы всегда стараемся предоставлять лучший сервис для наших клиентов.
                Мы были бы очень признательны, если вы оставите отзыв на нашей странице,
                чтобы другие клиенты могли узнать о нашей работе.
            </p>
            <button class="add-reviews" onclick="toggleAudio()">تشغيل / إيقاف الصوت</button>
            <audio id="reviewAudio">
                <source src="<?= htmlspecialchars($review['audio']) ?>" type="audio/mpeg">
            </audio>
        </div>

        <div class="reviews-right">
            <div class="reviews-right__avatar">
                <div class="img" style="background-image: url('<?= htmlspecialchars($review['image']) ?>');"></div>
            </div>

            <div class="reviews-right__item">
                <h3><?= htmlspecialchars($review['title']) ?></h3>
                <div class="block-tour">
                    <span>Тур: <a href="#">Калининград</a></span>
                    <span class="stars">Оценка ★★★★★</span>
                </div>
                <p><?= htmlspecialchars($review['review']) ?></p>

                <div class="reviews-right__nav">
                    <div class="pagination">
                        <?php foreach ($reviews as $index => $r): ?>
                            <a href="?review=<?= $index ?>">
                                <span class="bullet <?= $index === $current ? 'active' : '' ?>"></span>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($current > 0): ?>
                        <a href="?review=<?= $current - 1 ?>"><button>⟨</button></a>
                    <?php endif; ?>
                    <?php if ($current < count($reviews) - 1): ?>
                        <a href="?review=<?= $current + 1 ?>"><button>⟩</button></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAudio() {
            const audio = document.getElementById('reviewAudio');
            if (audio.paused) {
                audio.play();
            } else {
                audio.pause();
            }
        }
    </script>
</body>

</html>