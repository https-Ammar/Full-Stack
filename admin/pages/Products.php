<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['verified_email'])) {
    header("Location: ./auth/verify.php");
    exit();
}
include '../../config/db.php';
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
                @unlink("../assets/uploads/$img");
            }
        }
    }
    $res->close();
    $del = $conn->prepare("DELETE FROM cards WHERE id = ?");
    $del->bind_param("i", $id);
    $del->execute();
    $del->close();
    header("Location: ./Products.php");
    exit();
}
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$result = $conn->query("SELECT COUNT(*) as total FROM cards");
$total_rows = $result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);
$result = $conn->query("SELECT *, DATE(created_at) AS created_date FROM cards ORDER BY id DESC LIMIT $limit OFFSET $offset");
$cards = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body x-data="{ 
        page: 'ecommerce', 
        loaded: true, 
        darkMode: JSON.parse(localStorage.getItem('darkMode') || 'false'), 
        stickyMenu: false, 
        sidebarToggle: false, 
        scrollTop: false,
        menuToggle: false
    }" x-init="$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}">
    <header
        class="sticky top-0 z-99999 flex w-full border-gray-200 bg-white xl:border-b dark:border-gray-800 dark:bg-gray-900">
        <div class="flex grow flex-col items-center justify-between xl:flex-row xl:px-6">
            <div
                class="flex w-full items-center justify-between gap-2 border-b border-gray-200 px-3 py-3 sm:gap-4 lg:py-4 xl:justify-normal xl:border-b-0 xl:px-0 dark:border-gray-800">
                <button
                    :class="sidebarToggle ? 'xl:bg-transparent dark:xl:bg-transparent bg-gray-100 dark:bg-gray-800' : ''"
                    class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg border-gray-200 text-gray-500 xl:h-11 xl:w-11 xl:border dark:border-gray-800 dark:text-gray-400"
                    @click.stop="sidebarToggle = !sidebarToggle">
                    <i class="bi bi-list xl:block hidden" style="font-size:16px;"></i>
                    <i :class="sidebarToggle ? 'hidden' : 'block xl:hidden'" class="bi bi-list block xl:hidden"
                        style="font-size:24px;"></i>
                    <i :class="sidebarToggle ? 'block xl:hidden' : 'hidden'" class="bi bi-x hidden"
                        style="font-size:24px;"></i>
                </button>
                <button
                    class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 xl:hidden dark:text-gray-400 dark:hover:bg-gray-800"
                    :class="menuToggle ? 'bg-gray-100 dark:bg-gray-800' : ''" @click.stop="menuToggle = !menuToggle">
                    <i class="bi bi-three-dots-vertical" style="font-size:24px;"></i>
                </button>
            </div>
            <div :class="menuToggle ? 'flex' : 'hidden xl:flex'"
                class="shadow-theme-md w-full items-center justify-between gap-4 px-5 py-4 xl:flex xl:justify-end xl:px-0 xl:shadow-none">
                <div class="2xsm:gap-3 flex items-center gap-2">
                    <button
                        class="hover:text-dark-900 relative flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white">
                        <a href="./auth/logout.php" class="flex items-center gap-3">
                            <i class="bi bi-box-arrow-right fill-gray-500 group-hover:fill-gray-700 dark:group-hover:fill-gray-300"
                                style="font-size:24px;"></i>
                        </a>
                    </button>
                    <button
                        class="hover:text-dark-900 relative flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                        @click.prevent="darkMode = !darkMode">
                        <i x-show="darkMode" class="bi bi-sun-fill" style="font-size:20px;"></i>
                        <i x-show="!darkMode" class="bi bi-moon-fill" style="font-size:20px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-(--breakpoint-2xl) px-5 py-4 md:p-6">
            <div>
                <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Products</h2>
                    <nav>
                        <ol class="flex items-center gap-1.5">
                            <li>
                                <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                    href="../index.php">
                                    Home
                                    <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke=""
                                            stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </a>
                            </li>
                            <li class="text-sm text-gray-800 dark:text-white/90">Products</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div
                            class="flex flex-col justify-between gap-5 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center dark:border-gray-800">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Products List</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Track your store's progress to boost
                                    your sales.</p>
                            </div>
                            <div class="flex gap-3">
                                <a href="./add_Product.php">
                                    <button
                                        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path d="M5 10.0002H15.0006M10.0002 5V15.0006" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        Add Product
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="custom-scrollbar overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:divide-gray-800 dark:border-gray-800">
                                        <th class="w-14 px-5 py-4 text-left">
                                            <label
                                                class="cursor-pointer text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                                <input type="checkbox" class="sr-only">
                                                <span
                                                    class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                    <span class="opacity-0">
                                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                                stroke-width="1.6666" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </svg>
                                                    </span>
                                                </span>
                                            </label>
                                        </th>
                                        <th
                                            class="cursor-pointer px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center gap-3">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Products</p>
                                                <span class="flex flex-col gap-0.5">
                                                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="text-gray-500 dark:text-gray-400">
                                                        <path
                                                            d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="text-gray-300 dark:text-gray-400/50">
                                                        <path
                                                            d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </th>
                                        <th
                                            class="cursor-pointer px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center gap-3">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    location</p>
                                            </div>
                                        </th>
                                        <th
                                            class="cursor-pointer px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center gap-3">
                                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                                    views</p>
                                            </div>
                                        </th>
                                        <th
                                            class="px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            Services</th>
                                        <th
                                            class="px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            year</th>
                                        <th
                                            class="px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            Created At</th>
                                        <th
                                            class="px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-x divide-y divide-gray-200 dark:divide-gray-800">
                                    <?php foreach ($cards as $card): ?>
                                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                                            <td class="w-14 px-5 py-4 whitespace-nowrap">
                                                <label
                                                    class="cursor-pointer text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                                    <input type="checkbox" class="sr-only">
                                                    <span
                                                        class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] bg-transparent border-gray-300 dark:border-gray-700">
                                                        <span class="opacity-0">
                                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M10 3L4.5 8.5L2 6" stroke="white"
                                                                    stroke-width="1.6666" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                </label>
                                            </td>
                                            <td class="px-5 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    <?php if (!empty($card["image1"])): ?>
                                                        <div class="h-12 w-12">
                                                            <img src="../uploads/<?= htmlspecialchars($card["image1"]) ?>"
                                                                class="h-12 w-12 rounded-md" alt="">
                                                        </div>
                                                    <?php endif; ?>
                                                    <span
                                                        class="text-sm font-medium text-gray-700 dark:text-gray-400"><?= htmlspecialchars($card['title']) ?></span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 whitespace-nowrap">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    <?= htmlspecialchars($card['location']) ?>
                                                </p>
                                            </td>
                                            <td class="px-5 py-4 whitespace-nowrap">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    <?= htmlspecialchars($card['views']) ?>
                                                </p>
                                            </td>
                                            <td class="px-5 py-4 whitespace-nowrap">
                                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                                    <?= htmlspecialchars($card['services'] ?? '---') ?>
                                                </p>
                                            </td>
                                            <td class="px-5 py-4 whitespace-nowrap">
                                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                                    <?= htmlspecialchars($card['year']) ?>
                                                </p>
                                            </td>
                                            <td class="px-5 py-4 whitespace-nowrap">
                                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                                    <?= htmlspecialchars($card['created_date'] ?? '---') ?>
                                                </p>
                                            </td>
                                            <td class="px-5 py-4 whitespace-nowrap">
                                                <div class="relative flex justify-center">
                                                    <a href="?delete=<?= $card['id'] ?>"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this product?')">

                                                        <svg class="cursor-pointer hover:fill-error-500 dark:hover:fill-error-500 fill-gray-700 dark:fill-gray-400"
                                                            width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M6.54142 3.7915C6.54142 2.54886 7.54878 1.5415 8.79142 1.5415H11.2081C12.4507 1.5415 13.4581 2.54886 13.4581 3.7915V4.0415H15.6252H16.666C17.0802 4.0415 17.416 4.37729 17.416 4.7915C17.416 5.20572 17.0802 5.5415 16.666 5.5415H16.3752V8.24638V13.2464V16.2082C16.3752 17.4508 15.3678 18.4582 14.1252 18.4582H5.87516C4.63252 18.4582 3.62516 17.4508 3.62516 16.2082V13.2464V8.24638V5.5415H3.3335C2.91928 5.5415 2.5835 5.20572 2.5835 4.7915C2.5835 4.37729 2.91928 4.0415 3.3335 4.0415H4.37516H6.54142V3.7915ZM14.8752 13.2464V8.24638V5.5415H13.4581H12.7081H7.29142H6.54142H5.12516V8.24638V13.2464V16.2082C5.12516 16.6224 5.46095 16.9582 5.87516 16.9582H14.1252C14.5394 16.9582 14.8752 16.6224 14.8752 16.2082V13.2464ZM8.04142 4.0415H11.9581V3.7915C11.9581 3.37729 11.6223 3.0415 11.2081 3.0415H8.79142C8.37721 3.0415 8.04142 3.37729 8.04142 3.7915V4.0415ZM8.3335 7.99984C8.74771 7.99984 9.0835 8.33562 9.0835 8.74984V13.7498C9.0835 14.1641 8.74771 14.4998 8.3335 14.4998C7.91928 14.4998 7.5835 14.1641 7.5835 13.7498V8.74984C7.5835 8.33562 7.91928 7.99984 8.3335 7.99984ZM12.4168 8.74984C12.4168 8.33562 12.081 7.99984 11.6668 7.99984C11.2526 7.99984 10.9168 8.33562 10.9168 8.74984V13.7498C10.9168 14.1641 11.2526 14.4998 11.6668 14.4998C12.081 14.4998 12.4168 14.1641 12.4168 13.7498V8.74984Z"
                                                                fill=""></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="flex flex-col items-center justify-between border-t border-gray-200 px-5 py-4 sm:flex-row dark:border-gray-800">
                            <div class="pb-3 sm:pb-0">
                                <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Showing
                                    <span class="text-gray-800 dark:text-white/90"><?= $offset + 1 ?></span>
                                    to
                                    <span
                                        class="text-gray-800 dark:text-white/90"><?= min($offset + $limit, $total_rows) ?></span>
                                    of
                                    <span class="text-gray-800 dark:text-white/90"><?= $total_rows ?></span>
                                </span>
                            </div>
                            <div
                                class="flex w-full items-center justify-between gap-2 rounded-lg bg-gray-50 p-4 sm:w-auto sm:justify-normal sm:rounded-none sm:bg-transparent sm:p-0 dark:bg-gray-900 dark:sm:bg-transparent">
                                <a href="?page=<?= $page - 1 ?>"
                                    class="<?= $page <= 1 ? 'pointer-events-none opacity-50' : '' ?>">
                                    <button
                                        class="shadow-theme-xs flex items-center gap-2 rounded-lg border border-gray-300 bg-white p-2 text-gray-700 hover:bg-gray-50 hover:text-gray-800 disabled:cursor-not-allowed disabled:opacity-50 sm:p-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                                        <?= $page <= 1 ? 'disabled' : '' ?>>
                                        <span>
                                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M2.58203 9.99868C2.58174 10.1909 2.6549 10.3833 2.80152 10.53L7.79818 15.5301C8.09097 15.8231 8.56584 15.8233 8.85883 15.5305C9.15183 15.2377 9.152 14.7629 8.85921 14.4699L5.13911 10.7472L16.6665 10.7472C17.0807 10.7472 17.4165 10.4114 17.4165 9.99715C17.4165 9.58294 17.0807 9.24715 16.6665 9.24715L5.14456 9.24715L8.85919 5.53016C9.15199 5.23717 9.15184 4.7623 8.85885 4.4695C8.56587 4.1767 8.09099 4.17685 7.79819 4.46984L2.84069 9.43049C2.68224 9.568 2.58203 9.77087 2.58203 9.99715C2.58203 9.99766 2.58203 9.99817 2.58203 9.99868Z">
                                                </path>
                                            </svg>
                                        </span>
                                    </button>
                                </a>
                                <span class="block text-sm font-medium text-gray-700 sm:hidden dark:text-gray-400">
                                    Page <span><?= $page ?></span> of <span><?= $total_pages ?></span>
                                </span>
                                <ul class="hidden items-center gap-0.5 sm:flex">
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li>
                                            <a href="?page=<?= $i ?>"
                                                class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium <?= $i == $page ? 'bg-brand-500 text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' ?>">
                                                <span><?= $i ?></span>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                                <a href="?page=<?= $page + 1 ?>"
                                    class="<?= $page >= $total_pages ? 'pointer-events-none opacity-50' : '' ?>">
                                    <button
                                        class="shadow-theme-xs flex items-center gap-2 rounded-lg border border-gray-300 bg-white p-2 text-gray-700 hover:bg-gray-50 hover:text-gray-800 disabled:cursor-not-allowed disabled:opacity-50 sm:p-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                                        <?= $page >= $total_pages ? 'disabled' : '' ?>>
                                        <span>
                                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M17.4165 9.9986C17.4168 10.1909 17.3437 10.3832 17.197 10.53L12.2004 15.5301C11.9076 15.8231 11.4327 15.8233 11.1397 15.5305C10.8467 15.2377 10.8465 14.7629 11.1393 14.4699L14.8594 10.7472L3.33203 10.7472C2.91782 10.7472 2.58203 10.4114 2.58203 9.99715C2.58203 9.58294 2.91782 9.24715 3.33203 9.24715L14.854 9.24715L11.1393 5.53016C10.8465 5.23717 10.8467 4.7623 11.1397 4.4695C11.4327 4.1767 11.9075 4.17685 12.2003 4.46984L17.1578 9.43049C17.3163 9.568 17.4165 9.77087 17.4165 9.99715C17.4165 9.99763 17.4165 9.99812 17.4165 9.9986Z">
                                                </path>
                                            </svg>
                                        </span>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>