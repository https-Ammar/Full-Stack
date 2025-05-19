<!DOCTYPE html>
<!--  This site was created by Dennis Snellenberg (Code by Dennis)  -->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Ammar_Ahmed</title>
    <?php include './head_links.php'; ?>
</head>
<body>
    <aside id="head"></aside>

    <?php
    $contactDetails = [
        'Contact Details' => [
            ['text' => '+201070479599', 'href' => 'tel:+201070479599']
        ],
        'Location' => [
            ['text' => 'Location : Egypt', 'href' => null]
        ],
        'Social Media' => [
            ['text' => 'Facebook',  'href' => 'https://www.facebook.com/profile.php?id=100024713541158'],
            ['text' => 'Instagram', 'href' => 'https://www.instagram.com/3mmarx3/'],
            ['text' => 'Twitter',   'href' => 'https://twitter.com/Ammar132004'],
            ['text' => 'LinkedIn',  'href' => 'https://www.linkedin.com/in/ammar-ahmed-543a58253/'],
        ]
    ];
    ?>
    <main>
        <article>
            <section class="section hero" id="home" aria-label="hero">
                <div class="container" style="align-items: self-start;">
                    <div class="hero-content">
                        <p class="section-subtitle">Bernard 3mmar</p>
                        <h1 class="h1 hero-title">Get In Touch</h1>

                        <div class="flex-col">
                            <?php foreach ($contactDetails as $sectionTitle => $links): ?>
                                <div class="block_contact">
                                    <h5><?= $sectionTitle ?></h5>
                                    <ul class="links-wrap">
                                        <?php foreach ($links as $link): ?>
                                            <li class="btn btn-link btn-link-external">
                                                <?php if ($link['href']): ?>
                                                    <a href="<?= $link['href'] ?>" class="btn-text-inner link" target="_blank"><?= $link['text'] ?></a>
                                                <?php else: ?>
                                                    <span class="btn-text-inner link"><?= $link['text'] ?></span>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- نموذج التواصل -->
                    <header class="section default-header contact-header theme-dark" data-scroll-section>
                        <div class="container medium d-block">
                            <div class="row once-in">
                                <div class="flex-col">
                                    <form class="form" method="post" action="../pages/Contact.html" enctype="multipart/form-data" novalidate>

                                        <div class="form-col">
                                            <h5>01</h5>
                                            <label class="label" for="name">What's your name?</label>
                                            <input class="field" type="text" id="form-name" name="name" required placeholder="Ammar Ahmed *" />
                                        </div>

                                        <div class="form-col">
                                            <h5>02</h5>
                                            <label class="label" for="email">What's your email?</label>
                                            <input class="field" type="email" id="form-email" name="email" required placeholder="ammar132004@gmail.com *" />
                                        </div>

                                        <div class="form-col">
                                            <h5>03</h5>
                                            <label class="label" for="service">Phone Number</label>
                                            <input class="field" type="tel" id="form-service" name="service" required placeholder="+201070479599" />
                                        </div>

                                        <div class="form-col">
                                            <h5>04</h5>
                                            <label class="label" for="message">Your message</label>
                                            <textarea class="field" id="form-message" name="message" rows="8" required placeholder="Hello Ammar, can you help me with ... *"></textarea>
                                        </div>

                                        <div class="btn-contact-send">
                                            <div class="btn btn-round" data-scroll data-scroll-speed="2" data-scroll-offset="-50%, 0%">
                                                <div class="btn-click magnetic" data-strength="100" data-strength-text="50">
                                                    <div class="btn-fill"></div>
                                                    <span class="btn-text">
                                                        <input type="submit" name="submit" value="Send it!" class="form-btn" />
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </header>
                </div>
            </section>
        </article>
    </main>
    <?php include 'footer.php'; ?>
    <script src="../js/script.js"></script>
</body>
</html>