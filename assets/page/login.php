<?php
session_start();
include 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

$error = '';

function send_otp_email($otp) {
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
        // هنا نرسل دائمًا إلى هذا الإيميل فقط:
        $mail->addAddress('ammar132004@gmail.com');

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier']);
    $password   = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $username, $email, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $otp_code = rand(100000, 999999);
            $_SESSION['otp'] = $otp_code;
            $_SESSION['otp_expiry'] = time() + 300; // صلاحية 5 دقائق
            $_SESSION['temp_user_id'] = $user_id;
            $_SESSION['temp_username'] = $username;
            $_SESSION['temp_email'] = $email;

            // هنا نستدعي الدالة بدون إرسال إيميل المستخدم
            if (send_otp_email($otp_code)) {
                header("Location: verify.php");
                exit();
            } else {
                $error = "فشل في إرسال كود التحقق. حاول مرة أخرى.";
            }
        } else {
            $error = "كلمة المرور غير صحيحة.";
        }
    } else {
        $error = "لا يوجد مستخدم بهذا البريد أو الهاتف.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <title>تسجيل الدخول</title>
</head>
<body>
    <h2>تسجيل الدخول</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="identifier" placeholder="البريد الإلكتروني أو الهاتف" required><br><br>
        <input type="password" name="password" placeholder="كلمة المرور" required><br><br>
        <button type="submit">تسجيل الدخول</button>
    </form>

    <p>لا تملك حساب؟ <a href="register.php">أنشئ حساباً</a></p>
</body>
</html>
