<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$skillsData = [
    "Front End Developer" => [
        ["title" => "Skill", "value" => "HTML", "info" => "Used in structure", "year" => 2022],
        ["title" => "Skill", "value" => "CSS", "info" => "Styling pages", "year" => 2022],
        ["title" => "Skill", "value" => "SASS", "info" => "Advanced CSS", "year" => 2022],
        ["title" => "Skill", "value" => "JavaScript", "info" => "Dynamic content", "year" => 2022],
        ["title" => "Skill", "value" => "Jquery", "info" => "DOM manipulation", "year" => 2022],
        ["title" => "Skill", "value" => "Bootstrap", "info" => "UI framework", "year" => 2022],
        ["title" => "Skill", "value" => "API", "info" => "External data handling", "year" => 2023],
    ],
    "Basics in Programming" => [
        ["title" => "Language", "value" => "C++", "info" => "OOP basics", "year" => 2023],
        ["title" => "Language", "value" => "C", "info" => "Low-level programming", "year" => 2023],
        ["title" => "Language", "value" => "Python", "info" => "General purpose", "year" => 2022],
        ["title" => "Language", "value" => "PHP", "info" => "Server-side scripting", "year" => 2022],
        ["title" => "Language", "value" => "SQL", "info" => "Databases queries", "year" => 2022],
        ["title" => "Language", "value" => "CS", "info" => "General computer science", "year" => 2023],
        ["title" => "Framework", "value" => "Vue.js", "info" => "Frontend framework", "year" => 2023],
        ["title" => "Technology", "value" => "AI", "info" => "Artificial Intelligence basics", "year" => 2024],
    ],
    "Libraries" => [
        ["title" => "Library", "value" => "Get Waves", "info" => "UI wave effect", "year" => 2022],
        ["title" => "Library", "value" => "Owl Carousel", "info" => "Image slider plugin", "year" => 2022],
        ["title" => "Library", "value" => "AOS", "info" => "Scroll animations", "year" => 2023],
        ["title" => "Library", "value" => "Swiper.js", "info" => "Modern mobile slider", "year" => 2023],
        ["title" => "Library", "value" => "Animation", "info" => "CSS/JS effects", "year" => 2023],
    ],
    "System Tools" => [
        ["title" => "Tool", "value" => "Git", "info" => "Version control", "year" => 2022],
        ["title" => "Tool", "value" => "GitHub", "info" => "Code hosting platform", "year" => 2022],
        ["title" => "Tool", "value" => "Vercel", "info" => "Frontend deployment", "year" => 2023],
        ["title" => "Tool", "value" => "Cmdr", "info" => "Terminal emulator", "year" => 2022],
        ["title" => "Tool", "value" => "Command Line", "info" => "Shell interface", "year" => 2022],
        ["title" => "Tool", "value" => "VS Code", "info" => "Source-code editor", "year" => 2022],
        ["title" => "Tool", "value" => "ChatGPT", "info" => "AI coding assistant", "year" => 2024],
    ],
    "Other Tools" => [
        ["title" => "Tool", "value" => "Font Awesome", "info" => "Icon library", "year" => 2022],
        ["title" => "Tool", "value" => "SVG", "info" => "Vector graphics", "year" => 2022],
        ["title" => "Tool", "value" => "Google Fonts", "info" => "Web typography", "year" => 2022],
        ["title" => "Tool", "value" => "Search", "info" => "Search functionality", "year" => 2023],
        ["title" => "Tool", "value" => "Figma", "info" => "UI/UX design tool", "year" => 2023],
        ["title" => "Tool", "value" => "Photoshop", "info" => "Design editing", "year" => 2022],
    ]
];
$totalSkills = array_sum(array_map('count', $skillsData));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Skills</title>

    <link rel="stylesheet" href="../css/main.css ">

</head>

<body data-barba="wrapper">
    <?php $current_page = 'Skills'; ?>

    <?php include './loading.php'; ?>

    <main class="main" id="archive" data-barba="container" data-barba-namespace="archive">
        <div class="main-wrap" data-scroll-container>


            <?php include './header.php'; ?>

            <header class="section default-header work-header archive-header" data-scroll-section>




                <?php include './nav.php'; ?>
                <div class="container medium">

                    <div class="row">
                        <div class="flex-col once-in" style="transform: translate(0px, 0vh);">
                            <h1>
                                <span>
                                    Skills
                                    <div class="count-nr">(<?= htmlspecialchars($totalSkills) ?>)</div>
                                </span>
                            </h1>
                        </div>
                    </div>
                </div>
            </header>

            <section class="section-wrap section-wrap-work once-in archive-work-grid" data-scroll-section>
                <section class="section work-grid tiny-work-grid">
                    <div class="container" id="skills-container">

                        <?php foreach ($skillsData as $category => $skills): ?>
                            <div class="grid-sub-title mb-4">
                                <div class="flex-col">
                                    <h4><?= htmlspecialchars($category) ?></h4>
                                </div>
                            </div>

                            <div class="grid-sub-title">
                                <div class="flex-col">
                                    <h5>Type</h5>
                                </div>
                                <div class="flex-col">
                                    <h5>Name</h5>
                                </div>
                                <div class="flex-col">
                                    <h5>Description</h5>
                                </div>
                                <div class="flex-col">
                                    <h5>Year</h5>
                                </div>
                            </div>

                            <ul class="work-items mouse-pos-list-archive mb-5">
                                <?php foreach ($skills as $skill): ?>
                                    <li>
                                        <div class="stripe animate"></div>
                                        <a href="#" class="row">
                                            <div class="flex-col">
                                                <p><?= htmlspecialchars($skill['title']) ?></p>
                                            </div>
                                            <div class="flex-col animate">
                                                <p><?= htmlspecialchars($skill['value']) ?></p>
                                            </div>
                                            <div class="flex-col animate">
                                                <p><?= htmlspecialchars($skill['info']) ?></p>
                                            </div>
                                            <div class="flex-col animate">
                                                <p><?= htmlspecialchars($skill['year']) ?></p>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endforeach; ?>

                    </div>
                </section>
            </section>

            <?php include './footer.php'; ?>

        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>
    <script src="../js/locomotive-scroll.min.js"></script>
    <script defer src="../js/index-new.js"></script>

</body>

</html>