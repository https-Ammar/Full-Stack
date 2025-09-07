<?php
include 'db.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $getImages = $conn->query("SELECT cover_image, second_image FROM cards WHERE id = $id");
    if ($getImages->num_rows > 0) {
        $img = $getImages->fetch_assoc();
        @unlink('../dashboard/uploads/' . $img['cover_image']);
        @unlink('../dashboard/uploads/' . $img['second_image']);
    }
    $conn->query("DELETE FROM cards WHERE id = $id");
    header("Location: index.php");
    exit();
} else {
    echo "معرف الكارد غير موجود.";
}
