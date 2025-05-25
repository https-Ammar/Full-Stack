<?php
include 'db.php';

// --- إضافة كارت جديد ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $link        = $_POST['link'];
    $role        = $_POST['role'];
    $services    = $_POST['services'];
    $credits     = $_POST['credits'];
    $location    = $_POST['location'];
    $year        = intval($_POST['year']);
    $extra_text  = $_POST['extra_text'];
    $date        = $_POST['date'];

    // تحقق من صحة السنة
    if ($year < 1901 || $year > 2155) {
        die("قيمة السنة غير صالحة. يجب أن تكون بين 1901 و 2155.");
    }

    // رفع الصور
    $images = [];
    for ($i = 1; $i <= 6; $i++) {
        $field = "image$i";
        if (!empty($_FILES[$field]['name'])) {
            $name = basename($_FILES[$field]['name']);
            move_uploaded_file($_FILES[$field]['tmp_name'], "uploads/$name");
            $images[$i] = $name;
        } else {
            $images[$i] = '';
        }
    }

    $stmt = $conn->prepare("INSERT INTO cards
        (title, description, link, image1, image2, image3, image4, image5, image6,
         role, services, credits, location, year, extra_text, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssssssss",
        $title, $description, $link,
        $images[1], $images[2], $images[3], $images[4], $images[5], $images[6],
        $role, $services, $credits, $location, $year, $extra_text, $date);

    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
}

// --- حذف كارت ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // حذف الصور من المجلد
    $res = $conn->prepare("SELECT image1, image2, image3, image4, image5, image6 FROM cards WHERE id = ?");
    $res->bind_param("i", $id);
    $res->execute();
    $result = $res->get_result();
    if ($result->num_rows) {
        $imgs = $result->fetch_assoc();
        foreach ($imgs as $img) {
            if (!empty($img)) {
                @unlink("uploads/$img");
            }
        }
    }
    $res->close();

    // حذف السجل
    $del = $conn->prepare("DELETE FROM cards WHERE id = ?");
    $del->bind_param("i", $id);
    $del->execute();
    $del->close();

    header("Location: dashboard.php");
    exit();
}

// --- تعديل كارت ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id          = intval($_POST['edit_id']);
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $link        = $_POST['link'];
    $role        = $_POST['role'];
    $services    = $_POST['services'];
    $credits     = $_POST['credits'];
    $location    = $_POST['location'];
    $year        = intval($_POST['year']);
    $extra_text  = $_POST['extra_text'];
    $date        = $_POST['date'];

    if ($year < 1901 || $year > 2155) {
        die("قيمة السنة غير صالحة. يجب أن تكون بين 1901 و 2155.");
    }

    // الحصول على الصور القديمة
    $res = $conn->prepare("SELECT image1, image2, image3, image4, image5, image6 FROM cards WHERE id = ?");
    $res->bind_param("i", $id);
    $res->execute();
    $oldImages = $res->get_result()->fetch_assoc();
    $res->close();

    $images = [];
    for ($i = 1; $i <= 6; $i++) {
        $field = "image$i";
        if (!empty($_FILES[$field]['name'])) {
            if (!empty($oldImages["image$i"])) {
                @unlink("uploads/" . $oldImages["image$i"]);
            }
            $name = basename($_FILES[$field]['name']);
            move_uploaded_file($_FILES[$field]['tmp_name'], "uploads/$name");
            $images[$i] = $name;
        } else {
            $images[$i] = $oldImages["image$i"];
        }
    }

    $stmt = $conn->prepare("UPDATE cards SET
        title = ?, description = ?, link = ?,
        image1 = ?, image2 = ?, image3 = ?, image4 = ?, image5 = ?, image6 = ?,
        role = ?, services = ?, credits = ?, location = ?, year = ?, extra_text = ?, created_at = ?
        WHERE id = ?");

    $stmt->bind_param("sssssssssssssssii",
        $title, $description, $link,
        $images[1], $images[2], $images[3], $images[4], $images[5], $images[6],
        $role, $services, $credits, $location, $year, $extra_text, $date, $id);

    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
}

// --- جلب الكروت للعرض ---
$result = $conn->query("SELECT * FROM cards ORDER BY id DESC");
$cards = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - الكروت</title>
    <style>
        form { margin-bottom: 40px; }
        input, textarea { width: 100%; padding: 8px; margin: 4px 0; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: center; }
        img { max-width: 80px; height: auto; }
    </style>
