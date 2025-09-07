<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
define('OTP_EXPIRY_TIME', 300);
define('RESEND_INTERVAL', 60);
define('ADMIN_EMAIL_ADDRESS', 'ammar132004@gmail.com');
define('ADMIN_EMAIL_PASSWORD', 'jwwichdusrcdjawg');
$error = '';
$success = '';
function send_otp_email($email, $otp)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = ADMIN_EMAIL_ADDRESS;
        $mail->Password = ADMIN_EMAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom(ADMIN_EMAIL_ADDRESS, 'Admin Login');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Admin Verification Code';
        $mail->Body = "<p>Your verification code is: <b>" . htmlspecialchars($otp) . "</b></p>";
        $mail->AltBody = "Your verification code is: " . htmlspecialchars($otp);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['otp'])) {
        $user_otp = trim($_POST['otp']);

        if (!ctype_digit($user_otp) || strlen($user_otp) != 6) {
            $error = "The verification code must be 6 digits.";
        } elseif (isset($_SESSION['otp_hash']) && password_verify($user_otp, $_SESSION['otp_hash']) && time() < $_SESSION['otp_expiry']) {
            $_SESSION['verified_email'] = ADMIN_EMAIL_ADDRESS;
            session_regenerate_id(true);

            unset($_SESSION['otp_hash'], $_SESSION['otp_expiry']);
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Invalid or expired verification code.";
        }
    } elseif (isset($_POST['resend_otp'])) {
        $time_since_last_otp = isset($_SESSION['otp_expiry']) ? time() - ($_SESSION['otp_expiry'] - OTP_EXPIRY_TIME) : RESEND_INTERVAL + 1;
        if ($time_since_last_otp >= RESEND_INTERVAL) {
            $otp = rand(100000, 999999);

            $_SESSION['otp_hash'] = password_hash($otp, PASSWORD_DEFAULT);
            $_SESSION['otp_expiry'] = time() + OTP_EXPIRY_TIME;

            if (send_otp_email(ADMIN_EMAIL_ADDRESS, $otp)) {
                $success = "Verification code has been resent.";
            } else {
                $error = "Failed to resend verification code.";
            }
        } else {
            $error = "Please wait before resending the code.";
        }
    }
}
$time_left = isset($_SESSION['otp_expiry']) ? $_SESSION['otp_expiry'] - time() : 0;
if ($time_left < 0) {
    $time_left = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="../assets/css/main.css">

</head>

<body>

    <form class="otp-Form" method="post" id="otpForm">
        <span class="mainHeading">Enter OTP</span>
        <p class="otpSubheading">We have sent a verification code to your email.</p>
        <div class="inputContainer">
            <input name="digit1" required="required" maxlength="1" type="text" class="otp-input" inputmode="numeric">
            <input name="digit2" required="required" maxlength="1" type="text" class="otp-input" inputmode="numeric">
            <input name="digit3" required="required" maxlength="1" type="text" class="otp-input" inputmode="numeric">
            <input name="digit4" required="required" maxlength="1" type="text" class="otp-input" inputmode="numeric">
            <input name="digit5" required="required" maxlength="1" type="text" class="otp-input" inputmode="numeric">
            <input name="digit6" required="required" maxlength="1" type="text" class="otp-input" inputmode="numeric">
        </div>
        <input type="hidden" name="otp" id="hiddenOtp">
        <?php if ($error): ?>
            <p class="message error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="message success-message"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <button class="verifyButton" type="submit">Verify</button>
        <p class="resendNote">
            <span>Didn't receive the code? </span>
            <button type="button" id="resend-btn" class="resendBtn" <?= $time_left > 0 ? 'disabled' : '' ?>>
                Resend Code
            </button>
            <span id="countdown" class="countdown"><?= $time_left > 0 ? 'Resend in ' . $time_left . 's' : '' ?></span>
        </p>
    </form>

    <form id="resend-form" method="post" style="display:none;">
        <input type="hidden" name="resend_otp" value="1">
    </form>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const hiddenOtp = document.getElementById('hiddenOtp');
        const resendBtn = document.getElementById('resend-btn');
        const resendForm = document.getElementById('resend-form');
        const countdownEl = document.getElementById('countdown');
        let timeLeft = <?= $time_left ?>;

        function collectOTP() {
            let otp = '';
            inputs.forEach(input => {
                otp += input.value;
            });
            hiddenOtp.value = otp;
            return true;
        }

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                collectOTP();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        resendBtn.addEventListener('click', () => {
            resendForm.submit();
        });

        if (timeLeft > 0) {
            let timer = setInterval(() => {
                if (timeLeft > 0) {
                    timeLeft--;
                    countdownEl.textContent = `Resend in ${timeLeft}s`;
                } else {
                    countdownEl.textContent = "";
                    resendBtn.disabled = false;
                    clearInterval(timer);
                }
            }, 1000);
        }
    </script>
</body>
</html>