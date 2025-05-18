<?php
include 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = $conn->query("SELECT * FROM cards WHERE id = $id");
if ($result->num_rows == 0) {
    die("الكارد غير موجود");
}
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $link = $_POST['link'];
    $date = $_POST['date'];

    $cover = $row['cover_image'];
    $second = $row['second_image'];

    if (!empty($_FILES['cover_image']['name'])) {
        @unlink("uploads/" . $cover);
        $cover = $_FILES['cover_image']['name'];
        move_uploaded_file($_FILES['cover_image']['tmp_name'], "uploads/$cover");
    }

    if (!empty($_FILES['second_image']['name'])) {
        @unlink("uploads/" . $second);
        $second = $_FILES['second_image']['name'];
        move_uploaded_file($_FILES['second_image']['tmp_name'], "uploads/$second");
    }

    $conn->query("UPDATE cards SET
        title = '$title',
        description = '$desc',
        link = '$link',
        created_at = '$date',
        cover_image = '$cover',
        second_image = '$second'
        WHERE id = $id");

    header("Location: dashboard.php");
    exit();
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required><br>
    <textarea name="description"><?= htmlspecialchars($row['description']) ?></textarea><br>
    <input type="text" name="link" value="<?= htmlspecialchars($row['link']) ?>"><br>
    <input type="date" name="date" value="<?= htmlspecialchars($row['created_at']) ?>" required><br>

    <p>الصورة الحالية للكافر:</p>
    <img src="uploads/<?= htmlspecialchars($row['cover_image']) ?>" width="100"><br>
    <input type="file" name="cover_image"><br>

    <p>الصورة الثانية الحالية:</p>
    <img src="uploads/<?= htmlspecialchars($row['second_image']) ?>" width="100"><br>
    <input type="file" name="second_image"><br>

    <button type="submit">تحديث</button>
</form>