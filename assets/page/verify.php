<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

define('OTP_EXPIRY_TIME', 300); // 5 دقائق صلاحية الكود
define('RESEND_INTERVAL', 60);  // 60 ثانية وقت انتظار إعادة الإرسال

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
        $mail->Password   = 'jwwichdusrcdjawg';  // كلمة مرور التطبيق
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

// التأكد من وجود بيانات OTP المؤقتة وإلا إعادة توجيه للصفحة الرئيسية
if (!isset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['temp_user_id'], $_SESSION['temp_username'], $_SESSION['temp_email'])) {
    header("Location: login.php");
    exit();
}

// حساب الوقت المتبقي
$time_left = $_SESSION['otp_expiry'] - time();
if ($time_left < 0) {
    $time_left = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['otp'])) {
        $user_otp = $_POST['otp'];

        if ($_SESSION['otp'] == $user_otp && time() < $_SESSION['otp_expiry']) {
            // تسجيل الدخول الناجح
            $_SESSION['user_id'] = $_SESSION['temp_user_id'];
            $_SESSION['username'] = $_SESSION['temp_username'];

            // إزالة بيانات OTP المؤقتة
            unset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['temp_user_id'], $_SESSION['temp_username'], $_SESSION['temp_email']);

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "الكود غير صحيح أو منتهي الصلاحية.";
        }
    } elseif (isset($_POST['resend_otp'])) {
        $time_since_last_otp = time() - ($_SESSION['otp_expiry'] - OTP_EXPIRY_TIME);

        if ($time_since_last_otp >= RESEND_INTERVAL) {
            $otp_code = rand(100000, 999999);
            $_SESSION['otp'] = $otp_code;
            $_SESSION['otp_expiry'] = time() + OTP_EXPIRY_TIME;

            if (send_otp_email($_SESSION['temp_email'], $otp_code)) {
                $success = "تم إعادة إرسال كود التفعيل إلى بريدك الإلكتروني.";
                $time_left = OTP_EXPIRY_TIME;
            } else {
                $error = "فشل في إعادة إرسال كود التحقق. حاول مرة أخرى.";
            }
        } else {
            $error = "الرجاء الانتظار قبل إعادة إرسال الكود.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <title>تأكيد كود التفعيل</title>
    <style>
        #countdown {
            font-weight: bold;
            color: green;
        }
        #resend-btn {
            margin-top: 10px;
        }
        #resend-btn:disabled {
            color: gray;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h2>أدخل كود التفعيل المرسل إلى بريدك الإلكتروني</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <p>الوقت المتبقي لإدخال الكود: <span id="countdown"><?= $time_left ?></span> ثانية</p>

    <form method="post" style="margin-bottom:10px;">
        <input type="text" name="otp" placeholder="كود التفعيل" required maxlength="6" pattern="\d{6}"><br><br>
        <button type="submit">تأكيد</button>
    </form>

    <form method="post">
        <button type="submit" name="resend_otp" id="resend-btn" disabled>إعادة إرسال كود التفعيل</button>
    </form>

    <script>
        let timeLeft = <?= $time_left ?>;
        const countdownEl = document.getElementById('countdown');
        const resendBtn = document.getElementById('resend-btn');

        const RESEND_INTERVAL = <?= RESEND_INTERVAL ?>;

        let timer = setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                countdownEl.textContent = timeLeft;
            } else {
                countdownEl.textContent = "انتهى الوقت، يمكنك إعادة إرسال الكود الآن.";
                resendBtn.disabled = false;
                clearInterval(timer);
            }
        }, 1000);
    </script>

    <p><a href="login.php">العودة لتسجيل الدخول</a></p>
</body>
</html>
