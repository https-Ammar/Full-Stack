<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

define('OTP_EXPIRY_TIME', 100);
define('RESEND_INTERVAL', 60);

$error = '';
$success = '';
$time_left = 0;

function send_otp_email($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ammar132004@gmail.com';
        $mail->Password   = 'jwwichdusrcdjawg';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('ammar132004@gmail.com', 'Your Site Name');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Login Verification Code';
        $mail->Body    = "<p>Your verification code is: <b>$otp</b></p>";
        $mail->AltBody = "Your verification code is: $otp";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

if (!isset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['temp_user_id'], $_SESSION['temp_username'], $_SESSION['temp_email'])) {
    header("Location: login.php");
    exit();
}

$time_left = $_SESSION['otp_expiry'] - time();
if ($time_left < 0) {
    $time_left = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['otp'])) {
        $user_otp = $_POST['otp'];

        if ($_SESSION['otp'] == $user_otp && time() < $_SESSION['otp_expiry']) {
            $_SESSION['user_id'] = $_SESSION['temp_user_id'];
            $_SESSION['username'] = $_SESSION['temp_username'];

            unset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['temp_user_id'], $_SESSION['temp_username'], $_SESSION['temp_email']);

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid or expired verification code.";
        }
    } elseif (isset($_POST['resend_otp'])) {
        $time_since_last_otp = time() - ($_SESSION['otp_expiry'] - OTP_EXPIRY_TIME);

        if ($time_since_last_otp >= RESEND_INTERVAL) {
            $otp_code = rand(100000, 999999);
            $_SESSION['otp'] = $otp_code;
            $_SESSION['otp_expiry'] = time() + OTP_EXPIRY_TIME;

            if (send_otp_email($_SESSION['temp_email'], $otp_code)) {
                $success = "Verification code has been resent to your email.";
                $time_left = OTP_EXPIRY_TIME;
            } else {
                $error = "Failed to resend verification code. Please try again.";
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
            <div class='login-page'>Enter the OTP sent to your email  <span id="email"></span> <a href="login.php">Get started</a></div>



   <form method="post" onsubmit="return collectOTP()">

         
            <div class="otp-input" style="display: flex; gap: 8px;">
                <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required oninput="moveNext(this)" />
                <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required oninput="moveNext(this)" />
                <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required oninput="moveNext(this)" />
                <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required oninput="moveNext(this)" />
                <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required oninput="moveNext(this)" />
                <input type="text" inputmode="numeric" maxlength="1" pattern="\d" required oninput="moveNext(this)" />
            </div>
            <input type="hidden" name="otp" id="otp" />

   

     

  
     
                    <?php if ($error): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p style="color:green;"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

            <button class='submit-button' id='user-login-submit' type="submit">Verify</button>
            <div class='seller-signup'>Didn't receive the code ? <a href="seller-login">Get started</a></div>
            <div class='alternative'><span>OR</span></div>

                </form>

            <div class='social-signup'>
                <div class="social-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="#FFC107"
                            d="M21.8055 10.0415H21V10H12V14H17.6515C16.827 16.3285 14.6115 18 12 18C8.6865 18 6 15.3135 6 12C6 8.6865 8.6865 6 12 6C13.5295 6 14.921 6.577 15.9805 7.5195L18.809 4.691C17.023 3.0265 14.634 2 12 2C6.4775 2 2 6.4775 2 12C2 17.5225 6.4775 22 12 22C17.5225 22 22 17.5225 22 12C22 11.3295 21.931 10.675 21.8055 10.0415Z">
                        </path>
                        <path fill="#FF3D00"
                            d="M3.15332 7.3455L6.43882 9.755C7.32782 7.554 9.48082 6 12.0003 6C13.5298 6 14.9213 6.577 15.9808 7.5195L18.8093 4.691C17.0233 3.0265 14.6343 2 12.0003 2C8.15932 2 4.82832 4.1685 3.15332 7.3455Z">
                        </path>
                        <path fill="#4CAF50"
                            d="M12.0002 22C14.5832 22 16.9302 21.0115 18.7047 19.404L15.6097 16.785C14.5719 17.5742 13.3039 18.0011 12.0002 18C9.39916 18 7.19066 16.3415 6.35866 14.027L3.09766 16.5395C4.75266 19.778 8.11366 22 12.0002 22Z">
                        </path>
                        <path fill="#1976D2"
                            d="M21.8055 10.0415H21V10H12V14H17.6515C17.2571 15.1082 16.5467 16.0766 15.608 16.7855L15.6095 16.7845L18.7045 19.4035C18.4855 19.6025 22 17 22 12C22 11.3295 21.931 10.675 21.8055 10.0415Z">
                        </path>
                    </svg>
                </div>
                <div class="social-svg">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none">
                        <path fill="#1877F2"
                            d="M15 8a7 7 0 00-7-7 7 7 0 00-1.094 13.915v-4.892H5.13V8h1.777V6.458c0-1.754 1.045-2.724 2.644-2.724.766 0 1.567.137 1.567.137v1.723h-.883c-.87 0-1.14.54-1.14 1.093V8h1.941l-.31 2.023H9.094v4.892A7.001 7.001 0 0015 8z">
                        </path>
                        <path fill="#ffffff"
                            d="M10.725 10.023L11.035 8H9.094V6.687c0-.553.27-1.093 1.14-1.093h.883V3.87s-.801-.137-1.567-.137c-1.6 0-2.644.97-2.644 2.724V8H5.13v2.023h1.777v4.892a7.037 7.037 0 002.188 0v-4.892h1.63z">
                        </path>
                    </svg>
                </div>
                <div class="social-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M17.7242 3H20.779L14.1069 10.624L21.956 21H15.8117L10.9959 14.7087L5.49201 21H2.43288L9.56798 12.8438L2.04346 3H8.34346L12.692 8.75048L17.7242 3ZM16.6511 19.174H18.343L7.42182 4.73077H5.60451L16.6511 19.174Z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>


    </section>

           <div class="resend-text">
        
            <form method="post">
                <button type="submit" name="resend_otp" id="resend-btn" disabled class="resend-link">Resend Code</button>
            </form>
            <span id="countdown">( <?= $time_left ?> )</span>
        </div>


        
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
        input.addEventListener('input', (e) => {
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
                console.log("OTP complete:", otp);
                // هنا تقدر تنفذ ارسال الفورم تلقائيًا مثلاً:
                // document.getElementById('otp-form').submit();
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



</body>

</html>




 





