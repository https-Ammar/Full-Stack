<?php
session_start();
include 'db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // التحقق من صحة البيانات
    if ($password !== $confirm) {
        $error = "كلمتا المرور غير متطابقتين.";
    } elseif (strlen($username) < 3 || strlen($password) < 6) {
        $error = "اسم المستخدم يجب أن يكون ≥ 3 أحرف وكلمة المرور ≥ 6 أحرف.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "البريد الإلكتروني غير صالح.";
    } elseif (!preg_match('/^[0-9]{8,15}$/', $phone)) {
        $error = "رقم الهاتف غير صالح.";
    } else {
        // التحقق من عدم وجود المستخدم مسبقًا
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "البريد الإلكتروني أو رقم الهاتف مستخدم مسبقًا.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $phone, $hashed);

            if ($stmt->execute()) {
                $success = "تم إنشاء الحساب بنجاح. يمكنك الآن <a href='login.php'>تسجيل الدخول</a>.";
            } else {
                $error = "حدث خطأ أثناء إنشاء الحساب.";
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب</title>
</head>
<body>
    <h2>إنشاء حساب جديد</h2>

    <?php if ($error): ?>
        <p style="color:red"><?= $error ?></p>
    <?php elseif ($success): ?>
        <p style="color:green"><?= $success ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="الاسم الكامل" required><br>
        <input type="email" name="email" placeholder="البريد الإلكتروني" required><br>
        <input type="text" name="phone" placeholder="رقم الهاتف" required><br>
        <input type="password" name="password" placeholder="كلمة المرور" required><br>
        <input type="password" name="confirm" placeholder="تأكيد كلمة المرور" required><br>
        <button type="submit">إنشاء حساب</button>
    </form>

    <p>هل لديك حساب؟ <a href="login.php">تسجيل الدخول</a></p>
</body>
</html>