</head>
<body>

<h1>إضافة كارت جديد</h1>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="العنوان" required>
    <textarea name="description" placeholder="الوصف" required></textarea>
    <input type="text" name="link" placeholder="الرابط">
    
    <label>صورة 1: <input type="file" name="image1"></label><br>
    <label>صورة 2: <input type="file" name="image2"></label><br>
    <label>صورة 3: <input type="file" name="image3"></label><br>
    <label>صورة 4: <input type="file" name="image4"></label><br>
    <label>صورة 5: <input type="file" name="image5"></label><br>
    <label>صورة 6: <input type="file" name="image6"></label><br>
    
    <input type="text" name="role" placeholder="الدور">
    <textarea name="services" placeholder="الخدمات"></textarea>
    <textarea name="credits" placeholder="الاعتمادات"></textarea>
    <input type="text" name="location" placeholder="الموقع">
    <input type="number" name="year" placeholder="السنة" min="1901" max="2155" required>
    <textarea name="extra_text" placeholder="نص إضافي"></textarea>
    <input type="date" name="date" required>
    
    <button type="submit" name="add">إضافة كارت</button>
</form>

<hr>

<h2>قائمة الكروت</h2>
<table>
    <thead>
        <tr>
            <th>العنوان</th>
            <th>الوصف</th>
            <th>الصور</th>
            <th>الدور</th>
            <th>الخدمات</th>
            <th>الاعتمادات</th>
            <th>الموقع</th>
            <th>السنة</th>
            <th>نص إضافي</th>
            <th>تاريخ الإنشاء</th>
            <th>تعديل</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cards as $card): ?>
            <tr>
                <td><?= htmlspecialchars($card['title']) ?></td>
                <td><?= nl2br(htmlspecialchars($card['description'])) ?></td>
                <td>
                    <?php
                    for ($i = 1; $i <= 6; $i++) {
                        $img = $card["image$i"];
                        if ($img) {
                            echo "<img src='uploads/".htmlspecialchars($img)."' alt='Image $i'> ";
                        }
                    }
                    ?>
                </td>
                <td><?= htmlspecialchars($card['role']) ?></td>
                <td><?= nl2br(htmlspecialchars($card['services'])) ?></td>
                <td><?= nl2br(htmlspecialchars($card['credits'])) ?></td>
                <td><?= htmlspecialchars($card['location']) ?></td>
                <td><?= htmlspecialchars($card['year']) ?></td>
                <td><?= nl2br(htmlspecialchars($card['extra_text'])) ?></td>
                <td><?= htmlspecialchars($card['created_at']) ?></td>
                <td>
                    <form method="POST" enctype="multipart/form-data" style="max-width: 300px;">
                        <input type="hidden" name="edit_id" value="<?= $card['id'] ?>">
                        <input type="text" name="title" value="<?= htmlspecialchars($card['title']) ?>" required>
                        <textarea name="description" required><?= htmlspecialchars($card['description']) ?></textarea>
                        <input type="text" name="link" value="<?= htmlspecialchars($card['link']) ?>">
                        
                        <label>صورة 1: <input type="file" name="image1"></label><br>
                        <label>صورة 2: <input type="file" name="image2"></label><br>
                        <label>صورة 3: <input type="file" name="image3"></label><br>
                        <label>صورة 4: <input type="file" name="image4"></label><br>
                        <label>صورة 5: <input type="file" name="image5"></label><br>
                        <label>صورة 6: <input type="file" name="image6"></label><br>
                        
                        <input type="text" name="role" value="<?= htmlspecialchars($card['role']) ?>">
                        <textarea name="services"><?= htmlspecialchars($card['services']) ?></textarea>
                        <textarea name="credits"><?= htmlspecialchars($card['credits']) ?></textarea>
                        <input type="text" name="location" value="<?= htmlspecialchars($card['location']) ?>">
                        <input type="number" name="year" value="<?= htmlspecialchars($card['year']) ?>" min="1901" max="2155" required>
                        <textarea name="extra_text"><?= htmlspecialchars($card['extra_text']) ?></textarea>
                        <input type="date" name="date" value="<?= htmlspecialchars($card['created_at']) ?>" required>
                        <button type="submit">تعديل</button>
                    </form>
                </td>
                <td>
                    <a href="?delete=<?= $card['id'] ?>" onclick="return confirm('هل أنت متأكد من حذف هذا الكارت؟')">حذف</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
