<?php
// إذا مش محدد $pageTitle، نعطيه قيمة افتراضية
if (!isset($pageTitle)) {
    $pageTitle = "Eng Ammar - Portfolio | مهندس برمجيات ومطور ويب";
}
?>
<title><?php echo htmlspecialchars($pageTitle); ?></title>

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- SEO Meta Tags -->
<meta name="description" content="Eng Ammar - مهندس برمجيات متخصص في تطوير الويب، مع خبرة في HTML, CSS, JavaScript, PHP، والعديد من التقنيات الحديثة. شاهد مشاريعي ومهاراتي." />
<meta name="keywords" content="Eng Ammar, مهندس برمجيات, مطور ويب, HTML, CSS, JavaScript, PHP, Vue.js, AI, Git, Portfolio, برمجة, تطوير مواقع" />
<meta name="author" content="Eng Ammar" />
<meta name="robots" content="index, follow" />
<link rel="canonical" href="https://eng-ammar.com/" />

<!-- Open Graph -->
<meta property="og:type" content="website" />
<meta property="og:title" content="Eng Ammar - مهندس برمجيات ومطور ويب" />
<meta property="og:description" content="اكتشف مهارات Eng Ammar وخبراته في تطوير المواقع والبرمجة بلغات وتقنيات متعددة." />
<meta property="og:url" content="https://eng-ammar.com/" />
<meta property="og:image" content="https://eng-ammar.com/images/og-image.jpg" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="Eng Ammar - صورة ملفي الشخصي" />
<meta property="og:site_name" content="Eng Ammar Portfolio" />
<meta property="og:locale" content="ar_AR" />

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Eng Ammar - مهندس برمجيات ومطور ويب" />
<meta name="twitter:description" content="اكتشف مهارات Eng Ammar وخبراته في تطوير المواقع والبرمجة بلغات وتقنيات متعددة." />
<meta name="twitter:image" content="https://eng-ammar.com/images/twitter-card.jpg" />
<meta name="twitter:site" content="@EngAmmar" />

<!-- Favicons -->
<link rel="icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />

<!-- Schema.org Structured Data -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "Eng Ammar",
        "url": "https://eng-ammar.com",
        "sameAs": [
            "https://www.facebook.com/yourpage",
            "https://twitter.com/EngAmmar",
            "https://www.instagram.com/yourpage",
            "https://www.linkedin.com/in/engammar"
        ],
        "jobTitle": "مهندس برمجيات ومطور ويب",
        "worksFor": {
            "@type": "Organization",
            "name": "Eng Ammar Portfolio"
        },
        "image": "https://eng-ammar.com/images/profile.jpg",
        "description": "مهندس برمجيات بخبرة واسعة في تطوير الويب، اللغات البرمجية، وأدوات التطوير الحديثة."
    }
</script>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ProfessionalService",
        "serviceType": "تطوير ويب وبرمجة",
        "provider": {
            "@type": "Person",
            "name": "Eng Ammar",
            "skills": [
                "HTML - Used in structure",
                "CSS - Styling pages",
                "SASS - Advanced CSS",
                "JavaScript - Dynamic content",
                "jQuery - DOM manipulation",
                "Bootstrap - UI framework",
                "API - External data handling",
                "C++ - OOP basics",
                "C - Low-level programming",
                "Python - General purpose",
                "PHP - Server-side scripting",
                "SQL - Database queries",
                "Computer Science - General knowledge",
                "Vue.js - Frontend framework",
                "Artificial Intelligence - Basics"
            ],
            "tools": [
                "Git - Version control",
                "GitHub - Code hosting",
                "Vercel - Frontend deployment",
                "Cmdr - Terminal emulator",
                "Command Line - Shell interface",
                "VS Code - Source-code editor",
                "ChatGPT - AI coding assistant",
                "Font Awesome - Icon library",
                "SVG - Vector graphics",
                "Google Fonts - Typography",
                "Figma - UI/UX design",
                "Photoshop - Design editing",
                "Get Waves - UI wave effect",
                "Owl Carousel - Image slider",
                "AOS - Scroll animations",
                "Swiper.js - Mobile slider",
                "Animation - CSS/JS effects"
            ]
        }
    }
</script>
<!-- ===================== CSS Libraries ===================== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

<!-- ===================== Project CSS Files ===================== -->
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/css.css " />
<link rel="stylesheet" href="../css/style.css" />

<!-- ===================== Google Fonts ===================== -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Mulish&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

<!-- ===================== Icon Library (Ionicons) ===================== -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<!-- ===================== Favicon ===================== -->
<link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml" />

<!-- ===================== Home Page Local CSS ===================== -->
<link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="./assets/css/css.css " />
<link rel="stylesheet" href="./assets/css/style.css" />

<!-- ===================== Preload Hero Banner ===================== -->
<link rel="preload" as="image" href="./assets/images/hero-banner.jpg" />