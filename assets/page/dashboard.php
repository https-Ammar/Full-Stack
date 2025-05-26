
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
    $date        = date('Y-m-d'); // توليد التاريخ تلقائيًا

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
    $date        = date('Y-m-d'); // تحديث التاريخ تلقائيًا عند التعديل

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
    echo "<script>window.location.href='dashboard.php';</script>";
}

// حذف زائر واحد
if (isset($_GET['delete_visitor'])) {
    $delete_id = intval($_GET['delete_visitor']);
    $conn->query("DELETE FROM visitors WHERE id = $delete_id");
    echo "<script>window.location.href='dashboard.php';</script>";
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
                                               <form method="post" onsubmit="return confirm('هل أنت متأكد من حذف جميع الزوار؟');">
                    <button  class="icon-button" type="submit" name="delete_all" class="btn btn-sm btn-danger mt-2">
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
                <?= htmlspecialchars($row['ip_address']) ?>
            </div>
            <div>
                <dd>City</dd>
                <?= htmlspecialchars($row['country']) ?>
            </div>
            <div>
                <?php
                    $datetime = strtotime($row['visit_time']);
                    $date = date('Y-m-d', $datetime);
                    $time = date('H:i:s', $datetime);
                ?>
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



                    <div class="payments">
                        

                    <?php foreach ($cards as $card): ?>



                              <div class="payment">
                            <div class="card green" style="background-image: url(uploads/<?php echo htmlspecialchars($card['image1']); ?>);">
                                <span><?= htmlspecialchars($card['created_at']) ?></span>
                                <span>
                                    •••• <?= htmlspecialchars($card['year']) ?>
                                </span>
                            </div>
                            <div class="payment-details">
                                <h3><?= htmlspecialchars($card['title']) ?></h3>
                                <div>
                                    <span>$ 2,110</span>
                                    <button class="icon-button">
                                                    <a href="?delete=<?= $card['id'] ?>" onclick="return confirm('هل أنت متأكد من حذف هذا الكارت؟')"> <i class="ph-caret-right-bold"></i></a>


                                       
                                    </button>
                                </div>
                            </div>
                        </div>
               



    <!-- <tr>
    
        <td><?= nl2br(htmlspecialchars($card['description'])) ?></td>
    
        <td>
    <img src="uploads/<?php echo htmlspecialchars($card['image2']); ?>" alt="Image 2" width="60">
    <img src="uploads/<?php echo htmlspecialchars($card['image3']); ?>" alt="Image 3" width="60">
    <img src="uploads/<?php echo htmlspecialchars($card['image4']); ?>" alt="Image 4" width="60">
    <img src="uploads/<?php echo htmlspecialchars($card['image5']); ?>" alt="Image 5" width="60">
    <img src="uploads/<?php echo htmlspecialchars($card['image6']); ?>" alt="Image 6" width="60">
</td>

        
        <td><?= htmlspecialchars($card['role']) ?></td>
        <td><?= nl2br(htmlspecialchars($card['services'])) ?></td>
        <td><?= nl2br(htmlspecialchars($card['credits'])) ?></td>
        <td><?= htmlspecialchars($card['location']) ?></td>

        <td > <?= nl2br(htmlspecialchars($card['extra_text'])) ?>  </td> -->

        <!-- <td>
            <a href="edit.php?id=<?= $card['id'] ?>">تعديل</a>
        </td> -->
 
    </tr>
<?php endforeach; ?>


                  
                        
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