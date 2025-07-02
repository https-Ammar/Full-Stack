<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST["tel"] ?? '';
    $name = $_POST["name"] ?? '';
    $email = $_POST["email"] ?? '';
    $service = $_POST["service"] ?? '';
    $message = $_POST["message"] ?? '';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ammar132004@gmail.com';
        $mail->Password = 'absbxvzfkklexzha';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($email, $name);
        $mail->addAddress('ammar132004@gmail.com', 'Ammar');

        $mail->isHTML(false);
        $mail->Subject = "New Project Request from $name";
        $mail->Body =
            " New Contact Form Submission\n\n" .
            " Name: $name\n" .
            " Email: $email\n" .
            " Phone: $phone\n" .
            " Service Requested: $service\n" .
            " Message:\n$message\n\n" .
            "This message was sent from your website contact form.";

        $mail->send();
        echo "<script>alert('✅ Message sent successfully!');</script>";
    } catch (Exception $e) {
        echo "<script>alert('❌ Message failed to send. Please try again later.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="../css/main.css">
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
                                    <div class="profile-picture"></div>Let's start a
                                </span>
                                <span>project together</span>
                            </h1>
                        </div>
                        <div class="flex-col">
                            <div class="profile-picture"></div>
                            <div class="arrow">
                                <svg width="14px" height="14px" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1019, -279)" stroke="#FFFFFF" stroke-width="1.5">
                                            <g
                                                transform="translate(1026, 286) rotate(90) translate(-1026, -286) translate(1020, 280)">
                                                <polyline points="2.769 0 12 0 12 9.231"></polyline>
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
                            <form class="form" method="post" action="contact.php" enctype="multipart/form-data"
                                novalidate>
                                <div class="website-field">
                                    <label class="label" for="tel">What's your phone number?</label>
                                    <input class="field" type="text" id="form-tel" name="tel" tabindex="-1">
                                </div>

                                <div class="form-col">
                                    <h5>01</h5>
                                    <label class="label" for="name">What's your name?</label>
                                    <input class="field" type="text" id="form-name" name="name" required
                                        placeholder="Eng - Ammar *">
                                </div>

                                <div class="form-col">
                                    <h5>02</h5>
                                    <label class="label" for="email">What's your email?</label>
                                    <input class="field" type="email" id="form-email" name="email" required
                                        placeholder="Ammar@gmail.com *">
                                </div>

                                <div class="form-col">
                                    <h5>03</h5>
                                    <label class="label" for="tel">What's your phone number?</label>
                                    <input class="field" type="text" id="form-company" name="company" required
                                        placeholder="+201070479599">
                                </div>

                                <div class="form-col">
                                    <h5>04</h5>
                                    <label class="label" for="email">What services are you looking for?</label>
                                    <input class="field" type="text" id="form-service" name="service" required
                                        placeholder="Web Design, Web Development ...">
                                </div>

                                <div class="form-col">
                                    <h5>05</h5>
                                    <label class="label" for="message">Your message</label>
                                    <textarea class="field" id="form-message" name="message" rows="8" required
                                        placeholder="Hello Dennis, can you help me with ... *"></textarea>
                                </div>

                                <div class="btn-contact-send">
                                    <div class="btn btn-round" data-scroll data-scroll-speed="2"
                                        data-scroll-offset="-50%, 0%">
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
                                    <a href="mailto:ammar132004@gmail.com" class="btn-click magnetic" data-strength="20"
                                        data-strength-text="10">
                                        <span class="btn-text"><span
                                                class="btn-text-inner">ammar132004@gmail.com</span></span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="tel:+201065424756" class="btn-click magnetic" data-strength="20"
                                        data-strength-text="10">
                                        <span class="btn-text"><span class="btn-text-inner">+201065424756</span></span>
                                    </a>
                                </li>

                                <li class="btn btn-link btn-link-external">
                                    <a href="tel:+201070479599" class="btn-click magnetic" data-strength="20"
                                        data-strength-text="10">
                                        <span class="btn-text"><span class="btn-text-inner">+201070479599</span></span>
                                    </a>
                                </li>
                            </ul>

                            <h5>Business Details</h5>
                            <ul class="links-wrap">
                                <li>
                                    <p>Ammar Ahmed</p>
                                </li>

                                <li>
                                    <p>Location : Egypt</p>
                                </li>
                            </ul>

                            <h5>Socials</h5>

                            <ul class="links-wrap">
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://www.facebook.com/eng.amaar.ah.med/" target="_blank"
                                        class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text"><span class="btn-text-inner">Facebook</span></span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://www.instagram.com/3mmarx3/" target="_blank"
                                        class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text"><span class="btn-text-inner">Instagram</span></span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://wa.me/+201065424756" target="_blank" class="btn-click magnetic"
                                        data-strength="20" data-strength-text="10">
                                        <span class="btn-text"><span class="btn-text-inner">Whatsapp</span></span>
                                    </a>
                                </li>
                                <li class="btn btn-link btn-link-external">
                                    <a href="https://www.linkedin.com/in/ammar-ahmed-543a58253/" target="_blank"
                                        class="btn-click magnetic" data-strength="20" data-strength-text="10">
                                        <span class="btn-text"><span class="btn-text-inner">LinkedIn</span></span>
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