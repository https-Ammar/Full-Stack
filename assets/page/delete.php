<?php
include 'db.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $getImages = $conn->query("SELECT cover_image, second_image FROM cards WHERE id = $id");
    if ($getImages->num_rows > 0) {
        $img = $getImages->fetch_assoc();
        @unlink('uploads/' . $img['cover_image']);
        @unlink('uploads/' . $img['second_image']);
    }
    $conn->query("DELETE FROM cards WHERE id = $id");
    header("Location: dashboard.php");
    exit();
} else {
    echo "معرف الكارد غير موجود.";
}
