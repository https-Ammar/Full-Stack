<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $role = $_POST['role'];
    $services = $_POST['services'];
    $credits = $_POST['credits'];
    $location = $_POST['location'];
    $year = intval($_POST['year']);
    $extra_text = $_POST['extra_text'];
    $date = date('Y-m-d');

    if ($year < 1901 || $year > 2155) {
        die("قيمة السنة غير صالحة. يجب أن تكون بين 1901 و 2155.");
    }

    $images = [];
    for ($i = 1; $i <= 6; $i++) {
        $field = "image$i";
        if (!empty($_FILES[$field]['name'])) {
            $name = basename($_FILES[$field]['name']);
            move_uploaded_file($_FILES[$field]['tmp_name'], "../dashboard/uploads/$name");
            $images[$i] = $name;
        } else {
            $images[$i] = '';
        }
    }

    $stmt = $conn->prepare("INSERT INTO cards
        (title, description, link, image1, image2, image3, image4, image5, image6,
         role, services, credits, location, year, extra_text, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ssssssssssssssss",
        $title,
        $description,
        $link,
        $images[1],
        $images[2],
        $images[3],
        $images[4],
        $images[5],
        $images[6],
        $role,
        $services,
        $credits,
        $location,
        $year,
        $extra_text,
        $date
    );

    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $res = $conn->prepare("SELECT image1, image2, image3, image4, image5, image6 FROM cards WHERE id = ?");
    $res->bind_param("i", $id);
    $res->execute();
    $result = $res->get_result();
    if ($result->num_rows) {
        $imgs = $result->fetch_assoc();
        foreach ($imgs as $img) {
            if (!empty($img)) {
                @unlink("../dashboard/uploads/$img");
            }
        }
    }
    $res->close();

    $del = $conn->prepare("DELETE FROM cards WHERE id = ?");
    $del->bind_param("i", $id);
    $del->execute();
    $del->close();

    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = intval($_POST['edit_id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $role = $_POST['role'];
    $services = $_POST['services'];
    $credits = $_POST['credits'];
    $location = $_POST['location'];
    $year = intval($_POST['year']);
    $extra_text = $_POST['extra_text'];
    $date = date('Y-m-d');

    if ($year < 1901 || $year > 2155) {
        die("قيمة السنة غير صالحة. يجب أن تكون بين 1901 و 2155.");
    }

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
                @unlink("../dashboard/uploads/" . $oldImages["image$i"]);
            }
            $name = basename($_FILES[$field]['name']);
            move_uploaded_file($_FILES[$field]['tmp_name'], "../dashboard/uploads/$name");
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

    $stmt->bind_param(
        "ssssssssssssssssi",
        $title,
        $description,
        $link,
        $images[1],
        $images[2],
        $images[3],
        $images[4],
        $images[5],
        $images[6],
        $role,
        $services,
        $credits,
        $location,
        $year,
        $extra_text,
        $date,
        $id
    );

    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}

$result = $conn->query("SELECT * FROM cards ORDER BY id DESC");
$cards = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>



<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Admin Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --sidebar-width: 280px;
            --primary-orange: #f97316;
            --primary-orange-hover: #ea580c;
            --dark-bg: #1a1d23;
            --darker-bg: #151821;
            --card-bg: #242830;
            --text-muted: #6c757d;
            --border-color: #2d3748;
        }

        body {
            background-color: #22282e;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: #282f36;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-header h4 {
            color: var(--primary-orange);
            font-weight: 700;
            margin: 0;
        }

        .nav-section-title {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 1.5rem 0.5rem;
            margin: 0;
        }

        .sidebar .nav-link {
            color: #a0aec0;
            padding: 0.75rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(249, 115, 22, 0.1);
            color: var(--primary-orange);
            border-left-color: var(--primary-orange);
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .top-navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
        }

        .content-area {
            padding: 2rem;
        }

        /* Stats Cards */
        .stats-card {
            background-color: #282f36;
            /* border: 1px solid var(--border-color); */
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            height: 100%;
            border-radius: 20px;
        }

        .stats-value {
            text-align: right;
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            background-color: var(--primary-orange);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin: 0.5rem 0;
        }

        .stats-change {
            font-size: 0.875rem;
            font-weight: 500;
        }

        .stats-change.positive {
            color: #10b981;
        }

        .stats-change.negative {
            color: #ef4444;
        }

        /* Chart Container */
        .chart-container {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            height: 400px;
        }

        /* Alert */
        .custom-alert {
            background-color: rgba(217, 119, 6, 0.1);
            border: 1px solid #d97706;
            color: #fbbf24;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        /* Table */
        .product-table {
            background-color: #282f36;
            border-radius: 12px;
            overflow: hidden;
        }

        .product-table .table {
            margin: 0;
        }

        .product-table .table th {
            background-color: var(--darker-bg);
            border-color: var(--border-color);
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }

        .product-table .table td {
            border-color: var(--border-color);
            padding: 1rem;
            vertical-align: middle;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .btn-primary-custom {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-orange-hover);
            border-color: var(--primary-orange-hover);
            transform: translateY(-1px);
        }

        .search-input {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: white;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            width: 250px;
        }

        .search-input:focus {
            background-color: var(--card-bg);
            border-color: var(--primary-orange);
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.25);
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Footer */
        .footer {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-color);
            padding: 1rem 2rem;
            margin-top: auto;
            color: var(--text-muted);
            text-align: center;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--darker-bg);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-building"></i> RealEstate</h4>
        </div>

        <div class="nav-section-title">GENERAL</div>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="bi bi-grid"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-house"></i> Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-list-ul"></i> All Product List</a>
            </li>



            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-credit-card"></i> Payments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-white d-md-none" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h2 class="mb-0 text-white fw-bold">WELCOME!</h2>
            </div>

        </div>

        <!-- Content Area -->
        <div class="content-area">


            <div class="row">
                <!-- Stats Cards -->
                <div class="col-lg-8">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="stats-card">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stats-icon me-3">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted">Total Visitors</div>
                                        <div class="stats-value">20</div>

                                    </div>
                                </div>
                                <div class="stats-change positive">
                                    <i class="bi bi-arrow-up"></i> 2.3% Last Week
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="stats-card">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stats-icon me-3">
                                        <i class="bi bi-person-check"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted">Users</div>
                                        <div class="stats-value">2</div>

                                    </div>
                                </div>
                                <div class="stats-change positive">
                                    <i class="bi bi-arrow-up"></i> 8.1% Last Month
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="stats-card">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stats-icon me-3">
                                        <i class="bi bi-box"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted">Products</div>
                                        <div class="stats-value">1</div>

                                    </div>
                                </div>
                                <div class="stats-change negative">
                                    <i class="bi bi-arrow-down"></i> 0.3% Last Month
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="stats-card">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stats-icon me-3">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted">Time</div>
                                        <div class="stats-value">9:21</div>

                                    </div>
                                </div>
                                <div class="stats-change positive">
                                    <i class="bi bi-arrow-up"></i> 10.6% Last Month
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="col-lg-4">
                    <div class="chart-container">
                        <!--  -->
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="product-table mt-4">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom"
                    style="border-color: var(--border-color) !important;">
                    <h5 class="text-white mb-0">All Product List</h5>
                    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">
                                    <input type="checkbox" class="form-check-input">
                                </th>
                                <th>& Product</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($cards as $card): ?>


                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="../dashboard/uploads/<?php echo htmlspecialchars($card['image1']); ?>"
                                                alt="Property" class="product-image me-3"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <div class="text-white fw-semibold"> <?= htmlspecialchars($card['title']) ?>
                                                </div>
                                                <div class="text-muted small">Location :
                                                    <?= htmlspecialchars($card['location']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-white"><?= nl2br(htmlspecialchars($card['services'])) ?></td>
                                    <td>
                                        <?= htmlspecialchars($card['year']) ?>
                                    </td>
                                    <td>
                                        <button class="icon-button">
                                            <a href="?delete=<?= $card['id'] ?>">
                                                <i class="ph-caret-right-bold"></i></a>



                                        </button>
                                    </td>
                                </tr>




                            <?php endforeach; ?>


                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add Product Modal -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header border-bottom">
                            <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="#" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="productName" name="product_name"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="productPrice" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="productPrice" name="product_price"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="productCategory" class="form-label">Category</label>
                                    <select class="form-select" id="productCategory" name="product_category" required>
                                        <option value="">Choose...</option>
                                        <option value="Real Estate">Real Estate</option>
                                        <option value="Electronics">Electronics</option>
                                        <option value="Furniture">Furniture</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="productImage" class="form-label">Image URL</label>
                                    <input type="url" class="form-control" id="productImage" name="product_image">
                                </div>
                            </div>
                            <div class="modal-footer border-top">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="footer">
            © Larkon. Crafted by Ammar
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        .stats-change.positive,
        .stats-change.negative {
            background: #22282e;
            padding: 10px;
            border-radius: 30px;
        }

        .d-flex.align-items-center.mb-3 {
            justify-content: space-between;
            text-align: right;
        }

        td {
            background: #282f36 !important;
        }

        .modal-dialog {
            height: 100vh;
            padding: 0;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center !important;
            width: 100%;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<!--  -->
<!--  -->







<!--  -->
<!--  -->
<!--  -->

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bank dashboard concept</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="../css/dashboard.css" />


</head>

<body>
    <div class="app">
        <header class="app-header">
            <div class="app-header-logo">
                <div class="logo">
                    <span class="logo-icon">
                        <img src="https://assets.codepen.io/285131/almeria-logo.svg" />
                    </span>
                    <h1 class="logo-title">
                        <span>Almeria</span>
                        <span>NeoBank</span>
                    </h1>
                </div>
            </div>
            <div class="app-header-navigation">
                <div class="tabs">
                    <a href="#">
                        Overview
                    </a>
                    <a href="#" class="active">
                        Payments
                    </a>
                    <a href="#">
                        Cards
                    </a>
                    <a href="#">
                        Account
                    </a>
                    <a href="#">
                        System
                    </a>
                    <a href="#">
                        Business
                    </a>
                </div>
            </div>
            <div class="app-header-actions">
                <button class="user-profile">
                    <span>Matheo Peterson</span>
                    <span>
                        <img src="https://assets.codepen.io/285131/almeria-avatar.jpeg" />
                    </span>
                </button>
                <div class="app-header-actions-buttons">
                    <button class="icon-button large">
                        <i class="ph-magnifying-glass"></i>
                    </button>
                    <button class="icon-button large">
                        <i class="ph-bell"></i>
                    </button>
                </div>
            </div>
            <div class="app-header-mobile">
                <button class="icon-button large">
                    <i class="ph-list"></i>
                </button>
            </div>

        </header>
        <div class="app-body">
            <div class="app-body-navigation">
                <nav class="navigation">
                    <a href="#">
                        <i class="ph-browsers"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#">
                        <i class="ph-check-square"></i>
                        <span>Scheduled</span>
                    </a>
                    <a href="#">
                        <i class="ph-swap"></i>
                        <span>Transfers</span>
                    </a>
                    <a href="#">
                        <i class="ph-file-text"></i>
                        <span>Templates</span>
                    </a>
                    <a href="#">
                        <i class="ph-globe"></i>
                        <span>SWIFT</span>
                    </a>
                    <a href="#">
                        <i class="ph-clipboard-text"></i>
                        <span>Exchange</span>
                    </a>
                </nav>
                <footer class="footer">
                    <h1>Almeria<small>©</small></h1>
                    <div>
                        Almeria ©<br />
                        All Rights Reserved 2021
                    </div>
                </footer>
            </div>
            <div class="app-body-main-content">
                <section class="service-section">
                    <h2>Service</h2>
                    <div class="service-section-header">
                        <div class="search-field">
                            <i class="ph-magnifying-glass"></i>
                            <input type="text" placeholder="Account number">
                        </div>

                    </div>
                    <div class="mobile-only">
                        <button class="flat-button">
                            Toggle search
                        </button>
                    </div>




                    <!--  -->
                    <!--  -->

                    <div class="tab-content">

                        <?php
                        // عداد عدد الكروت
                        $card_count = $conn->query("SELECT COUNT(*) as total FROM cards")->fetch_assoc()['total'];

                        // حساب عدد الزوار
                        $count_result = $conn->query("SELECT COUNT(*) as total FROM visitors");
                        $count_row = $count_result->fetch_assoc();
                        $total_visitors = $count_row['total'];

                        // حذف جميع الزوار
                        if (isset($_POST['delete_all'])) {
                            $conn->query("DELETE FROM visitors");
                            echo "<script>window.location.href='index.php';</script>";
                        }

                        // حذف زائر واحد
                        if (isset($_GET['delete_visitor'])) {
                            $delete_id = intval($_GET['delete_visitor']);
                            $conn->query("DELETE FROM visitors WHERE id = $delete_id");
                            echo "<script>window.location.href='index.php';</script>";
                        }
                        ?>



                        <div class="tiles">
                            <article class="tile">
                                <div class="tile-header">
                                    <i class="ph-lightning-light"></i>
                                    <h3>
                                        <span>Electricity</span>
                                        <span>UrkEnergo -- <?= $card_count ?></span>
                                    </h3>
                                </div>
                                <a href="#">
                                    <span>Go to service</span>
                                    <span class="icon-button">
                                        <i class="ph-caret-right-bold"></i>
                                    </span>
                                </a>
                            </article>
                            <article class="tile">
                                <div class="tile-header">
                                    <i class="ph-fire-simple-light"></i>
                                    <h3>
                                        <span>Heating Gas</span>
                                        <span>Gazprom UA -- <?= $total_visitors ?></span>
                                    </h3>
                                </div>
                                <a href="#">
                                    <span>Go to service</span>


                                    <span class="icon-button">
                                        <form method="post"
                                            onsubmit="return confirm('هل أنت متأكد من حذف جميع الزوار؟');">
                                            <button class="icon-button" type="submit" name="delete_all"
                                                class="btn btn-sm btn-danger mt-2">
                                                <i class="ph-caret-right-bold"></i>
                                            </button>
                                        </form>
                                    </span>
                                </a>
                            </article>
                            <article class="tile">
                                <div class="tile-header">
                                    <i class="ph-file-light"></i>
                                    <h3>
                                        <span>Tax online</span>
                                        <span>Kharkov 62 str.</span>
                                    </h3>
                                </div>
                                <a href="#">
                                    <span>Go to service</span>
                                    <span class="icon-button">
                                        <i class="ph-caret-right-bold"></i>
                                    </span>
                                </a>
                            </article>
                        </div>




                        <div class="row">


                            <h5 class="card-title text-uppercase text-muted mb-0">Session Time</h5>
                            <span id="session-timer" class="h2 font-weight-bold mb-0">00:00:00 AM</span>



                            <h5 class="card-title text-uppercase text-muted mb-0">Today</h5>
                            <span id="current-date" class="h2 font-weight-bold mb-0">--</span>

                        </div>

                        <!-- JavaScript للمؤقت والتاريخ -->
                        <script>
                            // المؤقت
                            function formatTime(hours24, minutes, seconds) {
                                const ampm = hours24 >= 12 ? 'PM' : 'AM';
                                let hours12 = hours24 % 12;
                                const displayHours = hours12 === 0 ? '00' : (hours12 < 10 ? '0' + hours12 : hours12);
                                const m = minutes < 10 ? '0' + minutes : minutes;
                                const s = seconds < 10 ? '0' + seconds : seconds;
                                return `${displayHours}:${m}:${s} ${ampm}`;
                            }

                            let elapsedSeconds = parseInt(localStorage.getItem('elapsedSeconds')) || 0;
                            function updateSessionTimer() {
                                elapsedSeconds++;
                                const hours24 = Math.floor(elapsedSeconds / 3600);
                                const minutes = Math.floor((elapsedSeconds % 3600) / 60);
                                const seconds = elapsedSeconds % 60;
                                document.getElementById('session-timer').textContent = formatTime(hours24, minutes, seconds);
                                localStorage.setItem('elapsedSeconds', elapsedSeconds);
                            }
                            setInterval(updateSessionTimer, 1000);
                            updateSessionTimer();

                            // التاريخ
                            document.addEventListener('DOMContentLoaded', () => {
                                const dateSpan = document.getElementById('current-date');
                                const today = new Date();
                                const year = today.getFullYear();
                                const month = String(today.getMonth() + 1).padStart(2, '0');
                                const day = String(today.getDate()).padStart(2, '0');
                                dateSpan.textContent = `${year}-${month}-${day}`;
                            });
                        </script>

                    </div>




                    <!--  -->


                </section>
                <section class="transfer-section">
                    <div class="transfer-section-header">
                        <h2>Latest transfers</h2>
                        <div class="filter-options">
                            <p>Filter selected: more than 100 $</p>
                            <button class="icon-button">
                                <i class="ph-funnel"></i>
                            </button>
                            <button class="icon-button">
                                <i class="ph-plus"></i>
                            </button>
                        </div>
                    </div>


                    <?php
                    $res = $conn->query("SELECT * FROM visitors ORDER BY id DESC");
                    if ($res && $res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            $datetime_str = $row['visit_time'] ?? '';
                            if ($datetime_str) {
                                $datetime = strtotime($datetime_str);
                                $date = date('Y-m-d', $datetime);
                                $time = date('H:i:s', $datetime);
                            } else {
                                $date = 'غير معروف';
                                $time = 'غير معروف';
                            }
                            ?>
                            <div class="transfers">
                                <div class="transfer">
                                    <div class="transfer-logo">
                                        <img src="https://assets.codepen.io/285131/apple.svg" />
                                        <?= htmlspecialchars($row['id']) ?>
                                    </div>
                                    <dl class="transfer-details">
                                        <div>
                                            <dd>ID</dd>
                                            <?= htmlspecialchars($row['ip_address'] ?? 'غير معروف') ?>
                                        </div>
                                        <div>
                                            <dd>City</dd>
                                            <?= htmlspecialchars($row['country'] ?? 'غير معروف') ?>
                                        </div>
                                        <div>
                                            <dd>Date</dd>
                                            <?= htmlspecialchars($date) ?>
                                        </div>
                                        <div>
                                            <dd>Time</dd>
                                            <?= htmlspecialchars($time) ?>
                                        </div>
                                    </dl>
                                    <div class="transfer-number">
                                        <a href="?delete_visitor=<?= urlencode($row['id']) ?>"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا الزائر؟')"
                                            style="color:red; text-decoration:none; font-size:18px;">
                                            <button class="icon-button">
                                                <i class="ph-plus"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <li class="mt-5 mb-5">No visitors yet</li>
                        <?php
                    }
                    ?>





                </section>
            </div>
            <div class="app-body-sidebar">
                <section class="payment-section">
                    <h2>New Payment</h2>
                    <div class="payment-section-header">
                        <p>Choose a card to transfer money</p>
                        <div>
                            <button class="card-button mastercard">
                                <svg width="2001" height="1237" viewBox="0 0 2001 1237" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="a624784f2834e21c94a1c0c9a58bbbaa">
                                        <path id="7869b07bea546aa59a5ee138adbcfd5a"
                                            d="M1270.57 1104.15H729.71V132.15H1270.58L1270.57 1104.15Z"
                                            fill="currentColor"></path>
                                        <path id="b54e3ab4d7044a9f288082bc6b864ae6"
                                            d="M764 618.17C764 421 856.32 245.36 1000.08 132.17C891.261 46.3647 756.669 -0.204758 618.09 9.6031e-07C276.72 9.6031e-07 0 276.76 0 618.17C0 959.58 276.72 1236.34 618.09 1236.34C756.672 1236.55 891.268 1189.98 1000.09 1104.17C856.34 991 764 815.35 764 618.17Z"
                                            fill="currentColor"></path>
                                        <path id="67f94b4d1b83252a6619ed6e0cc0a3a1"
                                            d="M2000.25 618.17C2000.25 959.58 1723.53 1236.34 1382.16 1236.34C1243.56 1236.54 1108.95 1189.97 1000.11 1104.17C1143.91 990.98 1236.23 815.35 1236.23 618.17C1236.23 420.99 1143.91 245.36 1000.11 132.17C1108.95 46.3673 1243.56 -0.201169 1382.15 -2.24915e-05C1723.52 -2.24915e-05 2000.24 276.76 2000.24 618.17"
                                            fill="currentColor"></path>
                                    </g>
                                </svg>
                            </button>
                            <button class="card-button visa active">
                                <svg xmlns="http://www.w3.org/2000/svg" width="2500" height="2500"
                                    viewBox="0 0 141.732 141.732">
                                    <g fill="currentColor">
                                        <path
                                            d="M62.935 89.571h-9.733l6.083-37.384h9.734zM45.014 52.187L35.735 77.9l-1.098-5.537.001.002-3.275-16.812s-.396-3.366-4.617-3.366h-15.34l-.18.633s4.691.976 10.181 4.273l8.456 32.479h10.141l15.485-37.385H45.014zM121.569 89.571h8.937l-7.792-37.385h-7.824c-3.613 0-4.493 2.786-4.493 2.786L95.881 89.571h10.146l2.029-5.553h12.373l1.14 5.553zm-10.71-13.224l5.114-13.99 2.877 13.99h-7.991zM96.642 61.177l1.389-8.028s-4.286-1.63-8.754-1.63c-4.83 0-16.3 2.111-16.3 12.376 0 9.658 13.462 9.778 13.462 14.851s-12.075 4.164-16.06.965l-1.447 8.394s4.346 2.111 10.986 2.111c6.642 0 16.662-3.439 16.662-12.799 0-9.72-13.583-10.625-13.583-14.851.001-4.227 9.48-3.684 13.645-1.389z" />
                                    </g>
                                    <path
                                        d="M34.638 72.364l-3.275-16.812s-.396-3.366-4.617-3.366h-15.34l-.18.633s7.373 1.528 14.445 7.253c6.762 5.472 8.967 12.292 8.967 12.292z"
                                        fill="currentColor" />
                                    <path fill="none" d="M0 0h141.732v141.732H0z" />
                                </svg>
                            </button>
                        </div>
                    </div>






                    <style>
                        .file-upload {
                            position: relative;
                            overflow: hidden;
                            display: inline-block;
                        }

                        .file-upload input[type="file"] {
                            position: absolute;
                            font-size: 100px;
                            opacity: 0;
                            right: 0;
                            top: 0;
                        }

                        .file-upload-label {
                            display: inline-block;
                            padding: 8px 16px;
                            background-color: #007bff;
                            color: white;
                            border-radius: 4px;
                            cursor: pointer;
                            margin-bottom: 8px;
                        }

                        .file-upload {
                            background: none !important;
                        }

                        label.file-upload-label {
                            background: none;
                            border: none !important;
                            padding: 0 !important;
                            margin: 0 !important;
                        }
                    </style>



                    <div class="faq">
                        <p>Most Frequently Asked Questions</p>

                        <form method="POST" enctype="multipart/form-data">

                            <!-- عناصر ظاهرة دائمًا -->
                            <div>
                                <label>Title</label>
                                <input type="text" name="title" placeholder="Title" required>
                            </div>

                            <div>
                                <label>Description</label>
                                <input type="text" name="description" placeholder="Description" required>
                            </div>

                            <div>
                                <label>Link</label>
                                <input type="text" name="link" placeholder="Link" required>
                            </div>

                            <!-- عناصر مخفية وتظهر عند الضغط -->
                            <div id="more-settings" style="display: none;">
                                <div>
                                    <label>Location</label>
                                    <input type="text" name="location" placeholder="Location" required>
                                </div>

                                <div>
                                    <label>Year</label>
                                    <input type="number" name="year" placeholder="Year" required>
                                </div>

                                <div>
                                    <label>Services</label>
                                    <input type="text" name="services" placeholder="Services" required>
                                </div>

                                <!-- ملفات الصور -->
                                <div>
                                    <label>Cover</label>
                                    <div class="file-upload">
                                        <label class="file-upload-label">Image
                                            <input type="file" name="image1">
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label>Image</label>
                                    <div class="file-upload">
                                        <label class="file-upload-label">Image
                                            <input type="file" name="image2">
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label>Image</label>
                                    <div class="file-upload">
                                        <label class="file-upload-label">Image
                                            <input type="file" name="image3">
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label>Image</label>
                                    <div class="file-upload">
                                        <label class="file-upload-label">Image
                                            <input type="file" name="image4">
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label>Image</label>
                                    <div class="file-upload">
                                        <label class="file-upload-label">Image
                                            <input type="file" name="image5">
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label>Image</label>
                                    <div class="file-upload">
                                        <label class="file-upload-label">Image
                                            <input type="file" name="image6">
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label>Date</label>
                                    <input type="date" name="date" required>
                                </div>

                                <div>
                                    <label>Extra Text</label>
                                    <input type="text" name="extra_text" placeholder="Extra Text">
                                </div>
                            </div>

                            <!-- أزرار -->
                            <div class="payment-section-footer">
                                <button class="save-button" type="submit" name="add">Save</button>
                                <button class="settings-button" type="button" onclick="toggleSettings()">
                                    <i class="ph-gear"></i>
                                    <span>More Settings</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- JavaScript لإظهار/إخفاء الإعدادات -->
                    <script>
                        function toggleSettings() {
                            var moreSettings = document.getElementById("more-settings");
                            if (moreSettings.style.display === "none") {
                                moreSettings.style.display = "block";
                            } else {
                                moreSettings.style.display = "none";
                            }
                        }
                    </script>




                    <!-- <input type="text" name="role" placeholder="الدور"> -->
                    <!-- <textarea name="credits" placeholder="الاعتمادات"></textarea> -->



                </section>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/phosphor-icons"></script>
</body>

</html>















</body>

</html>