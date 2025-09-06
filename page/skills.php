<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$skillsData = [
    "Front End Development" => [
        ["title" => "Skill", "value" => "HTML", "info" => "Used in structure", "year" => 2022],
        ["title" => "Skill", "value" => "CSS", "info" => "Styling pages", "year" => 2022],
        ["title" => "Skill", "value" => "SASS", "info" => "Advanced CSS", "year" => 2022],
        ["title" => "Framework", "value" => "Tailwind CSS", "info" => "Utility-first CSS framework", "year" => 2024],
        ["title" => "Skill", "value" => "JavaScript", "info" => "Dynamic content", "year" => 2022],
        ["title" => "Skill", "value" => "Jquery", "info" => "DOM manipulation", "year" => 2022],
        ["title" => "Framework", "value" => "Bootstrap", "info" => "UI framework", "year" => 2022],
        ["title" => "Skill", "value" => "API", "info" => "External data handling", "year" => 2023],
    ],
    "Basic Programming" => [
        ["title" => "Language", "value" => "C++", "info" => "OOP basics", "year" => 2023],
        ["title" => "Language", "value" => "C", "info" => "Low-level programming", "year" => 2023],
        ["title" => "Language", "value" => "Python", "info" => "General purpose", "year" => 2022],
        ["title" => "Language", "value" => "PHP", "info" => "Server-side scripting", "year" => 2022],
        ["title" => "Language", "value" => "SQL", "info" => "Databases queries", "year" => 2022],
        ["title" => "Format", "value" => "JSON", "info" => "Lightweight data-interchange format", "year" => 2023],
        ["title" => "Language", "value" => "CS", "info" => "General computer science", "year" => 2023],
        ["title" => "Framework", "value" => "Vue.js", "info" => "Frontend framework", "year" => 2023],
    ],
    "Security & Protection" => [
        ["title" => "Concept", "value" => "Security", "info" => "System and web protection", "year" => 2024],
        ["title" => "Vulnerability", "value" => "SQL Injection", "info" => "Database security testing", "year" => 2024],
        ["title" => "Task", "value" => "Website Maintenance", "info" => "Keeping site updated and secure", "year" => 2024],
        ["title" => "Task", "value" => "Website Editing", "info" => "Fixing and improving existing site", "year" => 2024],
    ],
    "UI/UX & Design" => [
        ["title" => "Tool", "value" => "Figma", "info" => "UI/UX design tool", "year" => 2023],
        ["title" => "Tool", "value" => "Canva", "info" => "Graphic design", "year" => 2022],
        ["title" => "Tool", "value" => "Photoshop", "info" => "Design editing", "year" => 2022],
        ["title" => "Resource", "value" => "Dribbble", "info" => "Design inspiration", "year" => 2023],
        ["title" => "Resource", "value" => "Behance", "info" => "Creative showcase", "year" => 2023],
        ["title" => "Tool", "value" => "Color Hunt", "info" => "Color palettes", "year" => 2022],
        ["title" => "Tool", "value" => "Pinterest", "info" => "Visual discovery", "year" => 2022],
    ],
    "Libraries & Animations" => [
        ["title" => "Library", "value" => "Chart.js", "info" => "Simple HTML5 Charts for JavaScript", "year" => 2024],
        ["title" => "Library", "value" => "Get Waves", "info" => "UI wave effect", "year" => 2022],
        ["title" => "Library", "value" => "Owl Carousel", "info" => "Image slider plugin", "year" => 2022],
        ["title" => "Library", "value" => "Swiper.js", "info" => "Modern mobile slider", "year" => 2023],
        ["title" => "Library", "value" => "Splide", "info" => "Lightweight slider", "year" => 2023],
        ["title" => "Tool", "value" => "Uiverse", "info" => "UI components", "year" => 2023],
    ],
    "Development Tools" => [
        ["title" => "Tool", "value" => "Git", "info" => "Version control", "year" => 2022],
        ["title" => "Tool", "value" => "GitHub", "info" => "Code hosting", "year" => 2022],
        ["title" => "Tool", "value" => "VS Code", "info" => "Source-code editor", "year" => 2022],
        ["title" => "Tool", "value" => "Cmdr", "info" => "Terminal emulator", "year" => 2022],
        ["title" => "Tool", "value" => "Command Line", "info" => "Shell interface", "year" => 2022],
        ["title" => "Tool", "value" => "MAMP/MAMP PRO", "info" => "Local server environment", "year" => 2022],
        ["title" => "Tool", "value" => "CodePen", "info" => "Online code editor", "year" => 2022],
        ["title" => "Tool", "value" => "Vercel", "info" => "Frontend deployment", "year" => 2023],
        ["title" => "Tool", "value" => "Mockaroo", "info" => "Dummy data generation", "year" => 2023],
    ],
    "AI & Productivity" => [
        ["title" => "Tool", "value" => "ChatGPT", "info" => "AI coding assistant", "year" => 2024],
        ["title" => "Tool", "value" => "Gemini", "info" => "AI assistant", "year" => 2024],
        ["title" => "Tool", "value" => "DeepSeek", "info" => "AI search engine", "year" => 2024],
        ["title" => "Tool", "value" => "Galileo AI", "info" => "UI design from text", "year" => 2024],
        ["title" => "Tool", "value" => "Roadmap", "info" => "Planning & strategy", "year" => 2023],
        ["title" => "Resource", "value" => "Programming Books", "info" => "Continuous learning", "year" => 2022],
    ],
    "Graphics & Assets" => [
        ["title" => "Resource", "value" => "Google Fonts", "info" => "Web typography", "year" => 2022],
        ["title" => "Resource", "value" => "Font Awesome", "info" => "Icon library", "year" => 2022],
        ["title" => "Tool", "value" => "Iconify", "info" => "Icon library", "year" => 2022],
        ["title" => "Resource", "value" => "Open Doodles", "info" => "Free vector illustrations", "year" => 2023],
        ["title" => "Resource", "value" => "Blush", "info" => "Customizable illustrations", "year" => 2023],
        ["title" => "Tool", "value" => "SVG", "info" => "Vector graphics", "year" => 2022],
        ["title" => "Tool", "value" => "Vector Images", "info" => "Scalable images", "year" => 2022],
    ],
    "Business & Analytics" => [
        ["title" => "Tool", "value" => "Analytics", "info" => "Data analysis", "year" => 2023],
        ["title" => "Concept", "value" => "Speed", "info" => "Website performance", "year" => 2023],
        ["title" => "Resource", "value" => "Awwwards", "info" => "Design inspiration", "year" => 2022],
        ["title" => "Tool", "value" => "Envato", "info" => "Creative assets", "year" => 2022],
        ["title" => "Tool", "value" => "DeviantArt", "info" => "Artistic community", "year" => 2022],
        ["title" => "Concept", "value" => "Production", "info" => "Development lifecycle", "year" => 2023],
    ],
    "SEO & Performance" => [
        ["title" => "Concept", "value" => "SEO", "info" => "Search Engine Optimization", "year" => 2024],
        ["title" => "Concept", "value" => "Performance Optimization", "info" => "Improving website speed", "year" => 2024],
        ["title" => "Concept", "value" => "Clean Code", "info" => "Writing readable, maintainable code", "year" => 2024],
        ["title" => "Task", "value" => "File Structure", "info" => "Organizing project files", "year" => 2024]
    ]
];

