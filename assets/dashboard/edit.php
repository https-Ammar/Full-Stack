<?php
// تضمين ملف الاتصال بقاعدة البيانات
require __DIR__ . '/db.php'; // تأكد أن المسار صحيح بالنسبة لموقع ملف edit.php

// التحقق من وجود معرف الكارت وصحته
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("معرّف الكارت غير موجود أو غير صالح.");
}

$id = (int) $_GET['id'];

// جلب بيانات الكارت من قاعدة البيانات
$stmt = $pdo->prepare("SELECT * FROM cards WHERE id = ?");
$stmt->execute([$id]);
$card = $stmt->fetch();

if (!$card) {
    die("الكارت غير موجود.");
}
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>تعديل الكارت</title>
    <style>
        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea {
            width: 100%;
            max-width: 500px;
            padding: 8px;
            box-sizing: border-box;
        }

        img {
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h2>تعديل الكارت</h2>

    <form method="POST" action="update_card.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($card['id']) ?>">

        <label>العنوان:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($card['title']) ?>" required>

        <label>الوصف:</label>
        <textarea name="description" required><?= htmlspecialchars($card['description']) ?></textarea>

        <label>الرابط:</label>
        <input type="text" name="link" value="<?= htmlspecialchars($card['link']) ?>">

        <?php for ($i = 1; $i <= 6; $i++): ?>
            <label>صورة <?= $i ?>:</label>
            <input type="file" name="image<?= $i ?>">
            <?php if (!empty($card["image$i"])): ?>
                <br><img src="../../../dashboard/uploads/<?= htmlspecialchars($card["image$i"]) ?>" alt="Image<?= $i ?>"
                    width="80">
            <?php endif; ?>
            <br>
        <?php endfor; ?>

        <label>الدور:</label>
        <input type="text" name="role" value="<?= htmlspecialchars($card['role']) ?>">

        <label>الخدمات:</label>
        <textarea name="services"><?= htmlspecialchars($card['services']) ?></textarea>

        <label>الاعتمادات:</label>
        <textarea name="credits"><?= htmlspecialchars($card['credits']) ?></textarea>

        <label>الموقع:</label>
        <input type="text" name="location" value="<?= htmlspecialchars($card['location']) ?>">

        <label>السنة:</label>
        <input type="number" name="year" value="<?= htmlspecialchars($card['year']) ?>" min="1901" max="2155">

        <label>نص إضافي:</label>
        <textarea name="extra_text"><?= htmlspecialchars($card['extra_text']) ?></textarea>

        <label>تاريخ الإنشاء:</label>
        <input type="date" name="created_at" value="<?= htmlspecialchars($card['created_at']) ?>">

        <button type="submit">حفظ التعديلات</button>
    </form>

</body>

</html>