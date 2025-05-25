<?php
include 'db.php';

// جلب كل المنتجات (الكروت) من قاعدة البيانات
$sql = "SELECT * FROM cards ORDER BY id DESC";
$result = $conn->query($sql);

$cards = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }
} else {
    echo "خطأ في جلب البيانات: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <title>عرض المنتجات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
            direction: rtl;
        }
        .products-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 6px rgba(0,0,0,0.1);
            width: 250px;
            padding: 15px;
            text-align: right;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.15);
        }
        .product-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 6px;
        }
        .product-title {
            font-weight: bold;
            margin: 10px 0 5px 0;
            font-size: 18px;
        }
        .product-description {
            font-size: 14px;
            color: #555;
            height: 60px;
            overflow: hidden;
            margin-bottom: 10px;
        }
        .product-link a {
            color: #0066cc;
            text-decoration: none;
            font-weight: bold;
        }
        .product-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>المنتجات</h1>

<div class="products-container">
    <?php foreach ($cards as $card): ?>
        <div class="product-card">
            <?php if (!empty($card['image1'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($card['image1']); ?>" alt="<?php echo htmlspecialchars($card['title']); ?>" class="product-image" />
            <?php else: ?>
                <div style="height:150px;background:#ddd;border-radius:6px;"></div>
            <?php endif; ?>

            <div class="product-title"><?php echo htmlspecialchars($card['title']); ?></div>
            <div class="product-description"><?php echo nl2br(htmlspecialchars(substr($card['description'], 0, 100))); ?>...</div>
            <div class="product-link">
                <a href="details.php?id=<?php echo $card['id']; ?>">عرض التفاصيل</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
