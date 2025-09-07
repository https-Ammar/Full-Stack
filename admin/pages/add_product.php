<?php
session_start();

if (!isset($_SESSION['verified_email'])) {
    header("Location: ./auth/verify.php");
    exit();
}

include '../../config/db.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $title = trim($_POST['title']);
    $description = isset($_POST['description']) ? trim($_POST['description']) : null;
    $link = trim($_POST['link']);
    $services = trim($_POST['services']);
    $location = trim($_POST['location']);
    $year = intval($_POST['year']);

    $role = isset($_POST['role']) ? trim($_POST['role']) : null;
    $credits = isset($_POST['credits']) ? trim($_POST['credits']) : null;
    $extra_text = isset($_POST['extra_text']) ? trim($_POST['extra_text']) : null;

    $date = date('Y-m-d');
    $views = 0;

    if ($year < 1901 || $year > 2155) {
        $_SESSION['message'] = "Error: Invalid year entered.";
        $_SESSION['message_type'] = "error";
        header("Location: add-product.php");
        exit();
    } else {
        $images = [];
        $upload_dir = __DIR__ . '/../uploads/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        for ($i = 1; $i <= 6; $i++) {
            $field = "image$i";
            if (!empty($_FILES[$field]['name'])) {
                $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
                $newName = uniqid("img_") . ".$ext";
                move_uploaded_file($_FILES[$field]['tmp_name'], $upload_dir . $newName);
                $images["image$i"] = $newName;
            } else {
                $images["image$i"] = '';
            }
        }

        $stmt = $conn->prepare("INSERT INTO cards (title, description, link, image1, image2, image3, image4, image5, image6, role, services, credits, location, year, extra_text, created_at, views) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssssssssssssssssi",
            $title,
            $description,
            $link,
            $images["image1"],
            $images["image2"],
            $images["image3"],
            $images["image4"],
            $images["image5"],
            $images["image6"],
            $role,
            $services,
            $credits,
            $location,
            $year,
            $extra_text,
            $date,
            $views
        );

        if ($stmt->execute()) {
            $_SESSION['message'] = "Project added successfully!";
            $_SESSION['message_type'] = "success";
            header("Location: Products.php");
            exit();
        } else {
            $_SESSION['message'] = "Error adding project: " . $stmt->error;
            $_SESSION['message_type'] = "error";
            header("Location: add-product.php");
            exit();
        }
        $stmt->close();
    }
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>
    <main>
        <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
            <div x-data="{ pageName: 'Add Product' }">
                <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName">Add Product
                    </h2>
                    <nav>
                        <ol class="flex items-center gap-1.5">
                            <li>
                                <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                    href="index.html">
                                    Home
                                    <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke=""
                                            stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </a>
                            </li>
                            <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName">Add Product</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="space-y-6">
                <?php if ($message): ?>
                    <div id="alertMessage" class="message <?php echo htmlspecialchars($message_type); ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" id="projectForm">
                    <div
                        class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-6">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                                Products Images
                            </h2>
                        </div>
                        <div class="p-4 sm:p-6">
                            <label for="image1"
                                class="shadow-theme-xs group hover:border-brand-500 block cursor-pointer rounded-lg border-2 border-dashed border-gray-300 transition dark:border-gray-800">
                                <div class="flex justify-center p-10">
                                    <div class="flex max-w-[260px] flex-col items-center gap-4">
                                        <div
                                            class="inline-flex h-13 w-13 items-center justify-center rounded-full border border-gray-200 text-gray-700 transition dark:border-gray-800 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M20.0004 16V18.5C20.0004 19.3284 19.3288 20 18.5004 20H5.49951C4.67108 20 3.99951 19.3284 3.99951 18.5V16M12.0015 4L12.0015 16M7.37454 8.6246L11.9994 4.00269L16.6245 8.6246"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </div>
                                        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-medium text-gray-800 dark:text-white/90">Click to
                                                upload</span>
                                            or drag and drop SVG, PNG, JPG or GIF (MAX. 800x400px)
                                        </p>
                                    </div>
                                </div>
                                <input type="file" id="image1" name="image1" class="hidden" required="">
                            </label>
                        </div>
                    </div>


                    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                                Project Information
                            </h2>
                        </div>
                        <div class="p-4 sm:p-6">
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div>
                                    <label for="title"
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Project Title
                                    </label>
                                    <input type="text" id="title" name="title" required
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        placeholder="Enter project title">
                                </div>
                                <div>
                                    <label for="link"
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Project Link
                                    </label>
                                    <input type="text" id="link" name="link" required
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        placeholder="Enter project link">
                                </div>
                                <div>
                                    <label for="location"
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Location
                                    </label>
                                    <input type="text" id="location" name="location" required
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        placeholder="Enter project location">
                                </div>
                                <div>
                                    <label for="year"
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Year
                                    </label>
                                    <input type="number" id="year" name="year" required
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        placeholder="Enter project year">
                                </div>
                                <div>
                                    <label for="services"
                                        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Services
                                    </label>
                                    <input type="text" id="services" name="services" required
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        placeholder="Enter services provided">
                                </div>
                                <div class="col-span-full" id="optionalFields">
                                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                        <div>
                                            <label for="description"
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Description
                                            </label>
                                            <input type="text" id="description" name="description"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                placeholder="Enter project description">
                                        </div>
                                        <div>
                                            <label for="role"
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Role
                                            </label>
                                            <input type="text" id="role" name="role"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                placeholder="Enter your role">
                                        </div>
                                        <div>
                                            <label for="credits"
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Credits
                                            </label>
                                            <input type="text" id="credits" name="credits"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                placeholder="Enter credits">
                                        </div>
                                        <div class="col-span-full">
                                            <label for="extra_text"
                                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                Additional Text
                                            </label>
                                            <textarea id="extra_text" name="extra_text" rows="4"
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full resize-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                placeholder="Enter additional information about the project"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mt-6"
                        id="additionalImagesSection">
                        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                            <h2 class="text-lg font-medium text-gray-800 dark:text-white">
                                Additional Project Images
                            </h2>
                        </div>
                        <div class="p-4 sm:p-6">
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        PC Image
                                    </label>
                                    <input type="file" name="image2" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Phone Image 1
                                    </label>
                                    <input type="file" name="image3" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Phone Image 2
                                    </label>
                                    <input type="file" name="image4" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Phone Image 3
                                    </label>
                                    <input type="file" name="image5" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Phone Image 4
                                    </label>
                                    <input type="file" name="image6" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mt-6">
                        <div class="p-4 sm:p-6">
                            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">


                                <button type="button" id="toggleFieldsBtn"
                                    class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                                    Toggle Optional Fields
                                </button>


                                <button type="submit" name="add"
                                    class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition">
                                    Add Product
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bundle.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('toggleFieldsBtn');
            const additionalImagesSection = document.getElementById('additionalImagesSection');
            const optionalFields = document.getElementById('optionalFields');

            const savedState = localStorage.getItem('optionalFieldsState');
            if (savedState === 'shown') {
                additionalImagesSection.style.display = 'block';
                optionalFields.style.display = 'block';
                toggleButton.textContent = 'Hide Optional Fields';
            } else {
                additionalImagesSection.style.display = 'none';
                optionalFields.style.display = 'none';
                toggleButton.textContent = 'Show Optional Fields';
            }

            toggleButton.addEventListener('click', function () {
                if (additionalImagesSection.style.display === 'none') {
                    additionalImagesSection.style.display = 'block';
                    optionalFields.style.display = 'block';
                    toggleButton.textContent = 'Hide Optional Fields';
                    localStorage.setItem('optionalFieldsState', 'shown');
                } else {
                    additionalImagesSection.style.display = 'none';
                    optionalFields.style.display = 'none';
                    toggleButton.textContent = 'Show Optional Fields';
                    localStorage.setItem('optionalFieldsState', 'hidden');
                }
            });
            const alertMessage = document.getElementById('alertMessage');
            if (alertMessage) {
                setTimeout(() => {
                    alertMessage.style.display = 'none';
                }, 2000);
            }
        });
    </script>
</body>

</html>