$totalSkills = array_sum(array_map('count', $skillsData));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills - Ammar Ahmed | Full Stack Developer</title>
    <meta name="description"
        content="Explore the comprehensive technical skills and tools of Ammar Ahmed, a full stack developer. From front-end and back-end to design, analytics, and AI tools, discover the full range of his expertise, including SEO, clean code, and performance optimization.">
    <link rel="canonical" href="https://eng-ammar.com/assets/page/skills.php" />
    <meta property="og:title" content="Ammar Ahmed's Skills Portfolio" />
    <meta property="og:description"
        content="A detailed breakdown of Ammar Ahmed's professional skills, including web technologies, programming languages, design tools, and more." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://eng-ammar.com/assets/page/skills.php" />
    <meta property="og:image" content="https://eng-ammar.com/assets/img/og-skills.jpg" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body data-barba="wrapper">
    <?php $current_page = 'Skills'; ?>
    <?php include '../includes/loading.php'; ?>
    <main class="main" id="skills" data-barba="container" data-barba-namespace="skills">
        <div class="main-wrap" data-scroll-container>
            <?php include '../includes/header.php'; ?>
            <header class="section default-header work-header archive-header" data-scroll-section>
                <?php include '../includes/nav.php'; ?>
                <div class="container medium">
                    <div class="row">
                        <div class="flex-col once-in">
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
                                            <div class="flex-col phone_none">
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
            </section>s
            <?php include '../includes/footer.php'; ?>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@barba/core@2.10.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.6.1/dist/lazyload.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.js"></script>
    <script src="../assets/js/index-new.js" defer></script>
</body>
</html>