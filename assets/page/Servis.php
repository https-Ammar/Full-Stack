<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include './head_links.php'; ?>
</head>

<body>

    <aside id="head"></aside>

    <section class="section pricing" id="price" aria-label="price">
        <div class="container">

            <div class="pricing-content">

                <p class="section-subtitle">Pricing</p>

                <h2 class="h2 section-title">Service Prices</h2>

                <p class="section-text">
                    Bringing 3+ years of solid experience in web development, I craft responsive, dynamic, and scalable web solutions tailored to your needs. From stunning interfaces to powerful backend systems — I turn ideas into digital reality with speed and precision.

                </p>

            </div>

            <?php
            $services = [
                ['icon' => 'code-slash', 'title' => 'Frontend Development', 'value' => '95%'],
                ['icon' => 'server', 'title' => 'Backend Development', 'value' => '90%'],
                ['icon' => 'construct', 'title' => 'API Integration', 'value' => '85%'],
                ['icon' => 'bug', 'title' => 'Debugging & Testing', 'value' => '80%'],
                ['icon' => 'laptop', 'title' => 'Responsive Design', 'value' => '95%'],
                ['icon' => 'cloud-upload', 'title' => 'Hosting & Deployment', 'value' => '88%'],
                ['icon' => 'lock-closed', 'title' => 'Web Security', 'value' => '92%'],
                ['icon' => 'analytics', 'title' => 'Performance Optimization', 'value' => '89%'],
                ['icon' => 'cash', 'title' => 'POS System (Cashier)', 'value' => '90%'],
                ['icon' => 'cube', 'title' => 'Inventory Management System', 'value' => '85%'],
                ['icon' => 'cart', 'title' => 'E-Commerce System', 'value' => '93%'],
                ['icon' => 'people', 'title' => 'HR Management System', 'value' => '87%'],
                ['icon' => 'document-text', 'title' => 'Accounting System', 'value' => '86%'],
                ['icon' => 'calendar', 'title' => 'Booking & Scheduling System', 'value' => '84%'],
            ];
            ?>

            <ul class="pricing-list">
                <?php foreach ($services as $service): ?>
                    <li>
                        <div class="pricing-card">
                            <ion-icon name="<?= $service['icon'] ?>" aria-hidden="true" role="img" class="md hydrated"></ion-icon>
                            <h3 class="card-title"><?= $service['title'] ?></h3>
                            <data class="card-price"><?= $service['value'] ?></data>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="../js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>