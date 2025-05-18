<?php include 'db.php'; ?>

<?php
// إضافة كارد جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $date = $_POST['date'];

    $cover = $_FILES['cover_image']['name'];
    $second = $_FILES['second_image']['name'];

    move_uploaded_file($_FILES['cover_image']['tmp_name'], "uploads/$cover");
    move_uploaded_file($_FILES['second_image']['tmp_name'], "uploads/$second");

    $conn->query("INSERT INTO cards (title, description, link, created_at, cover_image, second_image)
                  VALUES ('$title', '$description', '$link', '$date', '$cover', '$second')");
    header("Location: dashboard.php");
    exit();
}

// حذف كارت
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $res = $conn->query("SELECT cover_image, second_image FROM cards WHERE id = $id");
    if ($res->num_rows) {
        $img = $res->fetch_assoc();
        @unlink("uploads/" . $img['cover_image']);
        @unlink("uploads/" . $img['second_image']);
    }
    $conn->query("DELETE FROM cards WHERE id = $id");
    header("Location: dashboard.php");
    exit();
}

// تعديل كارت
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = intval($_POST['edit_id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $date = $_POST['date'];

    // الحصول على الصور القديمة
    $res = $conn->query("SELECT cover_image, second_image FROM cards WHERE id = $id");
    $img = $res->fetch_assoc();

    $cover = $img['cover_image'];
    $second = $img['second_image'];

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

    $conn->query("UPDATE cards SET title='$title', description='$description', link='$link', created_at='$date',
                   cover_image='$cover', second_image='$second' WHERE id = $id");

    header("Location: dashboard.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body class="section-bg">






    <div class="breadcrumb-wrapper bg-cover" style="background-image: url('../img/breadcrumb-bg.jpg');">
        <div class="container">
            <div class="page-heading">
                <h6 class="wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                    <img src="../img/star.png" alt="img"> user creation
                </h6>
                <h1 class="wow fadeInUp" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">Web <span>dashboard</span></h1>
            </div>
        </div>
    </div>




    <section class="portfolio-section section-padding section-bg">
        <div class="container">

            <ul class="nav" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#show" class="nav-link active" role="tab">show All</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#creative" class="nav-link" role="tab">creative</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#anime" class="nav-link" role="tab">anime</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#animal" class="nav-link" role="tab">animal</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#graphic" class="nav-link" role="tab">graphic</a>
                </li>
                <li><a class="page-numbers" href="#" id="close_input">+</a></li>
            </ul>







            <div class="tab-content">

                <div id="show" class="tab-pane fade active show" role="tabpanel">

                    <?php
                    // عداد عدد الكروت
                    $card_count = $conn->query("SELECT COUNT(*) as total FROM cards")->fetch_assoc()['total'];
                    ?>



                    <div class="item creative">
                        <div class="row ">

                            <?php
                            $cards = $conn->query("SELECT * FROM cards ORDER BY id DESC");
                            while ($row = $cards->fetch_assoc()):
                            ?>

                                <?php if (isset($_GET['edit']) && $_GET['edit'] == $row['id']): ?>
                                    <!-- نموذج تعديل الكارت -->
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">

                                        <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>

                                        <textarea name="description" required><?= htmlspecialchars($row['description']) ?></textarea>

                                        <input type="text" name="link" value="<?= htmlspecialchars($row['link']) ?>" required>

                                        <input type="date" name="date" value="<?= $row['created_at'] ?>" required>

                                        <input type="file" name="cover_image">

                                        <input type="file" name="second_image">

                                        <button type="submit">حفظ التعديلات</button>
                                    </form>
                                <?php else: ?>
                                    <div class="col-xl-4 col-lg-6 col-md-6">
                                        <div class="portfolio-card-items">
                                            <div class="portfolio-image" style="background-image: url(uploads/<?= htmlspecialchars($row['cover_image']) ?>);">

                                                <a href="contact.html" class="lets-circle">
                                                    <i class="fa-sharp fa-regular fa-arrow-up-right"></i> <br>
                                                    Project
                                                    details
                                                </a>
                                            </div>
                                            <div class="portfolio-content">
                                                <h6><span>//</span> <?= htmlspecialchars($row['title']) ?> - <?= htmlspecialchars($row['created_at']) ?></h6>
                                                <h3><a href="<?= htmlspecialchars($row['link']) ?>" target="_blank"><?= htmlspecialchars($row['title']) ?></a></h3>
                                            </div>
                                        </div>
                                        <div class="card-actions">
                                            <a href="?edit=<?= $row['id'] ?>">تعديل</a>
                                            <a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            <?php endwhile; ?>

                            <style>
                                .portfolio-image {
                                    height: 45vh;
                                }
                            </style>
                            <!-- <img src="uploads/<?= htmlspecialchars($row['second_image']) ?>" alt="الصورة الثانية"> -->

                        </div>
                    </div>




                    <?php
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






                    <div class="item anime">

                        <div class="main-content mb-5 p-0">
                            <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
                                <div class="container-fluid">
                                    <h2 class="mb-5 text-white">Stats Card</h2>
                                    <div class="header-body">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="card card-stats mb-4 mb-xl-0">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h5 class="card-title text-uppercase text-muted mb-0">Traffic</h5>
                                                                <span class="h2 font-weight-bold mb-0"><?= $card_count ?></span>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                                                    <i class="fas fa-chart-bar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mt-3 mb-0 text-muted text-sm">
                                                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                                            <span class="text-nowrap">Since last month</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="card card-stats mb-4 mb-xl-0">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
                                                                <span class="h2 font-weight-bold mb-0"><?php echo $total_visitors; ?> </span>

                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                                                    <i class="fas fa-chart-pie"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mt-3 mb-0 text-muted text-sm">
                                                        <form method="post" onsubmit="return confirm('هل أنت متأكد من حذف جميع الزوار؟');">
                                                            <button type="submit" name="delete_all">
                                                                <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
                                                                <span class="text-nowrap">Since last week</span>

                                                            </button>
                                                        </form>

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="card card-stats mb-4 mb-xl-0">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>


                                                                <span id="session-timer" class="h2 font-weight-bold mb-0">00:00:00 AM</span>

                                                                <script>
                                                                    function formatTime(hours24, minutes, seconds) {
                                                                        const ampm = hours24 >= 12 ? 'PM' : 'AM';

                                                                        let hours12 = hours24 % 12;
                                                                        const displayHours = hours12 === 0 ? '00' : (hours12 < 10 ? '0' + hours12 : hours12);

                                                                        const m = minutes < 10 ? '0' + minutes : minutes;
                                                                        const s = seconds < 10 ? '0' + seconds : seconds;

                                                                        return `${displayHours}:${m}:${s} ${ampm}`;
                                                                    }

                                                                    // جلب القيمة المخزنة أو بدء من صفر
                                                                    let elapsedSeconds = parseInt(localStorage.getItem('elapsedSeconds')) || 0;

                                                                    function updateSessionTimer() {
                                                                        elapsedSeconds++;

                                                                        const hours24 = Math.floor(elapsedSeconds / 3600);
                                                                        const minutes = Math.floor((elapsedSeconds % 3600) / 60);
                                                                        const seconds = elapsedSeconds % 60;

                                                                        const formatted = formatTime(hours24, minutes, seconds);

                                                                        document.getElementById('session-timer').textContent = formatted;

                                                                        // تخزين القيمة الجديدة
                                                                        localStorage.setItem('elapsedSeconds', elapsedSeconds);
                                                                    }

                                                                    // تحديث كل ثانية
                                                                    setInterval(updateSessionTimer, 1000);

                                                                    // عرض أول مرة بدون تأخير
                                                                    updateSessionTimer();
                                                                </script>




                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                                                    <i class="fas fa-users"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mt-3 mb-0 text-muted text-sm">
                                                            <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                                            <span class="text-nowrap">Since yesterday</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="card card-stats mb-4 mb-xl-0">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>
                                                                <span id="current-date" class="h2 font-weight-bold mb-0">--</span>

                                                                <script>
                                                                    function formatDate(date) {
                                                                        const year = date.getFullYear();
                                                                        const month = date.getMonth() + 1; // الشهور تبدأ من 0
                                                                        const day = date.getDate();

                                                                        // إضافة صفر للشفرة الأقل من 10
                                                                        const mm = month < 10 ? '0' + month : month;
                                                                        const dd = day < 10 ? '0' + day : day;

                                                                        return `${year}-${mm}-${dd}`;
                                                                    }

                                                                    document.addEventListener('DOMContentLoaded', () => {
                                                                        const dateSpan = document.getElementById('current-date');
                                                                        const today = new Date();
                                                                        dateSpan.textContent = formatDate(today);
                                                                    });
                                                                </script>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                                    <i class="fas fa-percent"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mt-3 mb-0 text-muted text-sm">
                                                            <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                                                            <span class="text-nowrap">Since last month</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Page content -->
                        </div>



                        <div class="row p-3">
                            <ul class="visitor-list" style="list-style:none; padding:0;">
                                <li class="visitor-header" style="font-weight:bold; display:flex; gap:20px; padding:10px 0;">
                                    <span>ID</span>
                                    <span>IP</span>
                                    <span>Country</span>
                                    <span>Date & Time</span>
                                    <span>Delete</span>
                                </li>
                                <?php
                                $res = $conn->query("SELECT * FROM visitors ORDER BY id DESC");
                                if ($res && $res->num_rows > 0) {
                                    while ($row = $res->fetch_assoc()) {
                                ?>
                                        <li class="visitor-item" style="display:flex; gap:20px; padding:8px 0; border-bottom:1px solid #ccc; align-items:center;">
                                            <span><?= htmlspecialchars($row['id']) ?></span>
                                            <span><?= htmlspecialchars($row['ip_address']) ?></span>
                                            <span><?= htmlspecialchars($row['country']) ?></span>
                                            <span><?= htmlspecialchars($row['visit_time']) ?></span>
                                            <span>
                                                <a href="?delete_visitor=<?= urlencode($row['id']) ?>"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا الزائر؟')"
                                                    style="color:red; text-decoration:none; font-size:18px;">x</a>
                                            </span>
                                        </li>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <li class="mt-5 mb-5">No visitors yet</li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>

                    </div>



                </div>


            </div>

        </div>
    </section>



    <div class="hover_section" id="hover_section">
        <section class="container position_input">
            <header class="header_exit">

                <p>
                    Registration Form

                </p>

                <button id="exit">x</button>

            </header>
            <form class="form" method="POST" enctype="multipart/form-data">
                <div class="input-box">
                    <label>title</label>
                    <input required="" placeholder="Enter full title" type="text" name="title">
                </div>
                <div class="column">
                    <div class="input-box">
                        <label>link </label>
                        <input required="" placeholder="Enter phone link" name="link" type="text">
                    </div>
                    <div class="input-box">
                        <label> Date</label>
                        <input required="" placeholder="Enter birth date" name="date" type="date">
                    </div>
                </div>
                <div class="gender-box">
                    <label>Img</label>
                    <div class="gender-option">

                        <div class="gender">
                            <!-- هذا زر اختيار النوع، يمكنك الإبقاء عليه إن أردت -->
                            <input type="radio" name="gender" id="check-male" checked>


                            <input type="file" id="cover_image" name="cover_image" required style="display: none;">
                            <label for="cover_image" style="cursor: pointer;">Upload Cover Image</label>

                        </div>


                        <div class="gender">
                            <input type="radio" name="gender" id="check-male" checked>

                            <input type="file" id="second_image" name="second_image" required style="display: none;">
                            <label for="second_image" style="cursor: pointer;">Upload Second Image</label>
                        </div>
                    </div>
                </div>
                <div class="input-box address">
                    <label>description</label>
                    <input required="" name="description" placeholder="Enter street description" type="text">

                </div>
                <button type="submit" name="add">Add Card</button>
            </form>
        </section>
    </div>





    <script>
        let hover_section = document.getElementById('hover_section');
        let exit = document.getElementById('exit');
        let close_input = document.getElementById('close_input');


        close_input.addEventListener('click', function() {
            hover_section.style.display = 'flex'
        })

        exit.addEventListener('click', function() {
            hover_section.style.display = 'none'
        })
    </script>


    <script>
        window.onload = () => {
            const links = document.querySelectorAll('.nav-link');
            const items = document.querySelectorAll('.item');

            let savedCategory = localStorage.getItem('selectedCategory');
            let cat = savedCategory ? savedCategory : links[0].getAttribute('href').substring(1);

            for (let i = 0; i < items.length; i++)
                items[i].style.display = items[i].classList.contains(cat) ? 'block' : 'none';

            for (let i = 0; i < links.length; i++) {
                links[i].onclick = e => {
                    e.preventDefault();
                    let c = links[i].getAttribute('href').substring(1);
                    localStorage.setItem('selectedCategory', c);
                    for (let j = 0; j < items.length; j++)
                        items[j].style.display = items[j].classList.contains(c) ? 'block' : 'none';
                };
            }
        };
    </script>

    <style>
        li.visitor-header {
            justify-content: space-between;
        }

        li.visitor-item {
            justify-content: space-between;
            padding: 20px 0 !important;
        }
    </style>
</body>

</html>