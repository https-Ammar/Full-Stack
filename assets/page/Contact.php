<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<body data-barba="wrapper">
   <?php $current_page = 'Contact'; ?>
    <?php include './loading.php'; ?>

    <main class="main" id="contact" data-barba="container" data-barba-namespace="contact">
        <div class="main-wrap" data-scroll-container>


                 <?php include './header.php'; ?>

            <header class="section default-header contact-header theme-dark" data-scroll-section>
            <?php include './nav.php'; ?>

                <div class="container medium">
                    <div class="row once-in">
                        <div class="flex-col">
                            <h1>
                                <span>
                                    <div class="profile-picture"></div>
                                    Let's start a
                                </span>
                                <span>project together</span>
                            </h1>
                        </div>
                        <div class="flex-col">
                            <div class="profile-picture"></div>
                            <div class="arrow">
                                <?xml version="1.0" encoding="UTF-8"?>
                                <svg width="14px" height="14px" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>arrow-up-right</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1019.000000, -279.000000)" stroke="#FFFFFF" stroke-width="1.5">
                                            <g transform="translate(1026.000000, 286.000000) rotate(90.000000) translate(-1026.000000, -286.000000) translate(1020.000000, 280.000000)">
                                                <polyline points="2.76923077 0 12 0 12 9.23076923"></polyline>
                                                <line x1="12" y1="0" x2="0" y2="12"></line>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="row once-in">
                        <div class="flex-col">
                            <form class="form" method="post" action="https://dennissnellenberg.com/contact" enctype="multipart/form-data" novalidate>
                                <div class="website-field">
                                    <label class="label" for="tel">Phone Number</label>
                                    <input class="field" type="text" id="form-tel" name="tel" tabindex="-1">
                                </div>

                                <div class="form-col">
                                    <h5>01</h5>
                                    <label class="label" for="name">What's your name?</label>
                                    <input class="field" type="text" id="form-name" name="name" required placeholder="Eng - Ammar *">
                                </div>

                                <div class="form-col">
                                    <h5>02</h5>
                                    <label class="label" for="email">What's your email?</label>
                                    <input class="field" type="email" id="form-email" name="email" required placeholder="Ammar@gmail.com *">
                                </div>

                                <div class="form-col">
                                    <h5>03</h5>
                                    <label class="label" for="email">What's the name of your organization?</label>
                                    <input class="field" type="text" id="form-company" name="company" required placeholder="Ammar & Ahmed ®">
                                </div>

                                <div class="form-col">
                                    <h5>04</h5>
                                    <label class="label" for="email">What services are you looking for?</label>
                                    <input class="field" type="text" id="form-service" name="service" required placeholder="Web Design, Web Development ...">
                                </div>

                                <div class="form-col">
                                    <h5>05</h5>
                                    <label class="label" for="message">Your message</label>
                                    <textarea class="field" id="form-message" name="message" rows="8" required placeholder="Hello Dennis, can you help me with ... *"></textarea>
                                </div>

                                <div class="btn-contact-send">
                                    <div class="btn btn-round" data-scroll data-scroll-speed="2" data-scroll-offset="-50%, 0%">
                                        <div class="btn-click magnetic" data-strength="100" data-strength-text="50">
                                            <div class="btn-fill"></div>
                                            <span class="btn-text">
                                                <input type="submit" name="submit" value="Send it!" class="form-btn">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="flex-col">
                            <h5>Contact Details</h5>
                            <ul class="links-wrap">
                                <li class="btn btn-link btn-link-external">
                                    <a href="mailto:info@dennissnellenberg.com" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text">
                                            <span class="btn-text-inner">info@dennissnellenberg.com</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="tel:+31627847430" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text">
                                            <span class="btn-text-inner">+31 6 27 84 74 30</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>

                            <h5>Business Details</h5>
                            <ul class="links-wrap">
                                <li><p>Dennis Snellenberg B.V.</p></li>
                                <li><p>CoC: 92411711</p></li>
                                <li><p>VAT: NL866034080B01</p></li>
                                <li><p>Location: The Netherlands</p></li>
                            </ul>

                            <h5>Socials</h5>
                            <ul class="links-wrap">
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://www.awwwards.com/dennissnellenberg/" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text">
                                            <span class="btn-text-inner">Awwwards</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://www.instagram.com/codebydennis/" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text">
                                            <span class="btn-text-inner">Instagram</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://twitter.com/codebydennis" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text">
                                            <span class="btn-text-inner">Twitter</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://www.linkedin.com/in/dennissnellenberg/" target="_blank" class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text">
                                            <span class="btn-text-inner">LinkedIn</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

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
