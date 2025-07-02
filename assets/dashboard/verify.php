<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

define('OTP_EXPIRY_TIME', 300);
define('RESEND_INTERVAL', 60);
define('ADMIN_EMAIL', 'ammar132004@gmail.com');

$error = '';
$success = '';
$time_left = 0;

function send_otp_email($email, $otp)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ammar132004@gmail.com';
        $mail->Password = 'jwwichdusrcdjawg';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('ammar132004@gmail.com', 'Admin Login');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Admin Verification Code';
        $mail->Body = "<p>Your verification code is: <b>$otp</b></p>";
        $mail->AltBody = "Your verification code is: $otp";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

if (isset($_POST['visitor_login'])) {
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + OTP_EXPIRY_TIME;
    if (send_otp_email(ADMIN_EMAIL, $otp)) {
        $success = "";
    } else {
        $error = "Failed to send verification code.";
    }
}

$time_left = isset($_SESSION['otp_expiry']) ? $_SESSION['otp_expiry'] - time() : 0;
if ($time_left < 0)
    $time_left = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['otp'])) {
        $user_otp = trim($_POST['otp']);
        if (isset($_SESSION['otp']) && $_SESSION['otp'] == $user_otp && time() < $_SESSION['otp_expiry']) {
            $_SESSION['verified_email'] = ADMIN_EMAIL;
            unset($_SESSION['otp'], $_SESSION['otp_expiry']);
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid or expired verification code.";
        }
    } elseif (isset($_POST['resend_otp'])) {
        $time_since_last_otp = time() - ($_SESSION['otp_expiry'] - OTP_EXPIRY_TIME);
        if ($time_since_last_otp >= RESEND_INTERVAL) {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_expiry'] = time() + OTP_EXPIRY_TIME;
            if (send_otp_email(ADMIN_EMAIL, $otp)) {
                $success = "Verification code has been resent.";
                $time_left = OTP_EXPIRY_TIME;
            } else {
                $error = "Failed to resend verification code.";
            }
        } else {
            $error = "Please wait before resending the code.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>
    <section class='signup-container'>
        <div class='wrapper'>
            <div class='signup-title'>OTP Verification</div>
            <div class='login-page'>Enter the OTP sent to your email <span id="email"></span>


                <form method="post">
                    <button type="submit" name="visitor_login" class="submit-button none"> <a href="#">Get
                            started</a></button>
                </form>

            </div>
            <form method="post" onsubmit="return collectOTP()">
                <div class="otp-input" style="display: flex; gap: 8px;">
                    <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required
                        oninput="moveNext(this)" />
                    <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required
                        oninput="moveNext(this)" />
                    <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required
                        oninput="moveNext(this)" />
                    <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required
                        oninput="moveNext(this)" />
                    <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required
                        oninput="moveNext(this)" />
                    <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required
                        oninput="moveNext(this)" />
                </div>
                <input type="hidden" name="otp" id="otp" />
                <?php if ($error): ?>
                    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                <?php if ($success): ?>
                    <p style="color:green;"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>
                <button class='submit-button' id='user-login-submit' type="submit">Verify</button>
                <div class='alternative'><span>OR</span></div>
                <div class='seller-signup'>Didn't receive the code ? <a href="#">Get started</a></div>

            </form>

        </div>
    </section>

    <script>
        function moveNext(el) {
            if (el.value.length === 1) {
                const next = el.nextElementSibling;
                if (next && next.tagName === "INPUT") {
                    next.focus();
                }
            }
        }

        function movePrev(el) {
            const prev = el.previousElementSibling;
            if (prev && prev.tagName === "INPUT") {
                prev.focus();
            }
        }

        function collectOTP() {
            const inputs = document.querySelectorAll('.otp-input input');
            let otp = '';
            for (const input of inputs) {
                if (input.value === '') {
                    alert('Please enter all digits');
                    return false;
                }
                otp += input.value;
            }
            document.getElementById('otp').value = otp;
            return true;
        }

        document.querySelectorAll('.otp-input input').forEach(input => {
            input.addEventListener('input', () => {
                if (input.value.length > 1) {
                    input.value = input.value.charAt(0);
                }
                if (input.value.length === 1) {
                    moveNext(input);
                }
                const inputs = document.querySelectorAll('.otp-input input');
                const otp = Array.from(inputs).map(i => i.value).join('');
                if (otp.length === inputs.length && !otp.includes('')) {
                    collectOTP();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    if (input.value === '') {
                        movePrev(input);
                    } else {
                        input.value = '';
                    }
                    e.preventDefault();
                }
            });
        });

        let timeLeft = <?= $time_left ?>;
        const countdownEl = document.getElementById('countdown');
        const resendBtn = document.getElementById('resend-btn');
        const RESEND_INTERVAL = <?= RESEND_INTERVAL ?>;

        let timer = setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                countdownEl.textContent = timeLeft;
            } else {
                countdownEl.textContent = "Time expired, you can resend the code now.";
                resendBtn.disabled = false;
                clearInterval(timer);
            }
        }, 1000);
    </script>

    <style>
        body {
            background: #111827;
        }

        .wrapper {
            background: #1f2937;
            color: white !important;
        }

        .signup-title {
            color: white;
        }

        input[type="text"] {
            color: white;
            border-color: #101827;
        }

        span {
            background: #101827 !important;
        }

        ::before {
            background: #101827 !important;
        }

        button.submit-button.none {
            background: none;
            width: auto;
            margin: 0;
        }

        .login-page {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</body>

</html>